<?php
	// Turn off all error reporting
	error_reporting(0);
	
	require("phpsqlajax_dbinfo.php");
    session_start();
	$user_id = $_SESSION['userId'];
	if($_GET['scenario']==0){					// ja komuś
		//$user_id = $_GET['idOsoba'];
		$operator1 = "!=";
		$operator2 = "=";
		$wlasciciel = "id_Osoba";
	}else{										// ktos mi
		//$user_id = $_SESSION['userId'];
		$operator1 = "=";
		$operator2 = "!=";
		$wlasciciel = "wlasciciel_abonamentu";
	}
	
	
	/*if($_GET['operator']==0){
		$operator = "=";
	}
	else{
		$operator = "!=";
	}*/
    
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
    $query = "SELECT Imie,Nazwisko,id_Samochod,idosoba_samochod,marka,model,nrRej,kod,wlasciciel_abonamentu
		FROM Rejestracje.Samochod 
		inner join Rejestracje.`Osoba_samochod`
		on (id_Samochod = idSamochod)
		inner join Rejestracje.Kod_IR
		on (id_Kod_IR = idKod)
		inner join Rejestracje.Osoba
		on (idOsoba = ".$wlasciciel.") 
		where id_Osoba ". $operator1 ." " . $user_id  .
		" and wlasciciel_abonamentu ". $operator2 ." ". $user_id . ";";// .
		//" and wlasciciel ". $operator1 ." ". $user_id .";";
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
      $newnode->setAttribute("Imie", $row['Imie']);
	  $newnode->setAttribute("Nazwisko", $row['Nazwisko']);
      $newnode->setAttribute("marka", $row['marka']);
      $newnode->setAttribute("model", $row['model']);
	  $newnode->setAttribute("kod", $row['kod']);
	  $newnode->setAttribute("wlasciciel_abonamentu", $row['wlasciciel_abonamentu']);
      //$newnode->setAttribute("Zidentyfikowany", $row['Zidentyfikowany']);
    }

echo $dom->saveXML();

?>