<?PHP
require("phpsqlajax_dbinfo.php");
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
	$on_button = "Zaloguj";
	$to_page = "Zaloguj.php";
}
else{
	$is_logged = "zalogowany jako ";
	$on_button = "Wyloguj";
	$to_page = "logOut.php";
	header ("Location: Zarezerwuj.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
   
   /*if ($_SESSION['login'] != '') {
    header ("Location: index.php");
   }*/
   
	$uname = $_POST['username'];
	$pword = $_POST['password'];
	  
	$pword = htmlspecialchars($pword);
	  
	//==========================================
	//	CONNECT TO THE LOCAL DATABASE
	//==========================================

	  
	/*$db_handle = mysql_connect($server, $user_name, $pass_word);
	$db_found = mysql_select_db($database, $db_handle);*/

	if ($db_found) {

		$uname = quote_smart($uname, $db_handle);
		$pword = quote_smart($pword, $db_handle);

		$SQL = "SELECT * FROM Rejestracje.Osoba WHERE Login = $uname AND Haslo = $pword";//md5($pword)
		$result = mysql_query($SQL);
		$num_rows = mysql_num_rows($result);

	//====================================================
	//	CHECK TO SEE IF THE $result VARIABLE IS TRUE
	//====================================================

		if ($result) {
			if ($num_rows > 0) {
			   
				session_start();
				$_SESSION['login'] = "1";
				$_SESSION['user'] = $uname;
				$row = mysql_fetch_array($result);
				
				$_SESSION['userId'] = $row['idOsoba'];
				$_SESSION['status'] = $row['status'];				
				header ("Location: Zarezerwuj.php");
			}
			else {
			    
				session_start();
				$_SESSION['login'] = "";
				$_SESSION['user'] = "";
				
				$SQL = "SELECT * FROM Rejestracje.Osoba WHERE Login = $uname";//md5($pword)
			    $result = mysql_query($SQL);
			    $num_rows = mysql_num_rows($result);
				
			   if ($result) {
				  if ($num_rows > 0) {
					 $errorMessage = "Błędne hasło dla tego użytkownika";
				  }else{
					 $errorMessage = "Podany login nie istnieje";
				  }
			   }
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
		<table>
			<td>
			Username:
			<br><br>
			Password:
			</td>
			
			<td>
			<INPUT TYPE = 'TEXT' Name ='username'   maxlength="20">
			<br><br>
			<INPUT TYPE = 'password' Name ='password'   maxlength="16">
			</td>
			
		 </table>
		
		 
      	<P align = center>
		 <INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Login">
     	</P>
		<p style = "color:#FF0000"><?PHP print $errorMessage;?><br></p>
		
		Jeżeli nie posiadasz konta w serwisie <A HREF = NewUser.php>Zarejestruj się</A>

   </FORM>

<P>

    
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
