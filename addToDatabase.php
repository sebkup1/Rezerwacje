<?php
require("phpsqlajax_dbinfo.php");

$lat = $_GET['log'];

$connection=mysql_connect ('localhost', $username, $password);
if (!$connection) {  die('Not connected : ' . mysql_error());}

// Set the active MySQL database

$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Select all the rows in the markers table

$query = "INSERT INTO TIBI.Logs (`LogText`) VALUES('".$lat."');";

$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

?>
