<?php
require("phpsqlajax_dbinfo.php");

session_start();
$user_id = $_SESSION['userId'];
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
    



try {
  //$connection->autocommit(FALSE); // i.e., start transaction
  //$db_selected->beginTransaction();
  //$connection->autocommit(FALSE);
  
  $connection=mysql_connect ('localhost', $user_name, $pass_word);
  if (!$connection) {
    $newnode->setAttribute("transsactionResulst",1);
    throw new Exception($connection->error);
    }

  // Set the active MySQL database
  $db_selected = mysql_select_db("Rejestracje", $connection);
  if (!$db_selected) {
    $newnode->setAttribute("transsactionResulst",2);
    throw new Exception($connection->error);
  }
  
  mysql_query("START TRANSACTION");
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
  '".$zid."');
  ";  // SELECT LAST_INSERT_ID();
   
  
  $result = mysql_query($query);
  
  if (!$result) {
    $result->free();
    $newnode->setAttribute("transsactionResulst",3);
    throw new Exception($connection->error);
  }
  
  $query = "SELECT LAST_INSERT_ID();";
  $result = mysql_query($query);
  
  if (!$result) {
    $result->free();
    $newnode->setAttribute("transsactionResulst",4);
    throw new Exception($connection->error);
  }
  
  while ($row = @mysql_fetch_assoc($result)){
    $carId = $row['LAST_INSERT_ID()'];
  }
  
  //Dodanie kodu IR
  $generatedCode =  rand ( 10000, 100000 );
  
  $query = "INSERT INTO `Rejestracje`.`Kod_IR`
  (
  `kod`)
  VALUES
  (
   '".$generatedCode."');";
   
  $result = mysql_query($query);
  
  if (!$result) {
    $result->free();
    $newnode->setAttribute("transsactionResulst",5);
    throw new Exception($connection->error);
  }
  
  $query = "SELECT LAST_INSERT_ID();";
  $result = mysql_query($query);
  
  if (!$result) {
    $result->free();
    $newnode->setAttribute("transsactionResulst",6);
    throw new Exception($connection->error);
  }
  
  while ($row = @mysql_fetch_assoc($result)){
    $codeId = $row['LAST_INSERT_ID()'];
  }
  
  //Dodanie zwiazku osoba - samochód
  $query = "INSERT INTO `Rejestracje`.`Osoba-Samochod`
  (
  `id_Osoba`,
  `id_Samochod`,
  `id_Kod_IR`)
  VALUES
  (
  '".$user_id."',
  '".$carId."',
  '".$codeId."');
  ";

  
  $result = mysql_query($query);
  
  if (!$result) {
    $result->free();
    $newnode->setAttribute("transsactionResulst","7");
    throw new Exception($connection->error);
  }

  
  
  //All success - commit transaction
  $newnode->setAttribute("transsactionResulst",0);
  mysql_query("COMMIT");
  
}
catch( Exception $e ){
  mysql_query("ROLLBACK");
}


echo $dom->saveXML();

?>
