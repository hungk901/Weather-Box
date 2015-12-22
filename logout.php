<?php
/**
 * A simple logout routine: capture the current session, destroy it, then redirect
 * the user to the root directory. If a session doesn’t exist, start one, destroy
 * it, then redirect the user to the root directory.
 *
 * A basic logout page.
 *
 * PHP version 5.3.28
 *
 * @category Web_App
 * @package  Web_App
 * @author   Roy A Vanegas <roy@thecodeeducators.com>
 * @license  https://gnu.org/licenses/gpl.html GNU General Public License
 * @link     https://bitbucket.org/code-warrior/web-app/
 */

session_start();
session_destroy();
header("Location: ./");
