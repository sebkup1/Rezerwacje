<?php
	require("phpsqlajax_dbinfo.php");
    session_start();
    $user_id = $_SESSION['userId'];
    
    // Start XML file, create parent node

    $dom = new DOMDocument("1.0");
    $node = $dom->createElement("cars");
    $parnode = $dom->appendChild($node);

    // Opens a connection to a MySQL server

    $connection=mysql_connect ('localhost', $user_name, $pass_word);
    if (!$connection) {  die('Not connected : ' . mysql_error());}

    // Set the active MySQL database

    $db_selected = mysql_select_db($database, $connection);
    if (!$db_selected) {
      die ('Can\'t use db : ' . mysql_error());
    }

    // Select all the rows in the markers table
    $query = "SELECT id_Samochod,marka,model,nrRej,kod FROM Rejestracje.Samochod 
		inner join Rejestracje.`Osoba-Samochod`
		on (id_Samochod = idSamochod)
		inner join Rejestracje.Kod_IR
		on (id_Kod_IR = idKod)
		where id_Osoba = " . $user_id  . ";";
    $result = mysql_query($query);
    if (!$result) {
      die('Invalid query: ' . mysql_error());
    }

    // Iterate through the rows, adding XML nodes for each
    header("Content-type:text/xml");


    // Iterate through the rows, adding XML nodes for each

    while ($row = @mysql_fetch_assoc($result)){
      // ADD TO XML DOCUMENT NODE
      $node = $dom->createElement("car");
      $newnode = $parnode->appendChild($node);
      $newnode->setAttribute("id_Samochod",$row['id_Samochod']);
      $newnode->setAttribute("nrRej",$row['nrRej']);
      //$newnode->setAttribute("wlasciciel", $row['wlasciciel']);
      $newnode->setAttribute("marka", $row['marka']);
      $newnode->setAttribute("model", $row['model']);
	  $newnode->setAttribute("kod", $row['kod']);
      //$newnode->setAttribute("Zidentyfikowany", $row['Zidentyfikowany']);
    }

echo $dom->saveXML();

?>