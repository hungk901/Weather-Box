<?php
/**
 * Handles the data retrieving process: request, get data, response with data format
 * JSON.
 *
 * PHP version 5.3.28
 *
 * @category weather_box
 * @package  weather_box
 */

session_start();

require_once "includes/main.php";
require_once "includes/db.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {

   $username = $_SESSION['username'];
   $boxid    = $_GET['boxid'];

   for ($i=1; $i <= 8; $i++) {
      $locationname[$i] = getCityAndCountryNameFor($_SESSION['username'], $i);
   }

   echo json_encode($locationname);
}

else {
   echo "Error throw in retrievedate.php";
}
