<?php
require("phpsqlajax_dbinfo.php");

$lat = $_GET['log'];

$connection=mysql_connect ('localhost', $username, $password);
if (!$connection) {  die('Not connected : ' . mysql_error());}

// Set the active MySQL database

$db_selected = mysql_select_db("Rejestracje", $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Select all the rows in the markers table

//$query = "INSERT INTO TIBI.Logs (`LogText`) VALUES('".$lat."');";
try {
  $query = "INSERT INTO `Rejestracje`.`Samochod`
  (
  `nrRej`,
  `wlasciciel`,
  `marka`,
  `model`,
  `Zidentyfikowany`)
  VALUES
  (
  'wra454354',
  '3',
  'Nissan',
  'Mikra II',
  '0');";

  $result = mysql_query($query);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }
}catch( Exception $e ){
    // before rolling back the transaction, you'd want
    // to make sure that the exception was db-related
    $conn->rollback(); 
    $conn->autocommit(TRUE); // i.e., end transaction 
}

?>
