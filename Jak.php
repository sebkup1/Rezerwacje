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
<title>Jak działa rezerwacja</title>
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
<td width="70%" align = "justify" style ="text-indent: 0.4in;" >
	<br><br>
	<table>
	<td width="95%" valign = "top">
	<p>	Użytkownik chcący skorzystać z systemu najpierw musi
	<a href=NewUser.php>zarejestrować się</a> na obecnie przeglądanej stronie internetowej połączoną z bazą danych.
	Na stronie tej ma on możliwość oprócz rejestracji także <a href=Zaloguj.php>logowanie</a> do sesji.
	Oprócz tego może <a href=Zarezerwuj.php>rejestrować</a> swój pojazd i uzyskiwać dla niego kod wjazdowy.
	Użytkownik może z poziomu strony udostępniać swoje pojazdy,
	a także swój abonament innym użytkownikom poprzez prosty interface.
	Tam też ma możliwość przeglądania swoich pojazdów oraz tych, 
	które komuś udostępnił lub zostały udostępnione jemu.
	</p>
<p>Centralną częścią systemu jest serwer z bazą danych przechowującą wszystkie powyższe informacje
oraz zarządzający przepływem danych w systemie. Strona internetowa – interface użytkownika –
jest jednym z komponentów systemu wymieniających dane z bazą.
Drugim równie istotnym jest aplikacja pośrednicząca pomiędzy bazą, a platformą E2LP.</p>

<p>Podsystem autoryzacji wjazdu w założeniu składa się z dwóch terminali do wpisywania kodów
– jeden dla pojazdów wjeżdżających, drugi dla wyjeżdżających.
Umieszczone są w miejscach umożliwiającym wpisywanie kodów bez konieczności wysiadania z pojazdu.
Po przekazaniu kodu do platformy E2LP przesyła ona go do aplikacji,
która określa na podstawie zapytań wysłanych do bazy czy użytkownik ten ma uprawnienia do wjazdu
na parking (lub wyjazdu) i odsyła informację zwrotną, która wyświetlona zostanie na wyświetlaczu LCD.
W informacji tej zawarty będzie powód ewentualnego braku zezwolenia na przejazd.
W przypadku gdy użytkownik chcący wjechać na parking ma do tego uprawnienia podsystem sterowania szlabanem
otworzy go.
</p>
</td>

<td width="5%" valign = "top">
</td>
</table>

</td>

<td width="10%" valign = "top">
	<p><?PHP print $is_logged.' '.$_SESSION['user'];?>
	<?php
		print '<form action='.$to_page.'>
				<input type="submit" value='.$on_button.'>
				</form>'; //przycisk
	?></p>
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
