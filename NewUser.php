<?PHP
//session_start();
//if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	//header ("Location: login.php");
//}

//set the session variable to 1, if the user signs up. That way, they can use the site straight away
//do you want to send the user a confirmation email?
//does the user need to validate an email address, before they can use the site?
//do you want to display a message for the user that a particular username is already taken?
//test to see if the u and p are long enough
//you might also want to test if the users is already logged in. That way, they can't sign up repeatedly without closing down the browser
//other login methods - set a cookie, and read that back for every page
//collect other information: date and time of login, ip address, etc
//don't store passwords without encrypting them
/*$name = "";
$surname = "";
$login = "";
$pword = "";
$phone = "";*/
require("phpsqlajax_dbinfo.php");
$errorMessage = "";
$num_rows = 0;

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
	/*$is_logged = "niezalogowany";
	$on_button = "Zaloguj";
	$to_page = "Zaloguj.php";
	*/
	//session_destroy();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	//====================================================================
	//	GET THE CHOSEN U AND P, AND CHECK IT FOR DANGEROUS CHARCTERS
	//====================================================================
	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$login = $_POST['login'];
	$pword = $_POST['password'];
	$cpword = $_POST['cpassword'];
	$phone = $_POST['phone'];

	$login = htmlspecialchars($login);
	$pword = htmlspecialchars($pword);

	//====================================================================
	//	CHECK TO SEE IF U AND P ARE OF THE CORRECT LENGTH
	//	A MALICIOUS USER MIGHT TRY TO PASS A STRING THAT IS TOO LONG
	//	if no errors occur, then $errorMessage will be blank
	//====================================================================

	$uLength = strlen($login);
	$pLength = strlen($pword);
	
	if($name =="" || $surname == "" || $login == "" || $pword == "" || $cpword == "" || $phone =="")
    {
		 $errorMessage = $errorMessage . "Proszę wypełnić wszsystkie z powyższych pól." . "<BR>";
    }
	  
	if ($uLength < 4 || $uLength > 20)
	{
		 $errorMessage = $errorMessage . "Nazwa użytkownika musi się miescić między 5 a 20 znakami." . "<BR>";
	}

	if ($pLength < 8 && $pLength <= 16) {
		 $errorMessage = $errorMessage . "Hasło musi się mieścic między 8 a 16 znakami." . "<BR>";
	}

    if($pword != $cpword){
		 $errorMessage = $errorMessage . "Potwirdzone hasło musi być zgodne." . "<BR>";
    }


//test to see if $errorMessage is blank
//if it is, then we can go ahead with the rest of the code
//if it's not, we can display the error

if ($errorMessage == "") {

	/*$db_handle = mysql_connect($server, $user_name, $pass_word);
	$db_found = mysql_select_db($database, $db_handle);*/

	if ($db_found) {

		$login = quote_smart($login, $db_handle);
		$pword = quote_smart($pword, $db_handle);


		$SQL = "SELECT * FROM `Rejestracje`.`Osoba` WHERE Login = $login;";
		$result = mysql_query($SQL);
		$num_rows = mysql_num_rows($result);

		if ($num_rows > 0) {
			$errorMessage = "Wpisany login widnieje już w naszej bazie. Proszę wpisać inny.";
		}
		
		else {

			$SQL = "INSERT INTO `Rejestracje`.`Osoba`
				  (
				  `Imie`,
				  `Nazwisko`,
				  `Login`,
				  `Haslo`,
				  `nr_telefonu`,
				  `status`)
				  VALUES
				  (
				   '".$name."',
				   '".$surname."',
				   ".$login.",
				   ".$pword.",
				   '".$phone."',
				  '1');";
				  
			$result = mysql_query($SQL);
			if(!$result)
			{
			   $errorMessage = "Błąd wewnętrzny";
			}
			else
			{
			   session_start();
			   $_SESSION['login'] = "1";
			
			   $_SESSION['user'] = $login;
			   
			   $query = "SELECT LAST_INSERT_ID();";
			   $result = mysql_query($query);
  
				  if (!$result) {
					 $result->free();
					 //throw new Exception($connection->error);
				  }
  
				  while ($row = @mysql_fetch_assoc($result)){
					 $_SESSION['userId'] = $row['LAST_INSERT_ID()'];
				  }

			   header ("Location: Zarezerwuj.php");
			}
			

			mysql_close($db_handle);

		//=================================================================================
		//	START THE SESSION AND PUT SOMETHING INTO THE SESSION VARIABLE CALLED login
		//	SEND USER TO A DIFFERENT PAGE AFTER SIGN UP
		//=================================================================================
			

		}

	}
	else {
		$errorMessage = "Database Not Found";
	}

	}

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>Nowy</title>
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
   
<FORM NAME ="form1" METHOD ="POST" ACTION ="NewUser.php">

<table>
   <tr>
	  <td>Imię: </td> <td> <INPUT TYPE = 'TEXT' Name ='name'  value="<?PHP print $name;?>" maxlength="16">*</td>
   </tr>
   <tr>
	  <td>Nazwisko: </td> <td>  <INPUT TYPE = 'TEXT' Name ='surname'  value="<?PHP print $surname;?>" maxlength="16">*</td>
   </tr>
   <tr>
	  <td>Telefon: </td> <td>  <INPUT TYPE = 'TEXT' Name ='phone'  value="<?PHP print $phone;?>" maxlength="16">*</td>
   </tr>
   <tr>
	  <td>Login: </td> <td>   <INPUT TYPE = 'TEXT' Name ='login'  value="<?PHP print "";?>" maxlength="20">*</td>
   </tr>
   <tr>
	  <td>Hasło: </td> <td>  <INPUT TYPE = 'TEXT' Name ='password'  value="<?PHP print "";?>" maxlength="16">*</td>
   </tr>
      <tr>
	  <td>Potwierdź hasło: </td> <td>  <INPUT TYPE = 'TEXT' Name ='cpassword'  value="<?PHP print "";?>" maxlength="16">*</td>
   </tr>

</table>

<P>
<INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Register">

</FORM>
<p style = "color:#FF0000"><?PHP print $errorMessage;?></p>
    
</td>

<td width="10%" valign = "top">
	<p><?PHP print $is_logged;?>
	<?php
		print '<form action='.$to_page.'>
				<input type="submit" value='.$on_button.'>
				</form>'; //przycisk
	?>
	</p>
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
