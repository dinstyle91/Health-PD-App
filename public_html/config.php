<?php
function OpenCon()
 {
 $dbhost = "localhost";
 $dbuser = "id11299704_root";
 $dbpass = "nikos";
 $db = "id11299704_ehealth";
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

 return $conn;
 }

function CloseCon($conn)
 {
 $conn -> close();
 }

?>
