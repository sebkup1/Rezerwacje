<?php
require("phpsqlajax_dbinfo.php");


header("Content-type:text/xml");

$user = $_GET['person'];
$carId = $_GET['car'];


    $dom = new DOMDocument("1.0");
    $node = $dom->createElement("results");
    $parnode = $dom->appendChild($node);
    
    $node = $dom->createElement("result");
    $newnode = $parnode->appendChild($node);
    

try {
  
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
  
  //Dodanie kodu IR
  $generatedCode =  rand ( 1000000, 10000000 );
  
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
  $query = "INSERT INTO `Rejestracje`.`Osoba_samochod`
  (
  `id_Osoba`,
  `id_Samochod`,
  `id_Kod_IR`)
  VALUES
  (

  '".$user."',
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
