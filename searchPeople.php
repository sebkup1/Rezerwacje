<?php
	require("phpsqlajax_dbinfo.php");
	session_start();
	$user = $_SESSION['userId'];
    $name = $_GET['name'];
	$surname = $_GET['surname'];
    // Start XML file, create parent node

    $dom = new DOMDocument("1.0");
    $node = $dom->createElement("people");
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
    $query = "SELECT idOsoba, Imie, Nazwisko from Rejestracje.Osoba
		where Imie like '".$name."%' and Nazwisko like '".$surname."%'
		and idOsoba != ".$user.";";
    $result = mysql_query($query);
    if (!$result) {
      die('Invalid query: ' . mysql_error());
    }

    // Iterate through the rows, adding XML nodes for each
    header("Content-type:text/xml");

    // Iterate through the rows, adding XML nodes for each

    while ($row = @mysql_fetch_assoc($result)){
      // ADD TO XML DOCUMENT NODE
      $node = $dom->createElement("person");
      $newnode = $parnode->appendChild($node);
      $newnode->setAttribute("Imie",$row['Imie']);
      $newnode->setAttribute("Nazwisko",$row['Nazwisko']);
	  $newnode->setAttribute("idOsoba",$row['idOsoba']);

    }

echo $dom->saveXML();

?>