<?php
	require("phpsqlajax_dbinfo.php");
    session_start();
	if($_GET['idOsoba']!=0){
		$user_id = $_GET['idOsoba'];
	}else{
		$user_id = $_SESSION['userId'];
	}
	
	
	if($_GET['operator']==0){
		$operator = "=";
	}
	else{
		$operator = "!=";
	}
    
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

    // Select all the rows in the table
    $query = "SELECT id_Samochod, idosoba_samochod,marka,model,nrRej,kod,wlasciciel_abonamentu FROM Rejestracje.Samochod 
		inner join Rejestracje.`Osoba_samochod`
		on (id_Samochod = idSamochod)
		inner join Rejestracje.Kod_IR
		on (id_Kod_IR = idKod)
		where id_Osoba = " . $user_id  .
		" and wlasciciel_abonamentu = ". $user_id  .
		" and wlasciciel " .$operator. " ". $user_id .";";
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
      $newnode->setAttribute("idosoba_samochod",$row['idosoba_samochod']);
	  $newnode->setAttribute("id_Samochod",$row['id_Samochod']);
      $newnode->setAttribute("nrRej",$row['nrRej']);
      //$newnode->setAttribute("wlasciciel", $row['wlasciciel']);
      $newnode->setAttribute("marka", $row['marka']);
      $newnode->setAttribute("model", $row['model']);
	  $newnode->setAttribute("kod", $row['kod']);
	  $newnode->setAttribute("wlasciciel_abonamentu", $row['wlasciciel_abonamentu']);
      //$newnode->setAttribute("Zidentyfikowany", $row['Zidentyfikowany']);
    }

echo $dom->saveXML();

?>