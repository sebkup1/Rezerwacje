<?PHP
require("phpsqlajax_dbinfo.php");
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
					 document.forms[0].model.value+"&zid=1");
			xmlhttp.send();
			document.getElementById('BadData').innerHTML = '';
			document.getElementById('SuccessOnAdd').innerHTML = "Samochód "+ document.forms[0].marka.value + " "+ document.forms[0].model.value +
			" o numerze rejestracyjnym " + document.forms[0].nr_rej.value +" został pomyślnie dodany do bazy.";
			
			document.forms[0].marka.value="";
			document.forms[0].model.value="";
			document.forms[0].nr_rej.value="";
			OnMyCarsClick()
		}
      }
	  
	function OnMyCarsClick() {
		 document.getElementById('carsTable').innerHTML ="";
	  getCars("get_cars.php", function(data) {
        var xml = data.responseXML;
		
        var cars = xml.documentElement.getElementsByTagName("car");
		
		if (cars.length>0) {
			var yy = document.createElement("TR");
			yy.setAttribute("id", "nagl");
			document.getElementById("carsTable").appendChild(yy);

			var nc_marka = document.createElement("TD");
			var nd_marka = document.createTextNode("Marka");
			nc_marka.appendChild(nd_marka);
			document.getElementById("nagl").appendChild(nc_marka);
			
			var nc_model = document.createElement("TD");
			var nd_model = document.createTextNode("Model");
			nc_model.appendChild(nd_model);
			document.getElementById("nagl").appendChild(nc_model);
			
			var nc_nrRej = document.createElement("TD");
			var nd_nrRej = document.createTextNode("Nr rejestrancyjny");
			nc_nrRej.appendChild(nd_nrRej);
			document.getElementById("nagl").appendChild(nc_nrRej);
		}
		
        for (var i = 0; i < cars.length; i++) {
          var idSamochod = cars[i].getAttribute("idSamochod");
		  var nrRej = cars[i].getAttribute("nrRej");
		  var wlasciciel = cars[i].getAttribute("wlasciciel");
		  var marka = cars[i].getAttribute("marka");
		  var model = cars[i].getAttribute("model");
		  var Zidentyfikowany = cars[i].getAttribute("Zidentyfikowany");
			
		  //var x = document.getElementById("carsTable");
		  //var x = document.createElement("TABLE");
			//x.setAttribute("id", "myTable");
			//document.body.appendChild(x);
			

			var y = document.createElement("TR");
			y.setAttribute("id", idSamochod);
			document.getElementById("carsTable").appendChild(y);

			var c_marka = document.createElement("TD");
			var d_marka = document.createTextNode(marka);
			c_marka.appendChild(d_marka);
			document.getElementById(idSamochod).appendChild(c_marka);
			
			var c_model = document.createElement("TD");
			var d_model = document.createTextNode(model);
			c_model.appendChild(d_model);
			document.getElementById(idSamochod).appendChild(c_model);
			
			var c_nrRej = document.createElement("TD");
			var d_nrRej = document.createTextNode(nrRej);
			c_nrRej.appendChild(d_nrRej);
			document.getElementById(idSamochod).appendChild(c_nrRej);
		  
        } 
      });
	}
			
	function getCars(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;
		  
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
	}
	
	function doNothing() {}
</script>

</head>

<body>

	
<center>
<table border="0" style="border-collapse: collapse;" width="800px" >
<tr>
<td width="100%" colspan="3">


<script type="text/javascript" src="logo.js" ></script>

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
			echo "<br><br><br><a href=Zaloguj.php>Zaloguj się</a> lub <a href=NewUser.php>Zarejestruj</a> aby móc korzystać z systemu";
		  }
		  else{
			
			if($_SESSION['status']==3){
				echo '<p style = "color:#FF0000">
				<h3>Nie masz uprawnień do wjazdu na teren parkingu</h3>
				</p>';
			}
			
			if($_SESSION['status']==2){
				echo '2';
			}
			
			if($_SESSION['status']==1){
				echo '<h3>Osoba uprzywilejowana</h3>';
			}
			
			echo '<h3>Dodaj nowy pojazd</h3>
			<form name="dodaj">
			Nr rejestracyjny:<input type="text" name = "nr_rej"  size="20"/>
			<br>Marka:<input type="text" name = "marka"  size="13"/>
			<br>Model:<input type="text" name = "model"  size="13"/>
            <br><input type="button" value="Zatwierdź" name = "update" onclick= "addCarToDatabase() "/>
			<p style = "color:#FF0000">
				<label id="BadData" ></label>
			</p>
			<label id="SuccessOnAdd" ></label>
          </form>
		  
			<input type="button" value="Moje pojazdy" name = "update2" onclick= "OnMyCarsClick() "/>
		  <h5><table id="carsTable"  width="400" visible = "false">

		  </table></h5>';
		  }
		  
		  ?>
</td>

<td width="10%" valign="top">
	
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
