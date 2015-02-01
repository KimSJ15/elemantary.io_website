<?php
    include '_templates/sitewide.php';
    $page['title'] = 'Support &sdot; elementary';
    $page['scripts'] .= '<link rel="stylesheet" type="text/css" media="all" href="styles/support.css">';
    include '_templates/header.php';
?>
            <div class="row">
                <h1>Get support for <?php include("./images/logotype.svg"); ?></h1>
            </div>
            <div class="row">
                <a class="column half" href="#">
                    <h2><i class="fa fa-question-circle"></i> FAQ</h2>
                    <p>Has your question been asked already? Check out answers to some of the most common questions we get.</p>
                </a>
                <a class="column half" href="/installation">
                    <h2><i class="fa fa-download"></i> Installation</h2>
                    <p>Get help installing elementary OS on your computer by following our step-by-step guide.</p>
                </a>
                <a class="column half" href="https://plus.google.com/communities/104613975513761463450" target="_blank">
                    <h2><i class="fa fa-google-plus"></i> Google+</h2>
                    <p>Communicate with other elementary OS users in our Google+ community. Find crowd-sourced support, screenshots, the latest news, and more.</p>
                </a>
                <a class="column half" href="http://www.reddit.com/r/elementaryos/" target="_blank">
                    <h2><i class="fa fa-reddit"></i> reddit</h2>
                    <p>Discuss elementary OS with other fans and followers in our official subreddit. Ask the community for help or just chat about the OS.</p>
                </a>
            </div>
            <div class="row">
                <a class="column" href="https://bugs.launchpad.net/elementary/+filebug" target="_blank">
                    <h2><i class="fa fa-bug"></i> Report a bug</h2>
                    <p>Unable to resolve your issue? Let our developers know by filing a bug on Launchpad.</p>
                </a>
            </div>

<?php
    include '_templates/footer.html';
?>
