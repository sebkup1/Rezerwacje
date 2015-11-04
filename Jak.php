<?PHP
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$is_logged = "niezalogowany";
}
else{
	$is_logged = "zalogowany";
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

</td>
<td width="70%"><small>tresc Zakładka2.html</small></td>
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
