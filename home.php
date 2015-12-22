<?php
/**
 * The home page of a registered user
 *
 * If a user’s login credentials have been verified by the logic in
 * “login.php,” then $_SESSION['valid'] is set to true and the user is redirected
 * here. If $_SESSION['valid'] is not true, then the user is redirected to the index
 * page.
 *
 * A valid user can setup different cities based on personal preference and have
 * forecast information and time of cities.
 *
 * PHP version 5.3.28
 *
 * @category weather_box
 * @package  weather_box
 */

session_start();

if (isset($_SESSION['valid'])) {
    if ($_SESSION['valid'] !== true) {
        header("Location: ./index.php");
    }
} else {
    header("Location: ./index.php");
}

require_once "includes/db.php";
require_once "includes/main.php";

$username = select("username", "user", "username", $_SESSION['username']);

for ($i = 1; $i <= 8; $i++) {
    $boxindex = $i;
    $locationname[$i] = getCityAndCountryNameFor($_SESSION['username'], $boxindex);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Weather Box (v0.0.1)</title>
        <link rel="stylesheet" href="./css/jquery-ui.min.css">
        <link rel="stylesheet" href="./css/style.css">
    </head>

    <body>
        <!--/_____HEADER SECTION_____/-->
        <header class="header">
            <nav class="navigation">
                <h1 id="logo">weather box</h1>
                <div id="menu">
                    <p>About</p>
                    <p>Contact</p>
                    <p>FAQ</p>
                </div>
                <ul class="snsLink">
                    <ul><a class="facebook" href="http://www.facebook.com" target="_blank"></a></ul>
                </ul>
            </nav>
        </header>

        <!--/_____GREETING SECTION_____/-->
        <section class="greeting">
            <p id="hello">Hello <?php echo $username ?>, how's going today?</p>
            <p id="logout"><a href="./logout.php">Logout</a></p>
        </section>

        <!--/_____WEATHRE BOX SECTION_____/-->
        <section class="displayBoxes">

            <!--/__________BOX 01__________/-->
            <div class="timeBox" id="tBox1">
                <div class="timeText" id="tTxt1">
                    <div class="time" id="t1"></div>
                    <div class="date" id="d1"></div>
                </div>
                <form class="currentLocation" id="curLoc1">
                    <p><input type="text"
                              class="currentCity"
                              id="curCt1"
                              placeholder="City, State/Country"
                              <?php
                                if ($locationname[1] != null) {
                                    echo '" value='.'"'.$locationname[1].'"'.'"';}
                              ?>>
                        <input type="submit" id="submit1" value="Enter"></p>
                </form>
            </div>

            <div class="forecastBox" id="wBox1">
                <div class="forecastText" id="wTxt1">
                    <div class="forecast" id="forecast1_1"></div>
                    <div class="forecast" id="forecast1_2"></div>
                    <div class="forecast" id="forecast1_3"></div>
                    <div class="forecast" id="forecast1_4"></div>
                    <div class="forecast" id="forecast1_5"></div>
                </div>
            </div>
            <!--/__________END 01__________/-->

            <!--/__________BOX 02__________/-->
            <div class="timeBox" id="tBox2">
                <div class="timeText" id="tTxt2">
                    <div class="time" id="t2"></div>
                    <div class="date" id="d2"></div>
                </div>
                <form class="currentLocation" id="curLoc2">
                    <p><input type="text"
                              class="currentCity"
                              id="curCt2"
                              placeholder="City, State/Country"
                              <?php
                                if ($locationname[2] != null) {
                                    echo '" value='.'"'.$locationname[2].'"'.'"';}
                              ?>>
                        <input type="submit" id="submit2" value="Enter"></p>
                </form>
            </div>

            <div class="forecastBox" id="wBox2">
                <div class="forecastText" id="wTxt2">
                    <div class="forecast" id="forecast2_1"></div>
                    <div class="forecast" id="forecast2_2"></div>
                    <div class="forecast" id="forecast2_3"></div>
                    <div class="forecast" id="forecast2_4"></div>
                    <div class="forecast" id="forecast2_5"></div>
                </div>
            </div>
            <!--/__________END 02__________/-->

            <!--/__________BOX 03__________/-->
            <div class="timeBox" id="tBox3">
                <div class="timeText" id="tTxt3">
                    <div class="time" id="t3"></div>
                    <div class="date" id="d3"></div>
                </div>
                <form class="currentLocation">
                    <p><input type="text"
                              class="currentCity"
                              id="curCt3"
                              placeholder="City, State/Country"
                              <?php
                                if ($locationname[3] != null) {
                                    echo '" value='.'"'.$locationname[3].'"'.'"';}
                              ?>>
                        <input type="submit" id="submit3" value="Enter"></p>
                </form>
            </div>

            <div class="forecastBox" id="wBox3">
                <div class="forecastText" id="wTxt3">
                    <div class="forecast" id="forecast3_1"></div>
                    <div class="forecast" id="forecast3_2"></div>
                    <div class="forecast" id="forecast3_3"></div>
                    <div class="forecast" id="forecast3_4"></div>
                    <div class="forecast" id="forecast3_5"></div>
                </div>
            </div>
            <!--/__________END 03__________/-->

            <!--/__________BOX 04__________/-->
            <div class="timeBox" id="tBox4">
                <div class="timeText" id="tTxt4">
                    <div class="time" id="t4"></div>
                    <div class="date" id="d4"></div>
                </div>
                <form class="currentLocation">
                    <p><input type="text"
                              class="currentCity"
                              id="curCt4"
                              placeholder="City, State/Country"
                              <?php
                                if ($locationname[4] != null) {
                                    echo '" value='.'"'.$locationname[4].'"'.'"';}
                              ?>>
                        <input type="submit" id="submit4" value="Enter"></p>
                </form>
            </div>

            <div class="forecastBox" id="wBox4">
                <div class="forecastText" id="wTxt4">
                    <div class="forecast" id="forecast4_1"></div>
                    <div class="forecast" id="forecast4_2"></div>
                    <div class="forecast" id="forecast4_3"></div>
                    <div class="forecast" id="forecast4_4"></div>
                    <div class="forecast" id="forecast4_5"></div>
                </div>
            </div>
            <!--/__________END 04__________/-->

            <!--/__________BOX 05__________/-->
            <div class="timeBox" id="tBox5">
                <div class="timeText" id="tTxt5">
                     <div class="time" id="t5"></div>
                     <div class="date" id="d5"></div>
                </div>
                 <form class="currentLocation">
                    <p><input type="text"
                              class="currentCity"
                              id="curCt5"
                              placeholder="City, State/Country"
                              <?php
                                if ($locationname[5] != null) {
                                    echo '" value='.'"'.$locationname[5].'"'.'"';}
                              ?>>
                        <input type="submit" id="submit5" value="Enter"></p>
                </form>
            </div>

            <div class="forecastBox" id="wBox5">
                <div class="forecastText" id="wTxt5">
                    <div class="forecast" id="forecast5_1"></div>
                    <div class="forecast" id="forecast5_2"></div>
                    <div class="forecast" id="forecast5_3"></div>
                    <div class="forecast" id="forecast5_4"></div>
                    <div class="forecast" id="forecast5_5"></div>
                </div>
            </div>
            <!--/__________END 05__________/-->

            <!--/__________BOX 06__________/-->
            <div class="timeBox" id="tBox6">
                <div class="timeText" id="tTxt6">
                    <div class="time" id="t6"></div>
                    <div class="date" id="d6"></div>
                </div>
                <form class="currentLocation">
                    <p><input type="text"
                              class="currentCity"
                              id="curCt6"
                              placeholder="City, State/Country"
                              <?php
                                if ($locationname[6] != null) {
                                    echo '" value='.'"'.$locationname[6].'"'.'"';}
                              ?>>
                        <input type="submit" id="submit6" value="Enter"></p>
                </form>
            </div>

            <div class="forecastBox" id="wBox6">
                <div class="forecastText" id="wTxt6">
                    <div class="forecast" id="forecast6_1"></div>
                    <div class="forecast" id="forecast6_2"></div>
                    <div class="forecast" id="forecast6_3"></div>
                    <div class="forecast" id="forecast6_4"></div>
                    <div class="forecast" id="forecast6_5"></div>
                </div>
            </div>
            <!--/__________END 06__________/-->

            <!--/__________BOX 07__________/-->
            <div class="timeBox" id="tBox7">
                <div class="timeText" id="tTxt7">
                    <div class="time" id="t7"></div>
                    <div class="date" id="d7"></div>
                </div>
                <form class="currentLocation">
                    <p><input type="text"
                              class="currentCity"
                              id="curCt7"
                              placeholder="City, State/Country"
                              <?php
                                if ($locationname[7] != null) {
                                    echo '" value='.'"'.$locationname[7].'"'.'"';}
                              ?>>
                        <input type="submit" id="submit7" value="Enter"></p>
                </form>
            </div>

            <div class="forecastBox" id="wBox7">
                <div class="forecastText" id="wTxt7">
                    <div class="forecast" id="forecast7_1"></div>
                    <div class="forecast" id="forecast7_2"></div>
                    <div class="forecast" id="forecast7_3"></div>
                    <div class="forecast" id="forecast7_4"></div>
                    <div class="forecast" id="forecast7_5"></div>
                </div>
            </div>
            <!--/__________END 07__________/-->

            <!--/__________BOX 08__________/-->
            <div class="timeBox" id="tBox8">
                <div class="timeText" id="tTxt8">
                    <div class="time" id="t8"></div>
                    <div class="date" id="d8"></div>
                </div>
                <form class="currentLocation" id="curLoc8">
                    <p><input type="text"
                              class="currentCity"
                              id="curCt8"
                              placeholder="City, State/Country"
                              <?php
                                if ($locationname[8] != null) {
                                    echo '" value='.'"'.$locationname[8].'"'.'"';}
                              ?>>
                        <input type="submit" id="submit8" value="Enter"></p>
                </form>
            </div>

            <div class="forecastBox" id="wBox8">
                <div class="forecastText" id="wTxt8">
                    <div class="forecast" id="forecast8_1"></div>
                    <div class="forecast" id="forecast8_2"></div>
                    <div class="forecast" id="forecast8_3"></div>
                    <div class="forecast" id="forecast8_4"></div>
                    <div class="forecast" id="forecast8_5"></div>
                </div>
            </div>
            <!--/__________END 08__________/-->
        </section>

        <!--/_____LAST UPDATE SECTION_____/-->
        <section class="lastUpdate">
            <div>
                <input type="button" id="refreshButton">
                <p id="lastUpdateText">Last update: </p>
            </div>
        </section>


    <!--/_____JavaScript_____/-->
    <script src="./js/jquery-2.1.4.min.js"></script>
    <script src="./js/jquery-ui.min.js"></script>
    <script src="./js/moment.min.js"></script>
    <script src="./js/main.js"></script>
    </body>
</html>
