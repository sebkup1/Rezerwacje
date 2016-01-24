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
		var shareAboTabVisible=0;
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
				//document.getElementById('BadData').innerHTML = res[0].getAttribute("transsactionResulst");
			
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
				//document.getElementById('BadData').innerHTML = res[0].getAttribute("transsactionResulst");
			
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
		document.getElementById('udst').innerHTML = "";
		document.getElementById('myauta').innerHTML = "";
		document.getElementById('udstKomus').innerHTML = "";
		document.getElementById('obcAboMi').innerHTML = "";
		document.getElementById('mojAboKomus').innerHTML = "";
		document.getElementById('BadDataUdstMyCar').innerHTML = "";
		document.getElementById('SuccessUdstMyCar').innerHTML = "";
		

		 var table  = document.getElementById('carsTable');
			table.innerHTML ="";
		 var table2 = document.getElementById('alienCarsTable');
			table2.innerHTML ="";//
		 var table3 = document.getElementById('MyCarsAlienAboTable');
			table3.innerHTML ="";//
		 var table4 = document.getElementById('AlienCarsMyAboTable');
			table4.innerHTML ="";
		 var table5 = document.getElementById('myCarsToAlienTable');
			table5.innerHTML ="";
		 if (addeCar!=1) {
			table.style.display  = (table.style.display  == "none") ? "table ": "none";
			table2.style.display = (table2.style.display == "none") ? "table ": "none";
			table3.style.display = (table3.style.display == "none") ? "table ": "none";
			table4.style.display = (table4.style.display == "none") ? "table ": "none";
			table5.style.display = (table5.style.display == "none") ? "table ": "none";
		 }
		 addeCar=0;
		 
		 if (table.style.display=="none") {
			return;
		 }
		 
	  getCars("get_cars.php?idOsoba=0"+"&operator=0", function(data) {
		
        var xml = data.responseXML;
		//document.write(xml.documentElement.getElementsByTagName("cars"));
        var cars = xml.documentElement.getElementsByTagName("car");
		
		if (cars.length>0) {
			document.getElementById('myauta').innerHTML = "> Auta, których jestem właścicielem";
			document.getElementById('myauta').style.fontWeight = 'bold';
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
			var nd_nrRej = document.createTextNode("Nr rejestracyjny");
			nc_nrRej.appendChild(nd_nrRej);
			document.getElementById("nagl").appendChild(nc_nrRej);
			
			var nc_kod = document.createElement("TD");
			var nd_kod = document.createTextNode("Kod wjazdowy");
			nc_kod.appendChild(nd_kod);
			document.getElementById("nagl").appendChild(nc_kod);
			
			/*var nc_change = document.createElement("TD");
			var nd_change = document.createTextNode("-----------------------");
			nc_change.appendChild(nd_change);
			document.getElementById("nagl").appendChild(nc_change);
			
			var nc_share = document.createElement("TD");
			var nd_share = document.createTextNode("-----------------------");
			nc_share.appendChild(nd_share);
			document.getElementById("nagl").appendChild(nc_share);*/
			
		}

        for ( var i = 0; i < cars.length; i++) {
          var idSamochod = cars[i].getAttribute("id_Samochod");//id_Samochod
		  var idosoba_samochod = cars[i].getAttribute("idosoba_samochod");
		  var nrRej = cars[i].getAttribute("nrRej");
		  //var wlasciciel = cars[i].getAttribute("wlasciciel");
		  var marka = cars[i].getAttribute("marka");
		  var model = cars[i].getAttribute("model");
		  //var Zidentyfikowany = cars[i].getAttribute("Zidentyfikowany");
		  var kod = cars[i].getAttribute("kod");

			var y = document.createElement("TR");
			y.setAttribute("id", idosoba_samochod+"zk");
			document.getElementById("carsTable").appendChild(y);

			var c_marka = document.createElement("TD");
			var d_marka = document.createTextNode(marka);
			c_marka.appendChild(d_marka);
			document.getElementById(idosoba_samochod+"zk").appendChild(c_marka);
			
			var c_model = document.createElement("TD");
			var d_model = document.createTextNode(model);
			c_model.appendChild(d_model);
			document.getElementById(idosoba_samochod+"zk").appendChild(c_model);
			
			var c_nrRej = document.createElement("TD");
			var d_nrRej = document.createTextNode(nrRej);
			c_nrRej.appendChild(d_nrRej);
			document.getElementById(idosoba_samochod+"zk").appendChild(c_nrRej);
			
			var c_kod = document.createElement("TD");
			var d_kod = document.createTextNode(kod);
			c_kod.appendChild(d_kod);
			document.getElementById(idosoba_samochod+"zk").appendChild(c_kod);
			
			
			var c_change = document.createElement("BUTTON");
			var d_change = document.createTextNode("Zmień kod");
			c_change.appendChild(d_change);
			document.getElementById(idosoba_samochod+"zk").appendChild(c_change);
			c_change.setAttribute("id",kod);
			setCodeChangeButton(kod);
			
			/*var c_kod2 = document.createElement("TD");
			var d_kod2= document.createTextNode("");
			c_kod2.appendChild(d_kod2);
			document.getElementById(idSamochod).appendChild(c_kod2);*/
			
			var c_share = document.createElement("BUTTON");
			var d_share = document.createTextNode("Udostępnij");
			c_share.appendChild(d_share);
			document.getElementById(idosoba_samochod+"zk").appendChild(c_share);
			c_share.setAttribute("id",idSamochod+"uud");
			setShareButton(idSamochod,nrRej,marka,model);
			
        } 
      });
	  getCars("get_shared_cars.php?scenario=1", function(data) {
		
        var xml = data.responseXML;
        var cars = xml.documentElement.getElementsByTagName("car");
		
		if (cars.length>0) {
			document.getElementById('udst').innerHTML = "> Udostępnione mi w ramach mojego abonamentu";
			document.getElementById('udst').style.fontWeight = 'bold';
			var yy = document.createElement("TR");
			yy.setAttribute("id", "naglu");
			document.getElementById("alienCarsTable").appendChild(yy);
			
			var nc_marka = document.createElement("TD");
			var nd_marka = document.createTextNode("Marka");
			nc_marka.appendChild(nd_marka);
			document.getElementById("naglu").appendChild(nc_marka);
			
			var nc_model = document.createElement("TD");
			var nd_model = document.createTextNode("Model");
			nc_model.appendChild(nd_model);
			document.getElementById("naglu").appendChild(nc_model);
			
			var nc_nrRej = document.createElement("TD");
			var nd_nrRej = document.createTextNode("Nr rejestracyjny");
			nc_nrRej.appendChild(nd_nrRej);
			document.getElementById("naglu").appendChild(nc_nrRej);
			
			var nc_kod = document.createElement("TD");
			var nd_kod = document.createTextNode("Kod wjazdowy");
			nc_kod.appendChild(nd_kod);
			document.getElementById("naglu").appendChild(nc_kod);
			
			var nc_osoba = document.createElement("TD");
			var nd_osoba = document.createTextNode("Osoba udostępniająca samochód");
			nc_osoba.appendChild(nd_osoba);
			document.getElementById("naglu").appendChild(nc_osoba);
			
			/*var nc_change = document.createElement("TD");
			var nd_change = document.createTextNode("-----------------------");
			nc_change.appendChild(nd_change);
			document.getElementById("naglu").appendChild(nc_change);
			
			var nc_share = document.createElement("TD");
			var nd_share = document.createTextNode("-----------------------");
			nc_share.appendChild(nd_share);
			document.getElementById("naglu").appendChild(nc_share);*/
			
		}

        for ( var i = 0; i < cars.length; i++) {
          var idSamochod = cars[i].getAttribute("id_Samochod");//id_Samochod
		  var idosoba_samochod = cars[i].getAttribute("idosoba_samochod");
		  var nrRej = cars[i].getAttribute("nrRej");
		  //var wlasciciel = cars[i].getAttribute("wlasciciel");
		  var marka = cars[i].getAttribute("marka");
		  var model = cars[i].getAttribute("model");
		  //var Zidentyfikowany = cars[i].getAttribute("Zidentyfikowany");
		  var kod = cars[i].getAttribute("kod");
		  var imie = cars[i].getAttribute("Imie");
		  var nazwisko = cars[i].getAttribute("Nazwisko");

			var y = document.createElement("TR");
			y.setAttribute("id", idosoba_samochod+"zku");
			document.getElementById("alienCarsTable").appendChild(y);

			var c_marka = document.createElement("TD");
			var d_marka = document.createTextNode(marka);
			c_marka.appendChild(d_marka);
			document.getElementById(idosoba_samochod+"zku").appendChild(c_marka);
			
			var c_model = document.createElement("TD");
			var d_model = document.createTextNode(model);
			c_model.appendChild(d_model);
			document.getElementById(idosoba_samochod+"zku").appendChild(c_model);
			
			var c_nrRej = document.createElement("TD");
			var d_nrRej = document.createTextNode(nrRej);
			c_nrRej.appendChild(d_nrRej);
			document.getElementById(idosoba_samochod+"zku").appendChild(c_nrRej);
			
			var c_kod = document.createElement("TD");
			var d_kod = document.createTextNode(kod);
			c_kod.appendChild(d_kod);
			document.getElementById(idosoba_samochod+"zku").appendChild(c_kod);
			
			var c_osoba = document.createElement("TD");
			var d_osoba = document.createTextNode(imie+" "+nazwisko);
			c_osoba.appendChild(d_osoba);
			document.getElementById(idosoba_samochod+"zku").appendChild(c_osoba);
			
			var c_change = document.createElement("BUTTON");
			var d_change = document.createTextNode("Zmień kod");
			c_change.appendChild(d_change);
			document.getElementById(idosoba_samochod+"zku").appendChild(c_change);
			c_change.setAttribute("id",kod);
			setCodeChangeButton(kod);
        } 
      });
	  getCars("get_shared_cars.php?scenario=0", function(data) {
		
        var xml = data.responseXML;
        var cars = xml.documentElement.getElementsByTagName("car");
		
		if (cars.length>0) {
			document.getElementById('udstKomus').innerHTML = "> Udostępnione innym w ramach ich abonamentu";
			document.getElementById('udstKomus').style.fontWeight = 'bold';
			var yy = document.createElement("TR");
			yy.setAttribute("id", "nagluk");
			document.getElementById("myCarsToAlienTable").appendChild(yy);
			
			var nc_marka = document.createElement("TD");
			var nd_marka = document.createTextNode("Marka");
			nc_marka.appendChild(nd_marka);
			document.getElementById("nagluk").appendChild(nc_marka);
			
			var nc_model = document.createElement("TD");
			var nd_model = document.createTextNode("Model");
			nc_model.appendChild(nd_model);
			document.getElementById("nagluk").appendChild(nc_model);
			
			var nc_nrRej = document.createElement("TD");
			var nd_nrRej = document.createTextNode("Nr rejestracyjny");
			nc_nrRej.appendChild(nd_nrRej);
			document.getElementById("nagluk").appendChild(nc_nrRej);
			
			/*var nc_kod = document.createElement("TD");
			var nd_kod = document.createTextNode("Kod wjazdowy");
			nc_kod.appendChild(nd_kod);
			document.getElementById("nagluk").appendChild(nc_kod);*/
			
			var nc_osoba = document.createElement("TD");
			var nd_osoba = document.createTextNode("Osoba, której udostępniono samochód");
			nc_osoba.appendChild(nd_osoba);
			document.getElementById("nagluk").appendChild(nc_osoba);
			
			/*var nc_change = document.createElement("TD");
			var nd_change = document.createTextNode("-----------------------");
			nc_change.appendChild(nd_change);
			document.getElementById("naglu").appendChild(nc_change);
			
			var nc_share = document.createElement("TD");
			var nd_share = document.createTextNode("-----------------------");
			nc_share.appendChild(nd_share);
			document.getElementById("naglu").appendChild(nc_share);*/
			
		}

        for ( var i = 0; i < cars.length; i++) {
          var idSamochod = cars[i].getAttribute("id_Samochod");//id_Samochod
		  var idosoba_samochod = cars[i].getAttribute("idosoba_samochod");
		  var nrRej = cars[i].getAttribute("nrRej");
		  //var wlasciciel = cars[i].getAttribute("wlasciciel");
		  var marka = cars[i].getAttribute("marka");
		  var model = cars[i].getAttribute("model");
		  //var Zidentyfikowany = cars[i].getAttribute("Zidentyfikowany");
		  var kod = cars[i].getAttribute("kod");
		  var imie = cars[i].getAttribute("Imie");
		  var nazwisko = cars[i].getAttribute("Nazwisko");

			var y = document.createElement("TR");
			y.setAttribute("id", idosoba_samochod+"zkuk");
			document.getElementById("myCarsToAlienTable").appendChild(y);

			var c_marka = document.createElement("TD");
			var d_marka = document.createTextNode(marka);
			c_marka.appendChild(d_marka);
			document.getElementById(idosoba_samochod+"zkuk").appendChild(c_marka);
			
			var c_model = document.createElement("TD");
			var d_model = document.createTextNode(model);
			c_model.appendChild(d_model);
			document.getElementById(idosoba_samochod+"zkuk").appendChild(c_model);
			
			var c_nrRej = document.createElement("TD");
			var d_nrRej = document.createTextNode(nrRej);
			c_nrRej.appendChild(d_nrRej);
			document.getElementById(idosoba_samochod+"zkuk").appendChild(c_nrRej);
			
			/*var c_kod = document.createElement("TD");
			var d_kod = document.createTextNode(kod);
			c_kod.appendChild(d_kod);
			document.getElementById(idosoba_samochod+"zkuk").appendChild(c_kod);*/
			
			var c_osoba = document.createElement("TD");
			var d_osoba = document.createTextNode(imie+" "+nazwisko);
			c_osoba.appendChild(d_osoba);
			document.getElementById(idosoba_samochod+"zkuk").appendChild(c_osoba);
			
			/*var c_change = document.createElement("BUTTON");
			var d_change = document.createTextNode("Zmień kod");
			c_change.appendChild(d_change);
			document.getElementById(idosoba_samochod+"zkuk").appendChild(c_change);
			c_change.setAttribute("id",kod);
			setCodeChangeButton(kod);*/
        } 
      });
	  getCars("get_sahred_Abo_cars.php?scenario=1", function(data) {
		
        var xml = data.responseXML;
		//document.write(xml.documentElement.getElementsByTagName("cars"));
        var cars = xml.documentElement.getElementsByTagName("car");
		
		if (cars.length>0) {
			document.getElementById('obcAboMi').innerHTML = "> Udostępnione od innych w ramach ich abonamentu";
			document.getElementById('obcAboMi').style.fontWeight = 'bold';
			var yy = document.createElement("TR");
			yy.setAttribute("id", "naglumi");
			document.getElementById("MyCarsAlienAboTable").appendChild(yy);
			
			var nc_marka = document.createElement("TD");
			var nd_marka = document.createTextNode("Marka");
			nc_marka.appendChild(nd_marka);
			document.getElementById("naglumi").appendChild(nc_marka);
			
			var nc_model = document.createElement("TD");
			var nd_model = document.createTextNode("Model");
			nc_model.appendChild(nd_model);
			document.getElementById("naglumi").appendChild(nc_model);
			
			var nc_nrRej = document.createElement("TD");
			var nd_nrRej = document.createTextNode("Nr rejestracyjny");
			nc_nrRej.appendChild(nd_nrRej);
			document.getElementById("naglumi").appendChild(nc_nrRej);
			
			var nc_kod = document.createElement("TD");
			var nd_kod = document.createTextNode("Kod wjazdowy");
			nc_kod.appendChild(nd_kod);
			document.getElementById("naglumi").appendChild(nc_kod);
			
			var nc_osoba = document.createElement("TD");
			var nd_osoba = document.createTextNode("Osoba udostępniająca abonament");
			nc_osoba.appendChild(nd_osoba);
			document.getElementById("naglumi").appendChild(nc_osoba);
			
		}

        for ( var i = 0; i < cars.length; i++) {
          var idSamochod = cars[i].getAttribute("id_Samochod");//id_Samochod
		  var idosoba_samochod = cars[i].getAttribute("idosoba_samochod");
		  var nrRej = cars[i].getAttribute("nrRej");
		  var marka = cars[i].getAttribute("marka");
		  var model = cars[i].getAttribute("model");
		  var kod = cars[i].getAttribute("kod");
		  var imie = cars[i].getAttribute("Imie");
		  var nazwisko = cars[i].getAttribute("Nazwisko");

			var y = document.createElement("TR");
			y.setAttribute("id", idosoba_samochod+"zkumi");
			document.getElementById("MyCarsAlienAboTable").appendChild(y);

			var c_marka = document.createElement("TD");
			var d_marka = document.createTextNode(marka);
			c_marka.appendChild(d_marka);
			document.getElementById(idosoba_samochod+"zkumi").appendChild(c_marka);
			
			var c_model = document.createElement("TD");
			var d_model = document.createTextNode(model);
			c_model.appendChild(d_model);
			document.getElementById(idosoba_samochod+"zkumi").appendChild(c_model);
			
			var c_nrRej = document.createElement("TD");
			var d_nrRej = document.createTextNode(nrRej);
			c_nrRej.appendChild(d_nrRej);
			document.getElementById(idosoba_samochod+"zkumi").appendChild(c_nrRej);
			
			var c_kod = document.createElement("TD");
			var d_kod = document.createTextNode(kod);
			c_kod.appendChild(d_kod);
			document.getElementById(idosoba_samochod+"zkumi").appendChild(c_kod);
			
			var c_osoba = document.createElement("TD");
			var d_osoba = document.createTextNode(imie+" "+nazwisko);
			c_osoba.appendChild(d_osoba);
			document.getElementById(idosoba_samochod+"zkumi").appendChild(c_osoba);
			
			var c_change = document.createElement("BUTTON");
			var d_change = document.createTextNode("Zmień kod");
			c_change.appendChild(d_change);
			document.getElementById(idosoba_samochod+"zkumi").appendChild(c_change);
			c_change.setAttribute("id",kod);
			setCodeChangeButton(kod);
        } 
      });
	  
	  getCars("get_sahred_Abo_cars.php?scenario=0", function(data) {
		
        var xml = data.responseXML;
		//document.write(xml.documentElement.getElementsByTagName("cars"));
        var cars = xml.documentElement.getElementsByTagName("car");
		
		if (cars.length>0) {
			document.getElementById('mojAboKomus').innerHTML = "> Udostępnienie mojego abonamentu innym";
			document.getElementById('mojAboKomus').style.fontWeight = 'bold';
			var yy = document.createElement("TR");
			yy.setAttribute("id", "naglukom");
			document.getElementById("AlienCarsMyAboTable").appendChild(yy);
			
			var nc_marka = document.createElement("TD");
			var nd_marka = document.createTextNode("Marka");
			nc_marka.appendChild(nd_marka);
			document.getElementById("naglukom").appendChild(nc_marka);
			
			var nc_model = document.createElement("TD");
			var nd_model = document.createTextNode("Model");
			nc_model.appendChild(nd_model);
			document.getElementById("naglukom").appendChild(nc_model);
			
			var nc_nrRej = document.createElement("TD");
			var nd_nrRej = document.createTextNode("Nr rejestracyjny");
			nc_nrRej.appendChild(nd_nrRej);
			document.getElementById("naglukom").appendChild(nc_nrRej);
			
			var nc_kod = document.createElement("TD");
			var nd_kod = document.createTextNode("Kod wjazdowy");
			nc_kod.appendChild(nd_kod);
			document.getElementById("naglukom").appendChild(nc_kod);
			
			var nc_osoba = document.createElement("TD");
			var nd_osoba = document.createTextNode("Osoba, której udostępniono abonament");
			nc_osoba.appendChild(nd_osoba);
			document.getElementById("naglukom").appendChild(nc_osoba);
			
		}

        for ( var i = 0; i < cars.length; i++) {
          var idSamochod = cars[i].getAttribute("id_Samochod");//id_Samochod
		  var idosoba_samochod = cars[i].getAttribute("idosoba_samochod");
		  var nrRej = cars[i].getAttribute("nrRej");
		  var marka = cars[i].getAttribute("marka");
		  var model = cars[i].getAttribute("model");
		  var kod = cars[i].getAttribute("kod");
		  var imie = cars[i].getAttribute("Imie");
		  var nazwisko = cars[i].getAttribute("Nazwisko");

			var y = document.createElement("TR");
			y.setAttribute("id", idosoba_samochod+"zkukom");
			document.getElementById("AlienCarsMyAboTable").appendChild(y);

			var c_marka = document.createElement("TD");
			var d_marka = document.createTextNode(marka);
			c_marka.appendChild(d_marka);
			document.getElementById(idosoba_samochod+"zkukom").appendChild(c_marka);
			
			var c_model = document.createElement("TD");
			var d_model = document.createTextNode(model);
			c_model.appendChild(d_model);
			document.getElementById(idosoba_samochod+"zkukom").appendChild(c_model);
			
			var c_nrRej = document.createElement("TD");
			var d_nrRej = document.createTextNode(nrRej);
			c_nrRej.appendChild(d_nrRej);
			document.getElementById(idosoba_samochod+"zkukom").appendChild(c_nrRej);
			
			var c_kod = document.createElement("TD");
			var d_kod = document.createTextNode(kod);
			c_kod.appendChild(d_kod);
			document.getElementById(idosoba_samochod+"zkukom").appendChild(c_kod);
			
			var c_osoba = document.createElement("TD");
			var d_osoba = document.createTextNode(imie+" "+nazwisko);
			c_osoba.appendChild(d_osoba);
			document.getElementById(idosoba_samochod+"zkukom").appendChild(c_osoba);
			
			/*var c_change = document.createElement("BUTTON");
			var d_change = document.createTextNode("Zmień kod");
			c_change.appendChild(d_change);
			document.getElementById(idosoba_samochod+"zkukom").appendChild(c_change);
			c_change.setAttribute("id",kod);
			setCodeChangeButton(kod);*/
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
    var td2 = document.getElementById(t+"uud");
    if (typeof window.addEventListener==='function'){
      td2.addEventListener('click',function(){
	    document.getElementById('idSamochod').value = t;
		document.getElementById('CarToShare').innerHTML = "Wyszukaj osobę, "+
		"której chcesz usostępnić samochód "+ marka +" " + model + " o nr rej. "+nrRej;
		var stable = document.getElementById('ShareCar');
		stable.style.display = "table"; 
		//var mytable = document.getElementById('carsTable');
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
	function OnSearchPeopleClick(whichTable) {
		var table, buttonText;
		var sname, ssurname;
		//document.getElementById("onMyAboLabel").style.display = "none";
		//document.getElementById("onMyAbo").style.display = "none";
		/*onMyAboLabel
			onMyAbo*/
		if (whichTable==1) {
			table = document.getElementById("People");
			sname=document.forms[1].imie.value;
			ssurname=document.forms[1].nazwisko.value;
			buttonText="Zatwierdź";
		}
		else if (whichTable==2) {
			table = document.getElementById("People2");
			sname=document.forms[2].imie2.value;
			ssurname=document.forms[2].nazwisko2.value;
			buttonText="Samochody";
		}
		
		//table.style.display = "none";
		table.innerHTML = "";
		table.style.display = "table";// (table.style.display == "none") ? "table ": "none";
			
		searchPeople("searchPeople.php?name="+sname+"&surname="+ssurname, function(data) {
        var xml = data.responseXML;
        var people = xml.documentElement.getElementsByTagName("person");
		
		if (people.length>0) {
			var row = document.createElement("TR");
			row.setAttribute("id", "pnagl"+whichTable);
			table.appendChild(row);
			
			var nc_imie = document.createElement("TD");
			var nd_imie = document.createTextNode("Imie");
			nc_imie.appendChild(nd_imie);
			document.getElementById("pnagl"+whichTable).appendChild(nc_imie);
			
			var nc_nazwisko = document.createElement("TD");
			var nd_nazwisko = document.createTextNode("Nazwisko");
			nc_nazwisko.appendChild(nd_nazwisko);
			document.getElementById("pnagl"+whichTable).appendChild(nc_nazwisko);
			
		}

        for ( var i = 0; i < people.length; i++) {
          var name = people[i].getAttribute("Imie");
		  var surname = people[i].getAttribute("Nazwisko");
		  var idOsoba = people[i].getAttribute("idOsoba");
			
			var prow = document.createElement("TR");
			prow.setAttribute("id", idOsoba+"wyb"+whichTable);
			table.appendChild(prow);

			var c_imie = document.createElement("TD");
			var d_imie = document.createTextNode(name);
			c_imie.appendChild(d_imie);
			document.getElementById(idOsoba+"wyb"+whichTable).appendChild(c_imie);
			
			var c_nazwisko = document.createElement("TD");
			var d_nazwisko = document.createTextNode(surname);
			c_nazwisko.appendChild(d_nazwisko);
			document.getElementById(idOsoba+"wyb"+whichTable).appendChild(c_nazwisko);
			
			var c_button = document.createElement("BUTTON");
			var d_button = document.createTextNode(buttonText);
			c_button.appendChild(d_button);
			document.getElementById(idOsoba+"wyb"+whichTable).appendChild(c_button);
			c_button.setAttribute("id",idOsoba+"op"+whichTable);
			
			if (whichTable==1) {
				setChoseButton(idOsoba+"op"+whichTable,idOsoba);
			}
			else if (whichTable==2) {
				setSbcarsButton(idOsoba+"op"+whichTable,idOsoba);
			}
			
			
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
	
	function setChoseButton(t,idOsoba) {
		var td = document.getElementById(t);
		if (typeof window.addEventListener==='function'){
      td.addEventListener('click',function(){
		
		/*var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;*/
		  
			document.getElementById('idOsoba').value = idOsoba;
			
			choosePerson(function(data){
				
			var xml = data.responseXML;

		if (xml!=null) {
			var res = xml.documentElement.getElementsByTagName("result");
			if (res.length>0) {
				if (res[0].getAttribute("transsactionResulst")==0) {
					//document.getElementById('BadData').innerHTML = res[0].getAttribute("transsactionResulst");
			
					document.getElementById('BadData').innerHTML = '';
					//document.getElementById('CarToShare').innerHTML = "Twój samochód został pomyślnie udostępniony";
					document.getElementById('BadDataUdstMyCar').innerHTML = "";
					document.getElementById('SuccessUdstMyCar').innerHTML = "Twój samochód został pomyślnie udostępniony";
					//document.getElementById('People').style.display = "none";
					//document.getElementById('onMyAbo').style.display = "none";
					
					//document.getElementById('ShareCar').style.display = "none";
					//document.getElementById('carsTable').style.display = "none";//
					//document.getElementById('alienCarsTable').style.display = "none";
				}
				else{
					document.getElementById('BadDataUdstMyCar').innerHTML = "Błąd wewnętrzny [addCar: "+res[0].getAttribute("transsactionResulst")+"]";
					document.getElementById('SuccessUdstMyCar').innerHTML = "";
				}
			
			}
			else
			{
				document.getElementById('BadDataUdstMyCar').innerHTML = "Błąd wewnętrzny. Prawdopodobnie już wykonałeś taka operację [empty request]";
				document.getElementById('SuccessUdstMyCar').innerHTML = "";
			}
		}
		else
		{
			document.getElementById('BadDataUdstMyCar').innerHTML = "Błąd wewnętrzny. Prawdopodobnie już wykonałeś taka operację [xml is Null]";
			document.getElementById('SuccessUdstMyCar').innerHTML = "";
		}
			
		document.getElementById('idOsoba').value = "";
		
		});
			
      });
	}
			
    }
	
	// wskazanie osoby której usostępnia sie samochód
	function choosePerson(callback) {
		
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;
		  
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };
	  
	  if (document.getElementById('onMyAbo').checked ) { //Mój abonament
		request.open("GET","choosePerson.php?aboOwner="+0+"&car="+document.getElementById('idSamochod').value+"&person="+document.getElementById('idOsoba').value,true);
		
	  }
	  else{
		request.open("GET","choosePerson.php?aboOwner="+1+"&car="+document.getElementById('idSamochod').value+"&person="+document.getElementById('idOsoba').value,true);
		
	  }
	  	/*request.open("GET","choosePerson.php?aboOwner="+1+"&car="+document.getElementById('idSamochod').value+"&person="+document.getElementById('idOsoba').value,true);
		*/
		request.send(null);

	}
	
	function setSbcarsButton(t,idOsoba) {
		
		var td = document.getElementById(t);
		if (typeof window.addEventListener==='function'){
      td.addEventListener('click',function(){
		
		var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;
			document.getElementById('idOsoba').value = idOsoba;
			
			findSbcars(idOsoba,
					   function(data) {
        var xml = data.responseXML;
		//document.write(xml.documentElement.getElementsByTagName("cars"));
        var cars = xml.documentElement.getElementsByTagName("car");
		
		if (cars.length>0) {
			var yy = document.createElement("TR");
			yy.setAttribute("id", "nagl2");
			document.getElementById("AboCars").appendChild(yy);
			
			var nc_marka = document.createElement("TD");
			var nd_marka = document.createTextNode("Marka");
			nc_marka.appendChild(nd_marka);
			document.getElementById("nagl2").appendChild(nc_marka);
			
			var nc_model = document.createElement("TD");
			var nd_model = document.createTextNode("Model");
			nc_model.appendChild(nd_model);
			document.getElementById("nagl2").appendChild(nc_model);
			
			var nc_nrRej = document.createElement("TD");
			var nd_nrRej = document.createTextNode("Nr rejestracyjny");
			nc_nrRej.appendChild(nd_nrRej);
			document.getElementById("nagl2").appendChild(nc_nrRej);
			
		}

        for ( var i = 0; i < cars.length; i++) {
          var idSamochod = cars[i].getAttribute("id_Samochod");//id_Samochod
		  var idosoba_samochod = cars[i].getAttribute("idosoba_samochod");
		  var nrRej = cars[i].getAttribute("nrRej");
		  //var wlasciciel = cars[i].getAttribute("wlasciciel");
		  var marka = cars[i].getAttribute("marka");
		  var model = cars[i].getAttribute("model");
		  //var Zidentyfikowany = cars[i].getAttribute("Zidentyfikowany");
		  var kod = cars[i].getAttribute("kod");

			var y = document.createElement("TR");
			y.setAttribute("id", idosoba_samochod+"zksb");
			document.getElementById("AboCars").appendChild(y);

			var c_marka = document.createElement("TD");
			var d_marka = document.createTextNode(marka);
			c_marka.appendChild(d_marka);
			document.getElementById(idosoba_samochod+"zksb").appendChild(c_marka);
			
			var c_model = document.createElement("TD");
			var d_model = document.createTextNode(model);
			c_model.appendChild(d_model);
			document.getElementById(idosoba_samochod+"zksb").appendChild(c_model);
			
			var c_nrRej = document.createElement("TD");
			var d_nrRej = document.createTextNode(nrRej);
			c_nrRej.appendChild(d_nrRej);
			document.getElementById(idosoba_samochod+"zksb").appendChild(c_nrRej);
			
			var c_change = document.createElement("BUTTON");
			var d_change = document.createTextNode("Zatwierdź");
			c_change.appendChild(d_change);
			document.getElementById(idosoba_samochod+"zksb").appendChild(c_change);
			c_change.setAttribute("id",kod+"zksb2");
			setChoseSbAboButton(kod+"zksb2",idOsoba,idSamochod);
			
        } 
      });
			
      });
	}
			
    }
	function OnShowSearchForShareAbo() {
		document.getElementById('AboShareLabelOK').innerHTML = "";
		document.getElementById('AboShareLabel').innerHTML = "";//
		document.getElementById('AboCars').innerHTML = "";
		if(shareAboTabVisible == 1)
		{
			var stable = document.getElementById('ShareAbo');
			stable.style.display = "none";
			document.getElementById('SahreAbo').style.display = "none";
			shareAboTabVisible=0;
		}
		else
		{
			var stable = document.getElementById('ShareAbo');
			stable.style.display = "table";
			document.getElementById('SahreAbo').style.display = "table";
			shareAboTabVisible=1;
		}
		
	}
	function findSbcars(idOsoba,callback) {
		//
		document.getElementById('AboCars').innerHTML = "";
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
	  
	  	request.open("GET","get_cars.php?idOsoba="+idOsoba+"&operator=0",true);
		request.send(null);
	}
	function setChoseSbAboButton(t,idOsoba,idSamochod) {
		
		var td = document.getElementById(t);
		if (typeof window.addEventListener==='function'){
      td.addEventListener('click',function(){
		
		var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;
			document.getElementById('idOsobaSB').value = idOsoba;
			document.getElementById('idSamochodSB').value = idSamochod;
			//document.getElementById('idOsoba').value = idOsoba;
			
			choosePersonCarAbo(function(data){
				
			var xml = data.responseXML;
			//alert(t);
        
		if (xml!=null) {
			var res = xml.documentElement.getElementsByTagName("result");
			if (res.length>0) {
				if (res[0].getAttribute("transsactionResulst")==0) {
					//document.getElementById('BadData').innerHTML = res[0].getAttribute("transsactionResulst");
			
					document.getElementById('BadData').innerHTML = '';
					document.getElementById('AboShareLabelOK').innerHTML = "Twój abonament został pomyślnie udostępniony na wskazany samochód danej osoby";
					document.getElementById('AboShareLabel').innerHTML = "";
					/*document.getElementById('People').style.display = "none";
					document.getElementById('ShareCar').style.display = "none";
					document.getElementById('carsTable').style.display = "none";*/
					document.getElementById('AboCars').innerHTML = "";
				}
				else{
					document.getElementById('AboShareLabel').innerHTML = "Błąd wewnętrzny [addCar: "+res[0].getAttribute("transsactionResulst")+"]";
					document.getElementById('AboShareLabelOK').innerHTML = "";
				}
			
			}
			else
			{
				document.getElementById('AboShareLabel').innerHTML = "Błąd wewnętrzny. Prawdopodobnie już wykonałeś taka operację [XML null]";
				document.getElementById('AboShareLabelOK').innerHTML = "";
			}
		}
		else
		{
			document.getElementById('AboShareLabel').innerHTML = "Błąd wewnętrzny. Prawdopodobnie już wykonałeś taką operację [request null]";
			document.getElementById('AboShareLabelOK').innerHTML = "";
		}
			
		//document.getElementById('AboShareLabel').value = "";
		
		});
			
      });
	}
			
    }
	function choosePersonCarAbo(callback) {
		
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
	  //document.getElementById('idSamochod').innerHTML
	  	request.open("GET","choosePerson.php?aboOwner=0&car="+document.getElementById('idSamochodSB').value+"&person="+document.getElementById('idOsobaSB').value,true);
		request.send(null);

	}
	//style = "border-style:inset;"	//dla buttona
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
			
			if($_SESSION['status']==4){
				echo '<h3 align = "center" style = "color:#0000ff">Masz prawo do jednorazowego wjazdu</h3>';
			}
			
			if($_SESSION['status']==3){
				echo '<h3 align = "center" style = "color:#ff0000"> Nie masz uprawnień do wjazdu na teren parkingu</h3>';
			}
			
			if($_SESSION['status']==2){
				echo '<h3 align = "center" style = "color:#0000ff">Twój abonament jest ważny</h3>';
			}
			
			if($_SESSION['status']==1){
				echo '<h3 align = "center" style = "color:#0000ff">Osoba uprzywilejowana</h3>';
			}
			
			echo '
			<input type="hidden" id="idSamochod" value="a">
			<input type="hidden" id="idOsoba" value="a">
			<input type="hidden" id="idOsobaSB" value="a">
			<input type="hidden" id="idSamochodSB" value="a">

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
			<p style = "color:#0000ff">
			<label id="SuccessOnAdd" ></label>
			</p>
          </form>
		  <br>
			<input type="button" value="Moje pojazdy" name = "update2" onclick= "OnMyCarsClick()"/>
			<p >
				<label id="myauta" ></label>
			</p>
		  <table id="carsTable"  width="400" style = "display:none"></table>
		  
		  <form name="udostepnij">
			<p >
				<label id="CarToShare" ></label>
			</p>
			
			<table id = "ShareCar" style = "display:none">
				<tr></tr>
				
				<tr><td>Imię</td><td>Nazwisko</td></tr>
				<tr><td><input type="text" name = "imie" size="20"/></td><td><input type="text" name = "nazwisko" size="20"/></td></tr>
				<td><input type="button" value="Szukaj" name = "search" onclick= "OnSearchPeopleClick(1)"/></td></tr>
				
				<tr><td><input type="checkbox" id = "onMyAbo" />Na mój abonament</td></tr>
			
				
			</table>
			
		
		  </form>
		  <p style = "color:#FF0000"><label id="BadDataUdstMyCar" ></label></p>
		  <p style = "color:#0000ff"><label id="SuccessUdstMyCar" ></label></p>
		  <table id="People" style = "display:none"></table>
		  
		  <p >
				<label id="udst" ></label>
			</p>
			
			
			
		  <table id="alienCarsTable"  width="400" style = "display:none"></table>
		  
		  <p >
				<label id="udstKomus" ></label>
			</p>
			
		  <table id="myCarsToAlienTable"  width="400" style = "display:none"></table>
		  
		   <p >
				<label id="obcAboMi" ></label>
			</p>
		  <table id="MyCarsAlienAboTable"  width="400" style = "display:none"></table>
		  
		  <p >
				<label id="mojAboKomus" ></label>
			</p>
		  <table id="AlienCarsMyAboTable"  width="400" style = "display:none"></table>
		  
		  <input type="hidden" id="meta1" value="">
		  
		  
			
			<br>
			<input type="button" value="Udostępnij w ramach swojego abonamentu" name = "za_swoj" onclick= "OnShowSearchForShareAbo()"/>
			<form>
			<table id = "ShareAbo" style = "display:none">
				<tr><td>Imię</td><td>Nazwisko</td></tr>
				<tr><td><input type="text" name = "imie2" size="20"/></td><td><input type="text" name = "nazwisko2" size="20"/></td></tr>
				<td><input type="button" value="Szukaj" name = "searchSB" onclick= "OnSearchPeopleClick(2)" /></td></tr>
			</table>
			</form>
			<p style = "color:#FF0000">
				<label id="AboShareLabel" ></label>
			</p>
			<p style = "color:#0000ff">
				<label id="AboShareLabelOK" ></label>
			</p>
			<table id="SahreAbo" style = "display:none">
				<tr>
				<td>
					<p>Osoba</p>
				</td>
				<td>
					<p>Samochody</p>
				</td>
				<tr>
				<td>
					<table id="People2" style = "display:none"></table>
				</td>
				<td>
					<table id="AboCars" style = "display:table"></table>
				</td>
				</tr>

			</table>
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