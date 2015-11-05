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

session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$is_logged = "niezalogowany";
}
else{
	$is_logged = "zalogowany";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$uname = $_POST['username'];
	$pword = $_POST['password'];
	  
	//$uname = htmlspecialchars($uname);
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
			if ($num_rows > 0) {
			   //print $num_rows;
			   
				session_start();
				$_SESSION['login'] = "1";
				header ("Location: index.php");
			}
			else {
			   //print "else";
			   //print $num_rows;
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

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>Logowanie</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<link rel="stylesheet" type="text/css" href="myStyle.css">
<style type="text/css">

</style>

</head>

<body>
<center>
<table border="0" style="border-collapse: collapse;" width="800px" >
<tr>
<td width="100%" colspan="3">


<script type="text/javascript" src="logo.js"></script>
<br>
<br>
<br>
</td>
</tr>
<tr>
<td width="20%">


<script type="text/javascript" src="menu.js"></script>


<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

</td >
<td width="70%" valign = "top">
   
   <FORM NAME ="form1" METHOD ="POST" ACTION ="Zaloguj.php">
		<br>
		<br>
		Username: <INPUT TYPE = 'TEXT' Name ='username'   maxlength="20">
		<br>
      	Password: <INPUT TYPE = 'TEXT' Name ='password'   maxlength="16">

      	<P align = center>
		 <INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Login">
     	</P>
		
		<A HREF = NewUser.php>Zarejestruj się</A>

   </FORM>

<P>
<?PHP print $errorMessage;?>
    
</td>

<td width="10%" valign = "top">
	<p><?PHP print $is_logged;?></p>
</td>

</tr>
<tr>
<td width="100%" colspan="3">


<script type="text/javascript" src="stopka.js"></script>



</td>
</tr>
</table>
</center>
</body>

</html>
