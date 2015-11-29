<?php
require("phpsqlajax_dbinfo.php");

session_start();
header("Content-type:text/xml");
//$_SESSION['addCarTransactionStatus'] = 9;
//header ("Location: Dojazd.php");
$nr_rej = $_GET['nr_rej'];
$marka = $_GET['marka'];
$model = $_GET['model'];
$zid = $_GET['zid'];  //zidentyfikowany
$user = $_SESSION['userId'];

    $dom = new DOMDocument("1.0");
    $node = $dom->createElement("results");
    $parnode = $dom->appendChild($node);
    
    $node = $dom->createElement("result");
    $newnode = $parnode->appendChild($node);
    

$connection=mysql_connect ('localhost', $user_name, $pass_word);
if (!$connection) {$_SESSION['addCarTransactionStatus'] = 1;}

// Set the active MySQL database

$db_selected = mysql_select_db("Rejestracje", $connection);
if (!$db_selected) {
  $_SESSION['addCarTransactionStatus'] = 2;
}


try {
  //$connection->autocommit(FALSE); // i.e., start transaction
  $_SESSION['addCarTransactionStatus'] = 2;
  //$db_selected->beginTransaction();
  //$connection->autocommit(FALSE);
  mysql_query("START TRANSACTION");
  $_SESSION['addCarTransactionStatus'] = 4;
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
    $result->free();
    $_SESSION['addCarTransactionStatus'] = 5;
    $newnode->setAttribute("transsactionResulst",5);
    throw new Exception($connection->error);
  }
    /*$connection->commit();
    $connection->autocommit(TRUE);*/ // i.e., end transaction
  
  //$db_selected->commit();
  
  $_SESSION['addCarTransactionStatus'] = 0;
  $newnode->setAttribute("transsactionResulst","full");
  
  mysql_query("COMMIT");
}catch( Exception $e ){
  mysql_query("ROLLBACK");
    $_SESSION['addCarTransactionStatus'] = 2;
    $newnode->setAttribute("transsactionResulst",2);
    // An exception has been thrown
    // We must rollback the transaction
   // $db_selected->rollback();
    
}


echo $dom->saveXML();

?>
