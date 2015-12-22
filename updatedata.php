<?php
/**
 * Handles the data updating process: pass data, check if the field already exist, * if it does not exist, insert the data; or update the older one with the new one.
 *
 * PHP version 5.3.28
 *
 * @category weather_box
 * @package  weather_box
 */

session_start();

require_once "includes/main.php";
require_once "includes/db.php";

if ($_SERVER['REQUEST_METHOD'] != 'GET') {

    $username    = $_SESSION['username'];
    $boxid       = $_POST['boxid'];
    $cityname    = $_POST['cityname'];
    $countryname = $_POST['countryname'];

    if (!doesBoxIDExist($username, $boxid)) {
        insertNewLocation(
            $username,
            $boxid,
            $cityname,
            $countryname
        );

    } else {
        updateBox($username, $boxid, $cityname, $countryname);
    }
}
else {
    echo "Error throw in updatedata.php";
}
