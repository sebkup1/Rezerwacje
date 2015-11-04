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
<title>Zarezerwuj</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<link rel="stylesheet" type="text/css" href="myStyle.css">
<style type="text/css"></style>
<script type="text/javascript">
    function addToDatabase() {
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
        
        //xmlhttp.open("GET","addToDatabase.php?name="+name+"&lat="+lat+"&lng="+lng+"&descr="+desc+"&color="+color, true);
        xmlhttp.open("GET","addToDatabase.php?log="+document.forms[0].objName.value);
        xmlhttp.send();
      }
</script>
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

<td width="70%">
          <form name="dodaj">
                <input type="text" name = "objName"  size="13"/>
                <input type="button" value="Log" name="update" onclick= "addToDatabase() "/><br>
            
          </form>
</td>

<td width="10%"  valign="top">
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
