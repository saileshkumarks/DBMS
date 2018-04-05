<?php
/*  Connect to a MySQL server 
   Should be put in a separate configuration file.
*/
$mysqli = new mysqli('localhost', 'karaikurichipuds', '1447242', 'sakila');

if (mysqli_connect_errno()) 
{
   printf("Can't open MySQL connection. Error code: %s\n", mysqli_connect_error());
   exit;
}

?> 