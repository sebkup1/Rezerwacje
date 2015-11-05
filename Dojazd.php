<?PHP
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
<html  xmlns="http://www.w3.org/1999/xhtml">

<head>
     <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Dojazd</title>
    <script src="http://maps.google.com/maps/api/js?sensor=false"
            type="text/javascript"></script>
   <script type="text/javascript">
    //<![CDATA[
   //http://127.0.0.1/project/phpsqlajax_map_v3.html
   var infoWindow = new google.maps.InfoWindow;
    var customIcons = {
       blue: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      }
    };
    
    var iconblue = customIcons["blue"] || {};

    function load() {
       map = new google.maps.Map(document.getElementById("map1"), {
        center: new google.maps.LatLng(52.2034, 21.000),
        zoom: 16,
        mapTypeId: 'roadmap'
      });
      
    var myLatLng = {lat: 52.2034841, lng: 21.0020506};
    var marker = new google.maps.Marker({
    position: myLatLng,
    map: map,
    icon: iconblue.icon
  });
    
        google.maps.event.addListener(marker, 'mouseover', function() {
        infoWindow.setContent("<b>" + "Wjazd na parking" + "</b> <br/>" + "Od ul. Narbutta");

        infoWindow.open(map, marker);
  });
    
    }


    //]]>
  </script>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<link rel="stylesheet" type="text/css" href="myStyle.css">
<style type="text/css">

</style>

</head>

<body  onload="load(), hideForm()">
<center>
<table border="0" style="border-collapse: collapse;" width="800px" >
<tr >
<td width="100%" colspan="3">


<script type="text/javascript" src="logo.js"></script>

<br>
<br>
<br>
</td>
</tr>
<tr>
<td width="20%" valign="top">

<script type="text/javascript" src="menu.js"></script>

</td>


<td width="70%">
    <table>
        <tr>
            <font color ="red" size="5" face="arial">
            Dojazd do parkingu wydziału
        </tr>
        <tr>
            <td>
            <form id="map1" style="width: 430px; height: 380px"></form>
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
