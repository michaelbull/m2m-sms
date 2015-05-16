<?php
/**
 * The single point of entry to the web application
 * @author Michael
 */

ini_set('display_errors', 'On');
ini_set('html_errors', 'On');

session_save_path(__DIR__ . '/../temp/session');
session_start();

require_once __DIR__ . '/../includes/application/bootstrap.php';