<?PHP
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$is_logged = "niezalogowany";
	$on_button = "Zaloguj";
	$to_page = "Zaloguj.php";
}
else
{
	$is_logged = "zalogowany jako ";
	$on_button = "Wyloguj";
	$to_page = "logOut.php";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<title>Zarezerwuj</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<link rel="stylesheet" type="text/css" href="myStyle.css">
<style type="text/css"></style>

</head>

<body>
	
	<script type="text/javascript">
    function addCarToDatabase() {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        }
		if ((document.forms[0].marka.value=="")||(document.forms[0].model.value=="")||(document.forms[0].nr_rej.value=="")) {
			document.getElementById('SuccessOnAdd').innerHTML ="";
			document.getElementById('BadData').innerHTML = 'Powyższe pola nie mogą zostać pozostawione puste jeżeli chcesz poprawnie dodać samochód do bazy danych.';
		}else{
			xmlhttp.open("GET","addCar.php?nr_rej="+document.forms[0].nr_rej.value+"&marka="+document.forms[0].marka.value+"&model="+
					 document.forms[0].model.value+"&zid=1"+"&wlas=9");
			xmlhttp.send();
			document.getElementById('BadData').innerHTML = '';
			document.getElementById('SuccessOnAdd').innerHTML = "Samochód "+ document.forms[0].marka.value + " "+ document.forms[0].model.value +
			" o numerze rejestracyjnym " + document.forms[0].nr_rej.value +" został pomyślnie dodany do bazy.";
			
			document.forms[0].marka.value="";
			document.forms[0].model.value="";
			document.forms[0].nr_rej.value="";
		}
      }
</script>
	
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

<td width="70%" valign = "top">
          <?PHP
		  if (!(isset($_SESSION['login']) && $_SESSION['login'] != ''))
		  {
			echo "<br><br><br>Zaloguj sie aby móc zrobić cokolwiek";
		  }
		  else{
			echo '<form name="dodaj">
			<br>Nr rejestracyjny:<input type="text" name = "nr_rej"  size="20"/>
			<br>Marka:<input type="text" name = "marka"  size="13"/>
			<br>Model:<input type="text" name = "model"  size="13"/>
            <br><input type="button" value="Zatwierdź" name = "update" onclick= "addCarToDatabase() "/><br>
			<p style = "color:#FF0000">
				<label id="BadData" ></label>
			</p>
			<label id="SuccessOnAdd" ></label>
            
          </form>';
		  }
		  
		  ?>
</td>

<td width="10%"  valign="top">
	
	<p><?PHP print $is_logged.' '.$_SESSION['user'].' '.$_SESSION['userId'];?>
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
