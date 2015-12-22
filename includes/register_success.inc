<?php
echo "<!DOCTYPE HTML>
        <html>
            <head>
                <meta charset='utf-8'>
                <title>Registration Success</title>

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
                        <h1>Registration Success</h1>
                        <p>You’ve successfully registered. Click <a href='./index.php?action=login'>here</a> to go back to the home page and log in, or you can simply wait 5 seconds to be redirected.</p>
                    </div>
                </section>

        <script src='./js/jquery-2.1.4.min.js'></script>
        <script src='./js/jquery-ui.min.js'></script>
        <script src='./js/moment.min.js'></script>
        <script src='./js/moment-timezone-with-data.min.js'></script>
        <script src='./js/main.js'></script>
            </body>
        </html>";


// echo "<!DOCTYPE HTML>
// <html>
//    <head>
//       <meta charset='utf-8'>
//       <title>Registration Success</title>
//       <link rel='stylesheet' href='css/normalize.css'>
//       <link rel='stylesheet' href='css/style.css'>
//    </head>
//    <body>
//       <h1>Registration Success</h1>
//       <p>You’ve successfully registered. Click <a href='./index.php?action=login'>here</a> to go back to the home page and log in, or you can simply wait 5 seconds to be redirected.</p>
//    </body>
// </html>
// ";
