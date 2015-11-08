<?php
require("phpsqlajax_dbinfo.php");

session_start();
header ("Location: Dojazd.php");
$nr_rej = $_GET['nr_rej'];
$marka = $_GET['marka'];
$model = $_GET['model'];
$wlas = $_GET['wlas'];
$zid = $_GET['zid'];  //zidentyfikowany
//$_SESSION['user'] = "testik";
$user = $_SESSION['userId'];

$connection=mysql_connect ('localhost', $username, $password);
if (!$connection) {  die('Not connected : ' . mysql_error());}

// Set the active MySQL database

$db_selected = mysql_select_db("Rejestracje", $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Select all the rows in the markers table

//$query = "INSERT INTO TIBI.Logs (`LogText`) VALUES('".$lat."');";

$query = "INSERT INTO `Rejestracje`.`Samochod`
(
`nrRej`,
`wlasciciel`,
`marka`,
`model`,
`Zidentyfikowany`)
VALUES
(
'".$nr_rej."',
'".$user."',
'".$marka."',
'".$model."',
'".$zid."');";

$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

?>
