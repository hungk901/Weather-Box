<?php
/**
 * Initial Index/Landing Page
 *
 * Login page.
 *
 * PHP version 5.3.28
 *
 * @category weather_box
 * @package  weather_box
 */

session_start();

if (isset($_SESSION["valid"])) {
    if (1 == $_SESSION["valid"]) {
        header("Location: home.php");
    }
}

if (!isset($_GET['action'])) {
    $_GET['action'] = "register";
    header("Location: ./index.php?action=". $_GET['action']);
}

// Search and hold this file, after this line we can use the content in main.php.
require "includes/main.php";

// Check everything above again.
if (isset($_GET['action'])) {
    if ("login" == $_GET['action']) {
        $action_value = "login.php";
        $subheading = $button_value = "Login";
    } else {
        if ("register" == $_GET['action']) {
            $action_value = "register.php";
            $subheading = $button_value = "Register";
        }
    }
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Weather Box (v0.0.1)</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <header class="header">
            <nav class="navigation">
                <h1 id="logo">weather box</h1>
                <div id="menu">
                    <p>Home</p>
                    <p>About</p>
                    <p>Contact</p>
                </div>
                <ul class="snsLink">
                    <ul><a class="facebook" href="http://www.facebook.com" target="_blank"></a></ul>
                </ul>
            </nav>
        </header>
        <div class="greeting"></div>

        <section class="displayBoxes">
            <div id="indexBox1">
                <div>Welcome to weather box!</div>
            </div>

            <div id="indexBox2">
                <div id="instruction"><?php echo $subheading ?></div>
            </div>

            <div id="indexBox3">
                <div>Would you like to <a href="./index.php?action=register">Register</a> or <a href="./index.php?action=login">Login</a>?
                </div>
            </div>

            <div id="indexBox4">
                <div>
                    <form action="<?php echo $action_value; ?>" method="post">
                        <p><input   type="text"
                                    name="username"
                                    placeholder="username"
                                    required
                                    autofocus></p>
                        <p><input   type="password"
                                    name="password"
                                    placeholder="password" required></p>
                        <p><input type="hidden" name="submitted" value="1"></p>
                        <p><input type="submit" value="<?php echo $button_value; ?>"></p>
                    </form>
                </div>
            </div>
        </section>

        <script src="./js/jquery-2.1.4.min.js"></script>
        <script src="./js/jquery-ui.min.js"></script>
        <script src="./js/moment.min.js"></script>
        <script src="./js/moment-timezone-with-data.min.js"></script>
        <script src="./js/main.js"></script>

   </body>
</html>

