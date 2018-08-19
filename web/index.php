<?PHP

echo("PHP is working");
var_dump( realpath( __DIR__ . '/../..' ) );
$cleardb_url      = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server   = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db       = substr($cleardb_url["path"],1);

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'   => '',
    'hostname' => $cleardb_server,
    'username' => $cleardb_username,
    'password' => $cleardb_password,
    'database' => $cleardb_db,
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
/* Below is deprecated
$hostname = "localhost"; // eg. mysql.yourdomain.com (unique)
$username = "root";   // the username specified when setting-up the database
$password = "";   // the password specified when setting-up the database
$database = "snowden";   // the database name chosen when setting-up the database (unique)
$tablename = "users"; //name of table to connect to
*/
$link = mysql_connect($cleardb_server,$cleardb_username,$cleardb_password);
		@mysql_select_db($cleardb_db) or die( "Unable to select database!");
		mysql_query("SET NAMES 'utf8'");
	mysql_query("SET CHARACTER SET utf8");
	mysql_query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");
	
	
	$data = json_decode(file_get_contents('php://input'), true);
//if post
if($data!=""){
	//POST logic
	$name = $data['name'];
	$profile_pic_url = $data['profile_pic_url'];
	$eth_address = $data['eth_address'];
	$query="INSERT INTO `users`(`name`,`profile_pic_url`,`eth_address`) VALUES ('".$name."','".$profile_pic_url."','".$eth_address."')";
	$go=mysql_query($query) or die(mysql_error());
	echo("record created");
} else {
	//GET logic
	if (isset($_GET['id'])){
		//fetch a specific record
		$query="SELECT CONCAT('[', better_result, ']') AS best_result FROM
(
SELECT GROUP_CONCAT('{', my_json, '}' SEPARATOR ',') AS better_result FROM
(
  SELECT 
    CONCAT
    (
      '\"id\":'   , '\"', id   , '\"', ',' 
      '\"name\":', '\"', name, '\"', ','
      '\"eth_address\":', '\"', eth_address, '\"', ','
      '\"profile_pic_url\":', '\"', profile_pic_url, '\"'
    ) AS my_json
  FROM users
  WHERE id = ".$_GET['id']."
) AS more_json
) AS yet_more_json;";
		$go=mysql_query($query) or die(mysql_error());
		$result = mysql_result($go, 0);
		echo($result);
	} else {
		//fetch all records
		$query="SELECT CONCAT('[', better_result, ']') AS best_result FROM
(
SELECT GROUP_CONCAT('{', my_json, '}' SEPARATOR ',') AS better_result FROM
(
  SELECT 
    CONCAT
    (
      '\"id\":'   , '\"', id   , '\"', ',' 
      '\"name\":', '\"', name, '\"', ','
      '\"eth_address\":', '\"', eth_address, '\"', ','
      '\"profile_pic_url\":', '\"', profile_pic_url, '\"'
    ) AS my_json
  FROM users
) AS more_json
) AS yet_more_json;";
		$go=mysql_query($query) or die(mysql_error());
		$result = mysql_result($go, 0);
		echo($result);
	}
}

?>