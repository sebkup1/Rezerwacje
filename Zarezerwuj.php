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
		var addeCar=0;
	function doNothing() {}
	function OnAddNewButtonClick() {
		var table = document.getElementById('AddCar');
		table.style.display = (table.style.display == "none") ? "table ": "none";
		var label1 = document.getElementById("BadData");
		label1.innerHTML = "";
		var label2 = document.getElementById("SuccessOnAdd");
		label2.innerHTML = "";
	}
    function OnAddCarToDatabaseClicked() {
		addCarToDatabase(function(data){
			var xml = data.responseXML;
        var res = xml.documentElement.getElementsByTagName("result");
		if (res.length>0) {
			if (res[0].getAttribute("transsactionResulst")==0) {
				document.getElementById('BadData').innerHTML = res[0].getAttribute("transsactionResulst");
			
				document.getElementById('BadData').innerHTML = '';
				document.getElementById('SuccessOnAdd').innerHTML = "Samochód "+ document.forms[0].marka.value + " "+ document.forms[0].model.value +
				" o numerze rejestracyjnym " + document.forms[0].nr_rej.value +" został pomyślnie dodany do bazy.";
			
				document.forms[0].marka.value="";
				document.forms[0].model.value="";
				document.forms[0].nr_rej.value="";
			}
			else{
				document.getElementById('BadData').innerHTML = "Błąd wewnętrzny [addCar: "+res[0].getAttribute("transsactionResulst")+"]";
			}
			
		}
		else
		{
			document.getElementById('BadData').innerHTML = "Błąd wewnętrzny.";
		}
			addeCar=1;
			OnMyCarsClick();
		});
			
        }

	  
	function addCarToDatabase(callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;
		  
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };
	  
	  	if ((document.forms[0].marka.value=="")||(document.forms[0].model.value=="")||(document.forms[0].nr_rej.value=="")) {
			document.getElementById('SuccessOnAdd').innerHTML ="";
			document.getElementById('BadData').innerHTML = 'Powyższe pola nie mogą być pozostawione puste jeżeli chcesz poprawnie dodać samochód do bazy danych.';
		}else{
			request.open("GET","addCar.php?nr_rej="+document.forms[0].nr_rej.value+"&marka="+document.forms[0].marka.value+"&model="+
					 document.forms[0].model.value+"&zid=1",true);
			request.send(null);
			
		}

	}
	
	
	function changeIRCode(callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;
		  
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };
	  
	  	request.open("GET","changeCode.php?currentCode= "+document.getElementById('meta1').innerHTML,true);
		request.send(null);

	}

	function setCodeChangeButton(t) {
    var td = document.getElementById(t);
    if (typeof window.addEventListener==='function'){
      td.addEventListener('click',function(){
		var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;
			/*request.open("GET","changeCode.php?currentCode="+t,true);
			request.send(null);*/
			document.getElementById('meta1').innerHTML = t;
			changeIRCode(function(data){
			var xml = data.responseXML;
        var res = xml.documentElement.getElementsByTagName("result");
		if (res.length>0) {
			if (res[0].getAttribute("transsactionResulst")==0) {
				document.getElementById('meta1').innerHTML = "";
				var stable = document.getElementById('ShareCar');
				
				//stable.style.display = "none"; 
				addeCar=1;
				OnMyCarsClick()
				document.getElementById('BadData').innerHTML = res[0].getAttribute("transsactionResulst");
			
				document.getElementById('BadData').innerHTML = '';
			}
			else{
				document.getElementById('BadData').innerHTML = "Błąd wewnętrzny [addCar: "+res[0].getAttribute("transsactionResulst")+"]";
			}
			
		}
		else
		{
			document.getElementById('BadData').innerHTML = "Błąd wewnętrzny.";
		}
		
		});
		;	
      });
    }
	}
	function OnMyCarsClick() {
		var table = document.getElementById('People');
		table.style.display = "none";
		
		var stable = document.getElementById('ShareCar');
		stable.style.display = "none";
		document.getElementById('CarToShare').innerHTML = "";
		/*var labelcar = document.getElementById('CarToShare');
		labelcar.style.display = "none";*/
		//stable.innerHTML ="";
		 //document.getElementById('CarToShare').innerHTML ="";
		 var table = document.getElementById('carsTable');
			table.innerHTML ="";
		 if (addeCar!=1) {
			table.style.display = (table.style.display == "none") ? "table ": "none";
		 }
		 addeCar=0;
		 
	  getCars("get_cars.php", function(data) {
        var xml = data.responseXML;
		//document.write(xml.documentElement.getElementsByTagName("cars"));
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
			
			var nc_kod = document.createElement("TD");
			var nd_kod = document.createTextNode("Kod wjazdowy");
			nc_kod.appendChild(nd_kod);
			document.getElementById("nagl").appendChild(nc_kod);
			
			var nc_change = document.createElement("TD");
			var nd_change = document.createTextNode("-----------------------");
			nc_change.appendChild(nd_change);
			document.getElementById("nagl").appendChild(nc_change);
			
			var nc_share = document.createElement("TD");
			var nd_share = document.createTextNode("-----------------------");
			nc_share.appendChild(nd_share);
			document.getElementById("nagl").appendChild(nc_share);
			
		}

        for ( var i = 0; i < cars.length; i++) {
          var idSamochod = cars[i].getAttribute("id_Samochod");
		  var nrRej = cars[i].getAttribute("nrRej");
		  //var wlasciciel = cars[i].getAttribute("wlasciciel");
		  var marka = cars[i].getAttribute("marka");
		  var model = cars[i].getAttribute("model");
		  //var Zidentyfikowany = cars[i].getAttribute("Zidentyfikowany");
		  var kod = cars[i].getAttribute("kod");

			var y = document.createElement("TR");
			y.setAttribute("id", idSamochod+"zk");
			document.getElementById("carsTable").appendChild(y);

			var c_marka = document.createElement("TD");
			var d_marka = document.createTextNode(marka);
			c_marka.appendChild(d_marka);
			document.getElementById(idSamochod+"zk").appendChild(c_marka);
			
			var c_model = document.createElement("TD");
			var d_model = document.createTextNode(model);
			c_model.appendChild(d_model);
			document.getElementById(idSamochod+"zk").appendChild(c_model);
			
			var c_nrRej = document.createElement("TD");
			var d_nrRej = document.createTextNode(nrRej);
			c_nrRej.appendChild(d_nrRej);
			document.getElementById(idSamochod+"zk").appendChild(c_nrRej);
			
			var c_kod = document.createElement("TD");
			var d_kod = document.createTextNode(kod);
			c_kod.appendChild(d_kod);
			document.getElementById(idSamochod+"zk").appendChild(c_kod);
			
			
			var c_change = document.createElement("BUTTON");
			var d_change = document.createTextNode("Zmień kod");
			c_change.appendChild(d_change);
			document.getElementById(idSamochod+"zk").appendChild(c_change);
			c_change.setAttribute("id",kod);
			setCodeChangeButton(kod);
			
			/*var c_kod2 = document.createElement("TD");
			var d_kod2= document.createTextNode("");
			c_kod2.appendChild(d_kod2);
			document.getElementById(idSamochod).appendChild(c_kod2);*/
			
			var c_share = document.createElement("BUTTON");
			var d_share = document.createTextNode("Udostępnij");
			c_share.appendChild(d_share);
			document.getElementById(idSamochod+"zk").appendChild(c_share);
			c_share.setAttribute("id",-idSamochod);
			setShareButton(-idSamochod,nrRej,marka,model);
			
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
	
	function setShareButton(t,nrRej,marka,model) {
    var td2 = document.getElementById(t);
    if (typeof window.addEventListener==='function'){
      td2.addEventListener('click',function(){
	  document.getElementById('idSamochod').innerHTML = -t;
		document.getElementById('CarToShare').innerHTML = "Wyszukaj osobę, "+
		"której chcesz usostępnić samochód "+ marka +" " + model + " o nr rej. "+nrRej;
		var stable = document.getElementById('ShareCar');
		stable.style.display = "table"; 
		var mytable = document.getElementById('carsTable');
		//mytable.style.display = "none";
		
		
			
      });
    }
	}
	
	function shareCar(callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;
		  
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };
	  
	  	request.open("GET","shareCar.php?currentCode= "+document.getElementById('meta1').innerHTML,true);
		request.send(null);

	}	
	function OnSearchPeopleClick() {
		var table = document.getElementById("People");
		//table.style.display = "none";
		table.innerHTML = "";
		table.style.display = "table";// (table.style.display == "none") ? "table ": "none";
			
		searchPeople("searchPeople.php?name="+document.forms[1].imie.value+"&surname="+document.forms[1].nazwisko.value, function(data) {
        var xml = data.responseXML;
        var people = xml.documentElement.getElementsByTagName("person");
		
		if (people.length>0) {
			var row = document.createElement("TR");
			row.setAttribute("id", "pnagl");
			document.getElementById("People").appendChild(row);
			
			var nc_imie = document.createElement("TD");
			var nd_imie = document.createTextNode("Imie");
			nc_imie.appendChild(nd_imie);
			document.getElementById("pnagl").appendChild(nc_imie);
			
			var nc_nazwisko = document.createElement("TD");
			var nd_nazwisko = document.createTextNode("Nazwisko");
			nc_nazwisko.appendChild(nd_nazwisko);
			document.getElementById("pnagl").appendChild(nc_nazwisko);
			
			
		}

        for ( var i = 0; i < people.length; i++) {
          var name = people[i].getAttribute("Imie");
		  var surname = people[i].getAttribute("Nazwisko");
		  var idOsoba = people[i].getAttribute("idOsoba");
			
			var prow = document.createElement("TR");
			prow.setAttribute("id", idOsoba+"wyb");
			document.getElementById("People").appendChild(prow);

			var c_imie = document.createElement("TD");
			var d_imie = document.createTextNode(name);
			c_imie.appendChild(d_imie);
			document.getElementById(idOsoba+"wyb").appendChild(c_imie);
			
			var c_nazwisko = document.createElement("TD");
			var d_nazwisko = document.createTextNode(surname);
			c_nazwisko.appendChild(d_nazwisko);
			document.getElementById(idOsoba+"wyb").appendChild(c_nazwisko);
			
			var c_button = document.createElement("BUTTON");
			var d_button = document.createTextNode("Zatwierd");
			c_button.appendChild(d_button);
			document.getElementById(idOsoba+"wyb").appendChild(c_button);
			c_button.setAttribute("id",idOsoba+"op");
			
			/*var c_button2 = document.createElement("BUTTON");
			var d_button2 = document.createTextNode("Zatwierd");
			c_button2.appendChild(d_button2);
			document.getElementById(idOsoba+"wyb").appendChild(c_button2);
			c_button2.setAttribute("id",7);*/
			setChoseButton(idOsoba+"op");
			
        } 
      });
	}
	
	function searchPeople(url, callback) {
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
	
	function setChoseButton(t) {
		
		var td = document.getElementById(t);
		if (typeof window.addEventListener==='function'){
      td.addEventListener('click',function(){
		
		var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;
			document.getElementById('idOsoba').innerHTML = t;
			
			choosePerson(function(data){
				
			var xml = data.responseXML;
			//alert(t);
        var res = xml.documentElement.getElementsByTagName("result");
		if (res.length>0) {
			if (res[0].getAttribute("transsactionResulst")==0) {
				document.getElementById('BadData').innerHTML = res[0].getAttribute("transsactionResulst");
			
				document.getElementById('BadData').innerHTML = '';
				document.getElementById('CarToShare').innerHTML = "Twój samochód został pomyślnie udostępniony";
				document.getElementById('People').style.display = "none";
				document.getElementById('ShareCar').style.display = "none";
				document.getElementById('carsTable').style.display = "none";
			}
			else{
				document.getElementById('BadData').innerHTML = "Błąd wewnętrzny [addCar: "+res[0].getAttribute("transsactionResulst")+"]";
			}
			
		}
		else
		{
			document.getElementById('BadData').innerHTML = "Błąd wewnętrzny.";
		}
			
		document.getElementById('idOsoba').innerHTML = "";
		
		});
			
      });
	}
			
    }
	
	// wskazanie osoby której usostępnia sie samochód
	function choosePerson(callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;
		  //alert(" l");
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };
	  
	  	request.open("GET","choosePerson.php?car="+document.getElementById('idSamochod').innerHTML+"&person="+document.getElementById('idOsoba').innerHTML,true);
		request.send(null);

	}
	
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
				echo '<h3 align = "center" style = "color:#0000ff">Twój abonametn jest ważny</h3>';
			}
			
			if($_SESSION['status']==1){
				echo '<h3 align = "center" style = "color:#0000ff">Osoba uprzywilejowana</h3>';
			}
			
			echo '
			
			<input type="button" value="Dodaj nowy samochód" name = "addNewButton" onclick= "OnAddNewButtonClick() "/>
			<form name="dodaj">
			
			<table id = "AddCar" style = "display:none">
				<tr><td>Nr rejestracyjny:</td><td><input type="text" name = "nr_rej" size="20"/></td></tr>
				<tr><td>Marka:</td><td><input type="text" name = "marka"  size="20"/></td></tr>
				<tr><td>Model:</td><td><input type="text" name = "model"  size="20"/></td>
				<td><input type="button" value="Zatwierdź" name = "update" onclick= "OnAddCarToDatabaseClicked()"/></td></tr>
				</table>
				
			<p style = "color:#FF0000">
				<label id="BadData" ></label>
			</p>
			<label id="SuccessOnAdd" ></label>
          </form>
		  
			<input type="button" value="Moje pojazdy" name = "update2" onclick= "OnMyCarsClick()"/>
		  <table id="carsTable"  width="400" style = "display:none"></table>
		  <input type="hidden" id="meta1" value="">
		  
		  <form name="udostepnij">
			<p >
				<label id="CarToShare" ></label>
			</p>
			
			<table id = "ShareCar" style = "display:none">
				<tr><td>Imię</td><td>Nazwisko</td></tr>
				<tr><td><input type="text" name = "imie" size="20"/></td><td><input type="text" name = "nazwisko" size="20"/></td></tr>
				<td><input type="button" value="Szukaj" name = "search" onclick= "OnSearchPeopleClick()"/></td></tr>
			</table>
			
			
			<input type="hidden" id="idSamochod" value="">
			<input type="hidden" id="idOsoba" value="">
          </form>
		  
			<table id="People" style = "display:table"></table>
			
		  ';
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
