<?php
/**
 * Prints the possible errors thrown by “index.php” when a user tries to login or
 * register. If the user inputs an incorrect email or password, or if she tries to
 * register with a username that already exists, the content for the respective
 * errors are generated below.
 *
 * If this page is loaded into a browser and $_GET['message_type'] isn’t set, the
 * user is redirected to the root folder.
 *
 * PHP version 5.3.28
 *
 * @category Web_App
 * @package  Web_App
 * @author   Roy Vanegas <roy@thecodeeducators.com>
 * @license  https://gnu.org/licenses/gpl.html GNU General Public License
 * @link     https://bitbucket.org/code-warrior/web-app/
 */

if (isset($_GET['message_type'])) {
    $message_type = $_GET['message_type'];

    switch( $message_type ) {
    case "login_error":
        echo "<!DOCTYPE HTML>
        <html>
            <head>
                <meta charset='utf-8'>
                <title>Login Error</title>

                <link rel='stylesheet' href='css/style.css'>
            </head>
            <body>
                <header class='header'>
                    <nav class='navigation'>
                        <h1 id='logo'>weather box</h1>
                        <div id='menu'>
                            <p>Home</p>
                            <p>About</p>
                            <p>Contact</p>
                        </div>
                        <ul class='snsLink'>
                           <ul><a class='facebook' href='http://www.facebook.com' target='_blank'></a></ul>
                        </ul>
                    </nav>
                </header>
                <div class='greeting'></div>
                <section class='displayBoxes'>
                    <div class='errorMessages'>
                        <h1>Login Error</h1>
                        <p>Invalid username or password. Click
                            <a href='./index.php?action=login'>here</a> to go back to the home page and log in.</p>
                    </div>
                </section>

        <script src='./js/jquery-2.1.4.min.js'></script>
        <script src='./js/jquery-ui.min.js'></script>
        <script src='./js/moment.min.js'></script>
        <script src='./js/moment-timezone-with-data.min.js'></script>
        <script src='./js/main.js'></script>
            </body>
        </html>";

        break;

    case "registration_error":
        echo "<!DOCTYPE HTML>
         <html>
            <head>
               <meta charset='utf-8'>
               <title>Registration Error</title>

               <link rel='stylesheet' href='css/style.css'>
            </head>
            <body>
                <header class='header'>
                    <nav class='navigation'>
                        <h1 id='logo'>weather box</h1>
                        <div id='menu'>
                            <p>Home</p>
                            <p>About</p>
                            <p>Contact</p>
                        </div>
                        <ul class='snsLink'>
                           <ul><a class='facebook' href='http://www.facebook.com' target='_blank'></a></ul>
                        </ul>
                    </nav>
                </header>
                <div class='greeting'></div>
                <section class='displayBoxes'>
                    <div class='errorMessages'>
                        <h1>Registration Error</h1>
                        <p>It appears as though the username with which you’re trying to register already exists. Click
                            <a href='./index.php?action=register'>here</a> to go back and try again.</p>
                    </div>
                </section>

        <script src='./js/jquery-2.1.4.min.js'></script>
        <script src='./js/jquery-ui.min.js'></script>
        <script src='./js/moment.min.js'></script>
        <script src='./js/moment-timezone-with-data.min.js'></script>
        <script src='./js/main.js'></script>
            </body>
         </html>";

        break;
    }
} else {
    header("Location: ./");
}
