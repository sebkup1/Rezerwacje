<?PHP
error_reporting(0);
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
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<title>Kontakt</title>
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
<td width="20%" valign = "top">


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

</td>
<td width="70%" valign ="top">
	<table>
		<tr>
			<h3>Autor systemu</h3>
		</tr>
		<tr>
			<td width="22%">
				<img src = "images/P1012428.JPG" width = "117" height = "150">
			</td>
			<td valign = "top" align = "left">
				<p>
					Sebastian Kupis
				</p>
				<p>
					Student Wydziału Mechatroniki Politechniki Warszawskiej na kierunku
					Automatyka i Robotyka o specjalności Informatyka Przemysłowa.
				</p>
				<p>
					adres email: sebkup1@gmail.com
				</p>
			</td>
			<td width = "4%">
			</td>
			
		</tr>

	</table>
	
	<table>
		<tr>
			<h3>Dziekanat Wydziału Mechatroniki</h3>
		</tr>
		<tr>
			<td width="22%">
				<a href=http://www.mchtr.pw.edu.pl>
					<img src = "images/logo_mchtr.png" width = "150" height = "153">
				</a>
			</td>
			<td>
				Wszelkich dodatkowych informacji udziela jak zwykle kompetentny dziekanat.
			</td>
			</td>
			<td width = "4%">
			</td>
		</tr>

	</table>
</td>

<td width="10%" valign = "top">
	<p><?PHP print $is_logged.' '.$_SESSION['user'];?>
	<?php
		print '<form action='.$to_page.'>
				<input type="submit" value='.$on_button.'>
				</form>'; //przycisk
	?>
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
