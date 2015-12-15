<?php
require("phpsqlajax_dbinfo.php");


header("Content-type:text/xml");

$currentCode = $_GET['currentCode'];  //obecny kod

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
  
  
  //Dodanie kodu IR
  $generatedCode =  rand ( 1000000, 10000000 );

  $query = "SELECT idKod FROM Rejestracje.Kod_IR 
            where kod = ".$currentCode.";";
   
  $result = mysql_query($query);
  
  if (!$result) {
    $result->free();
    $newnode->setAttribute("transsactionResulst",1);
    //throw new Exception($connection->error);
  }
  
    while ($row = @mysql_fetch_assoc($result)){
    $codeId = $row['idKod'];
  }
  
  $query = "UPDATE Rejestracje.Kod_IR 
    SET  
    kod = ".$generatedCode." WHERE idKod = ".$codeId.";";
    
    $result = mysql_query($query);
    
    if (!$result) {
    $result->free();
    $newnode->setAttribute("transsactionResulst",2);
    throw new Exception($connection->error);
  }
  
  //All success - commit transaction
  $newnode->setAttribute("transsactionResulst",0);
  
}
catch( Exception $e ){
}


echo $dom->saveXML();

?>
