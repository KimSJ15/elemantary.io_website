<?php
    include '_templates/sitewide.php';
    $page['title'] = 'Installation';
    include '_templates/header.php';
?>
            <div class="row">
                <h1>Installation</h1>
                <p>elementary is designed to run on any relatively new 32-bit and 64-bit desktop or laptop. In this section, we'll cover system requirements and other pre-requisites to installing elementary on your computer.</p>

                <h2>System Requirements</h2>

                <p>Minimum System Requirements:</p>
                <ul>
                    <li>1 GHz x86 or amd64 processor</li>
                    <li>512MB of system memory (RAM)</li>
                    <li>5GB of disk space</li>
                    <li>CD/DVD drive</li>
                </ul>

                <p>Recommended System Requirements:</p>
                <ul>
                    <li>1 GHz x86 or amd64 processor</li>
                    <li>1GB of system memory (RAM)</li>
                    <li>15 GB of disk space</li>
                    <li>CD/DVD Drive or USB port</li>
                    <li>Internet access</li>
                </ul>

                <h2>Downloading elementary</h2>
                <p>If you haven't already, you will need to <a href="index.php">download the elementary OS disk image from our home page</a>. This file is an ISO image — a snapshot of the contents of a bootable disk — which you will need to burn to a CD, DVD, or USB stick.</p>

                <h2>32-bit versus 64-bit</h2>
                <p>Elementary is currently built for two processor architectures, 32-bit and 64-bit. If this sounds a bit technical for you, never fear:</p>
                <ul>
                    <li>If you know you have a newer computer with a 64-bit processor, choose the 64bit version.</li>
                    <li>If your computer is older or you do not know which type of processor your computer has, choose the 32-bit version. (64-bit processors will still be able to run this version).</li>
                </ul>

                <h2>Back Up Your Data</h2>
                <p>While you're waiting for your download to complete, make sure to back up all of your data to an external location such as a cloud service like DropBox or an external hard drive. Installing a new operating system may overwrite your existing data; backing up ensures you won't lose anything precious.</p>

                <h1>Creating an Install Disk</h1>
                <p>To install elementary OS, you'll need some kind of installation media. Either a blank CD or USB stick will work. Each option has its benefits and its drawbacks:</p>

                <ul>
                    <li>CDs are cheaply available and (unless your computer doesn't have a CD drive) your computer should support booting from a CD. If you're unsure which to use, a CD is a safe bet.</li>
                    <li>USB sticks are a lot faster and are reusable. However, if you have an older computer (2003 or older), your computer may not support booting from a USB. If your computer doesn't have a CD drive, chances are it supports booting from USB.</li>
                </ul>

                <h2>Burning a CD</h2>

                <h3>Ubuntu</h3>
                <p>Open Brasero and select: "Burn Image".</p>

                <img src="images/installation/brasero_home.png" alt="Brasero main window">

                <p>In the following window, choose the ISO you just downloaded, and make sure the right disk drive with a blank CD in it is selected.</p>

                <img src="images/installation/brasero_image.png" alt="Burn window">

                <p>Then you simply click: "Create Image", and Brasero does the rest.</p>

                <img src="images/installation/brasero_burning.png" alt="Burning">

                <p>When the disk has finished writing, continue to TODO:Getting Started</p>
            </div>
<?php
    include '_templates/footer.html';
?>
