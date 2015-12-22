<?php
/**
 * Contains functions used for registering new users, authenticating the login
 * protocol for existing users, and working with files.
 *
 * PHP version 5.3.28
 *
 * @category Web_App
 * @package  Web_App
 * @author   Roy Vanegas <roy@thecodeeducators.com>
 * @license  https://gnu.org/licenses/gpl.html GNU General Public License
 * @link     https://bitbucket.org/code-warrior/web-app/
 */

/**
 * WHITELIST
 *
 * Returns true if this white list verifies its predefined variables against a
 * $_POST variables’ form values, or, false otherwise.
 *
 * @access public
 * @return Boolean representing the valid or invalid nature of this white list
 */
function whiteList()
{
    /**
     * $validated maintains the state of this function. It’s set to true if the
     * conditions validating the following white list are true.
     */
    $validated = false;

    /**
     * $white_list represents the names of items that must be matched by HTML form
     * name values. Note: If you’re using an image as a submit button (<input
     * type="image">), then you must remember to add “x” and “y” to the
     * following array.
     */
    $white_list = array("username", "password", "submitted");

    /**
     * $amount_of_form_input_names_found_in_white_list keeps a count of items in the
     * white list array (defined above) that are also found in the $_POST array.
     */
    $amount_of_form_input_names_found_in_white_list = 0;

    if (isset($_POST)) {
        /**
         * Cycle through every item in the $_POST array so I can inspect every $key
         * for a match in the $white_list.
         */
        foreach ($_POST as $key => $value) {
            /**
             * Perform a case-sensitive test of whether $key is found in $white_list.
             * (A $key is the string-based index in the $_POST associative array. For
             * example, the $key in $_POST["username"] would be "username."
             * Similarly, the $key in $_POST["submitted"] would be "submitted.") If
             * it is, increase $amount_of_form_input_names_found_in_white_list.
             */
            if (in_array($key, $white_list)) {
                $amount_of_form_input_names_found_in_white_list++;
            }
        }

        // Compare the internal white list count to the external form variable count
        if (count($white_list) == count($_POST)) {
            // Compare the external form count to the external form variable count
            if ($amount_of_form_input_names_found_in_white_list == count($_POST)) {
                // Ensure that the external form variable count isn’t empty
                if ($amount_of_form_input_names_found_in_white_list != 0 ) {
                    $validated = true;
                }
            }
        }
    }

    return $validated;
}

/**
 * DOES USER EXIST
 *
 * Checks the database for the existence of a $username in the table “user.”
 * Returns true on success, false otherwise.
 *
 * @param String $username is the string being checked in the user table.
 *
 * @access public
 * @return Boolean true returned if $username is found; false otherwise.
 */
function doesUserExist($username)
{
    try {
        include_once "config.php";

        $user_exists = false;

        // PDO = php Data Object
        $db = new PDO(
            "mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER, DBPASS
        );

        // $db -> prepare : at $db and call function "prepare".
        $statement = $db -> prepare(
            "SELECT username FROM user WHERE username = :username"
        );

        $statement -> execute(array('username' => $username));

        while ($row = $statement -> fetch()) {
            if ($row['username'] == $username) {
                $user_exists = true;

                break;
            }
        }

        // Close Database.
        $statement = null;
        return $user_exists;

    } catch(PDOException $e) {
        echo "<div>Error thrown in function <code>doesUserExist</code></div>";
        echo $e -> getMessage();

        exit;
    }
}

/**
 * REGISTER NEW USER
 *
 * Inserts $username and $password into the user table, generating a random salt for
 * the password in the interim.
 *
 * @param String $username of a new user that should not exceed the limit established
 *                         for this field in mysql/user.sql.
 * @param String $password of a new password that should not exceed the limit
 *                         established for this field in mysql/user.sql.
 *
 * @access public
 * @return void
 */
function registerNewUser($username, $password)
{
    try {
        include_once "config.php";

        $salt = substr(md5(rand(0, 65536)), 0, 8);

        $connection = new PDO(
            "mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS
        );

        $statement = $connection -> prepare(
            "INSERT INTO user (username,salt,password) " .
            "VALUES (:username,:salt,:password)"
        );

        $statement -> execute(
            array(
                'username' => $username,
                'salt'     => $salt,
                'password' => md5($password . $salt)
            )
        );

        $statement = null;
    } catch(PDOException $e) {
        echo "<div>Error thrown in <code>registerNewUser</code></div>";
        echo $e -> getMessage();

        exit;
    }
}

/**
 * AUTHENTICATE USER
 *
 * Checks the user table for the existence of a $username with a matching $password.
 * To do this, the $username’s salt must be retrieved so that the md5 function can
 * carry out its comparison. If the comparison is successful, then true is returned;
 * otherwise, false is returned.
 *
 * @param String $username is a user’s existing username.
 * @param String $password is the password associated with the $username.
 *
 * @access public
 * @return bool
 */
