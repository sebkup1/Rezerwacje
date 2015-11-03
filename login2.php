<?PHP

$uname = "";
$pword = "";
$errorMessage = "";

//==========================================
//	ESCAPE DANGEROUS SQL CHARACTERS
//==========================================
function quote_smart($value, $handle) {

   if (get_magic_quotes_gpc()) {
       $value = stripslashes($value);
   }

   if (!is_numeric($value)) {
       $value = "'" . mysql_real_escape_string($value, $handle) . "'";
   }
   return $value;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$uname = $_POST['username'];
	$pword = $_POST['password'];
	  
	$uname = htmlspecialchars($uname);
	$pword = htmlspecialchars($pword);
	  
	//=========e=================================
	//	CONNECT TO THE LOCAL DATABASE
	//==========================================
	$user_name = "root";
	$pass_word = "abcd1234";
	$database = "Rejestracje";
	$server = "127.0.0.1";
	  
	$db_handle = mysql_connect($server, $user_name, $pass_word);
	$db_found = mysql_select_db($database, $db_handle);

	if ($db_found) {

		$uname = quote_smart($uname, $db_handle);
		$pword = quote_smart($pword, $db_handle);

		$SQL = "SELECT * FROM Rejestracje.Osoba WHERE Login = $uname AND Haslo = $pword";//md5($pword)
		//$SQL = "INSERT INTO TIBI.Logs (`LogText`) VALUES('test');";
		$result = mysql_query($SQL);
		$num_rows = mysql_num_rows($result);

	//====================================================
	//	CHECK TO SEE IF THE $result VARIABLE IS TRUE
	//====================================================

		if ($result) {
		 print "num rows: ";
			if ($num_rows > 0) {
			   print $num_rows;
			   
				session_start();
				$_SESSION['login'] = "1";
				//header ("Location: page1.php");
			}
			else {
			   //print "else";
			   print $num_rows;
				session_start();
				$_SESSION['login'] = "";
				//header ("Location: signup.php");
			}	
		}
		else {
			$errorMessage = "Error logging on(result)";
		}

	mysql_close($db_handle);

	}

	else {
		$errorMessage = "Error logging on server post";
	}

}
?>