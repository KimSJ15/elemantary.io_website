<?php
function user_lang() {
    if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        return null;
    }
    if (isset($_GET['lang'])) {
        return strtolower(substr($_GET['lang'], 0, 2));
    }

    return strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
}

function lang_dir($lang) {
    return dirname(__FILE__).'/../lang/'.$lang;
}

function is_lang($lang) {
    if (!preg_match('#^[a-z]{2}$#', $lang)) {
        return false;
    }

    return is_dir(lang_dir($lang));
}

function load_translations($index, $lang) {
    if (!is_lang($lang)) {
        return false;
    }

    $langFile = lang_dir($lang).'/'.$index.'.json';
    if (!file_exists($langFile)) {
        return false;
    }

    $json = file_get_contents($langFile);
    return json_decode($json, true);
}

$lang = user_lang();
if (!is_lang($lang)) {
    $lang = 'en';
}

$l10nDomain = null;
$translations = array();
function set_l10n_domain($domain) {
    global $lang, $l10nDomain, $translations;

    if (ob_get_level()) {
        ob_flush(); // Flush output buffer
    }

    $l10nDomain = $domain;

    if (!isset($translations[$domain])) {
        $translations[$domain] = load_translations($domain, $lang);
    }
}

/**
 * Translate a string. Returns the original string if no translation was found.
 */
function translate($string, $domain) {
    global $translations;

    if (isset($translations[$domain][$string]) &&
        is_string($translations[$domain][$string])) {
        return $translations[$domain][$string];
    } else {
        return $string;
    }
}

/**
 * Translate a HTML string. This includes a minimalist XML parser.
 * Can be provided a $translate callback to override default behaviour.
 * (Useful to extract strings from a file for instance.)
 */
function translate_html($input, $translate = 'translate') {
    global $l10nDomain;

    $output = ''; // Output HTML string

    // Tags that doesn't contain translatable text
    $tagsBlacklist = array('script', 'kbd');

    // Attributes that can be translated
    $attrsWhitelist = array(
        'input' => array('placeholder'),
        'a' => array('title'),
        'img' => array('alt')
    );

    // Begin parsing input HTML
    $i = 0;
    $tagName = '';
    $l10nId = '';
    while ($i < strlen($input)) {
        $char = $input[$i]; // Current char
        $next = $i + 1;

        if ($char == '<') {
            $next = strpos($input, '>', $i);
            $tag = substr($input, $i + 1, $next - $i - 1);

            // Parse <tag>
            $attrsStart = strpos($tag, ' ');
            if ($attrsStart !== false) {
                $tagName = substr($tag, 0, $attrsStart);

                if (isset($attrsWhitelist[$tagName])) {
                    $allowedTags = $attrsWhitelist[$tagName];

                    $attrsString = substr($tag, $attrsStart + 1);
                    $tag = substr($tag, 0, $attrsStart + 1);

                    $attrs = $attrsString;

                    // Parse attributes
                    $j = 0;
                    while ($j < strlen($attrs)) {
                        $char = $attrs[$j];

                        if ($j == 0 || $char == ' ') {
                            if ($char == ' ') {
                                $j++;
                            }

                            $nameEnd = strpos($attrs, '=', $j);
                            if ($nameEnd === false) {
                                break;
                            }
                            $valueEnd = strpos($attrs, '"', $nameEnd + 2);
                            if ($valueEnd === false) {
                                break;
                            }

                            $name = substr($attrs, $j, $nameEnd - $j);
                            $value = substr($attrs, $nameEnd + 2, $valueEnd - ($nameEnd + 2));

                            if ($name == 'data-l10n-id') {
                                $l10nId = $value;
                            }
                            if (in_array($name, $allowedTags)) {
                                $tag .= ' '.$name.'="'.$translate($value, $l10nDomain).'"';
                            } else {
                                $tag .= ' '.substr($attrs, $j, $valueEnd - $j + 1);
                            }
                            $j = $valueEnd + 1;
                        } else {
                            break;
                        }
                    }
                    if ($j < strlen($attrs)) {
                        $tag .= substr($attrs, $j);
                    }
                }
            } else {
                $tagName = $tag;
            }

            $output .= '<'.$tag.'>';
        } else {
            $next = strpos($input, '<', $i);
            if ($next === false) {
                $next = strlen($input);
            } elseif ($tagName == 'p') { // Do not process <a> in <p>
                $originalNext = $next;
                $linksNbr = 0;
                while ($input[$next + 1] == 'a') { // Skip all <a>
                    $linkEnd = strpos($input, '</a>', $next);
                    $next = strpos($input, '<', $linkEnd + 1);
                    $linksNbr++;
                }

                // Just one link in the <p> ?
                if ($linksNbr == 1 && substr($input, $originalNext, 3) == '<a ' && substr($input, $next - 4, 4) == '</a>') {
                    $next = $originalNext;
                }
            }

            if (!empty($l10nId)) {
                $text = $translate($l10nId, $l10nDomain);
                $l10nId = '';
            } else {
                $text = substr($input, $i + 1, $next - $i - 1);
                if (!in_array($tagName, $tagsBlacklist)) {
                    $cleanedText = trim($text);
                    if (!empty($cleanedText)) {
                        // Properly re-inject whitespaces
                        $text = substr($text, 0, strpos($text, $cleanedText[0])) .
                            $translate($cleanedText, $l10nDomain) .
                            substr($text, strrpos($text, substr($cleanedText, -1)) + 1);
                    }
                }
            }
            $output .= $text;
        }

        $i = $next;
    }

    return $output;
}

/**
 * Begin to translate outputted HTML.
 */
function begin_html_l10n() {
    if (defined('HTML_I18N')) { // Do not allow nested output buffering
        return;
    }
    define('HTML_I18N', 1);

    ob_start(function ($input) {
        return translate_html($input);
    });
}
/**
 * End outputted HTML translation.
 */
function end_html_l10n() {
    if (!ob_get_level()) {
        return;
    }

    ob_end_flush();
}