function authenticateUser($username, $password)
{
    try {
        include_once "config.php";

        $db = new PDO(
            "mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS
        );

        $statement = $db -> prepare(
            "SELECT password, salt " .
            "FROM user " .
            "WHERE username=:username"
        );

        $statement -> execute(array('username' => $username));

        $row = $statement -> fetch();

        $statement = null;

        if (md5($password . $row['salt']) == $row['password']) {
            $state = true;
        } else {
            $state = false;
        }

        return $state;

    } catch(PDOException $e) {
        echo "<div>Error thrown in <code>authenticateUser</code></div>";
        echo $e -> getMessage();

        exit;
    }
}

/**
 * INSERT NEW LOCATION
 *
 * Inserts $boxid, $cityname, $countryname into table location.
 *
 * @param String $username    is the owner of the location.
 * @param String $boxid       is the box index.
 * @param String $cityname    is the city name of a box input.
 * @param String $countryname is the country name of a box input.
 *
 * @access pubic
 * @return void
 */
function insertNewLocation($username, $boxid, $cityname, $countryname)
{
    try {
        include_once "config.php";

        $connection = new PDO(
            "mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS
        );

        $statement = $connection -> prepare(
            "INSERT INTO location (username,boxid,cityname,countryname) " .
            "VALUES (:username,:boxid,:cityname,:countryname)"
        );

        $statement -> execute(
            array(
                'username'      => $username,
                'boxid'         => $boxid,
                'cityname'      => $cityname,
                'countryname'   => $countryname
            )
        );

        $statement = null;
    } catch(PDOException $e) {
        echo "<div>Error thrown in <code>Update Fail!</code></div>";
        echo $e -> getMessage();

        exit;
    }
}

/**
 * DOES BOX ID EXIST
 *
 * Checks the database for the existence of a $boxid in the table “location”.
 * Returns true on success, false otherwise.
 *
 * @param String $username is the string being checked in the location table.
 * @param Int $boxid is the integer being checked in the location table.
 *
 * @access public
 * @return Boolean true returned if $boxid is found; false otherwise.
 */
function doesBoxIDExist($username, $boxid)
{
    try {
        include_once "config.php";

        $boxid_exists = false;

        // PDO = php Data Object
        $db = new PDO(
            "mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER, DBPASS
        );

        // $db -> prepare : at $db and call function "prepare".
        $statement = $db -> prepare(
            "SELECT username, boxid " .
            "FROM location " .
            "WHERE username=:username"
        );

        $statement -> execute(array('username' => $username));

        while ($row = $statement -> fetch()) {
            if ($row['boxid'] == $boxid) {
                $boxid_exists = true;

                break;
            }
        }

        $statement = null;
        return $boxid_exists;

    } catch(PDOException $e) {
        echo "<div>Error thrown in function <code>doesBoxIDExist</code></div>";
        echo $e -> getMessage();

        exit;
    }
}

/**
 * UPDATE BOX
 *
 * Update the database for $cityname and $countryname in the table “location”.
 *
 * @param String $username    is the owner of the location.
 * @param String $boxid       is the box index.
 * @param String $cityname    is the city name of a box input.
 * @param String $countryname is the country name of a box input.
 *
 * @access public
 * @return void
 */
function updateBox($username, $boxid, $cityname, $countryname)
{
    try {
        include_once "config.php";

        $db = new PDO(
            "mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER, DBPASS
        );

        $statement = $db -> prepare(
            "UPDATE location " .
            "SET cityname=:cityname, countryname=:countryname " .
            "WHERE username=:username " .
            "AND boxid=:boxid"
        );

        $statement -> execute(
            array(
                'username' => $username,
                'boxid'    => $boxid,
                'cityname' => $cityname,
                'countryname' => $countryname
            )
        );

        $statement = null;
    } catch(PDOException $e) {
        echo "Error message generated by function <code>updateBox</code>: $e";
        echo $e -> getMessage();

        exit;
    }
}

/**
 * GET CITY AND COUNTRY NAME FOR
 *
 * Returns location name updated by $username and $boxid.
 *
 * @param String $username is the user for whom location names are being retrieved.
 * @param String $boxid    is the box index.
 *
 * @access public
 * @return array of name fields from file table representing file names.
 */
function getCityAndCountryNameFor($username, $boxid)
{
    try {
        include_once "config.php";

        $db = new PDO(
            "mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS
        );

        $statement = $db -> prepare(
            "SELECT boxid, cityname, countryname " .
            "FROM location " .
            "WHERE username = :username"
        );

        $statement -> execute(array('username' => $username));


        while ($row = $statement -> fetch()) {
            if ($row['boxid'] == $boxid) {
                if ($row['boxid'] != null) {
                    $cityname = $row['cityname'];
                    $countryname = $row['countryname'];
                    $locationname = $cityname . ", " . $countryname;
                }
                else {
                    $locationname = null;
                }
            }
        }

        $statement = null;

        return $locationname;

    } catch(PDOException $e) {
        echo "<div>Error thrown in <code>getTheLocationFor</code></div>";
        echo $e -> getMessage();

        exit;
    }
}
