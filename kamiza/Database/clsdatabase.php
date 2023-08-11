<?
/*
define("HOST","localhost");
define("MYSQL_USER", "u406074773_kamiza");
define("PASSWORD", "Kamiza@321");
define("MYSQL_DB","u406074773_kamiza");


class database
{
function database()
{
mysql_connect(HOST,MYSQL_USER,PASSWORD)or die(mysql_error());
mysql_select_db(MYSQL_DB) or die(mysql_error());
}
}
*/

class database
{
function database()
{
global $mysqli;    
$mysqli = new mysqli("localhost","u406074773_kamiza","Kamiza@321","u406074773_kamiza");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
return $mysqli;
}
}
?>
