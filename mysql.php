<?PHP
error_reporting(0);
$hostname = "localhost"; // eg. mysql.yourdomain.com (unique)
$username = "root";   // the username specified when setting-up the database
$password = "";   // the password specified when setting-up the database
$database = "snowden";   // the database name chosen when setting-up the database (unique)
$tablename = "users"; //name of table to connect to

$link = mysql_connect($hostname,$username,$password);
		@mysql_select_db($database) or die( "Unable to select database!");
		mysql_query("SET NAMES 'utf8'");
	mysql_query("SET CHARACTER SET utf8");
	mysql_query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");
    
?>
