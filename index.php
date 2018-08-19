<?PHP
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
// connect to the database
error_reporting(0);
$link = mysql_connect($cleardb_server,$cleardb_username,$cleardb_password);
		@mysql_select_db($cleardb_db) or die( "Unable to select database!");
		mysql_query("SET NAMES 'utf8'");
	mysql_query("SET CHARACTER SET utf8");
	mysql_query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");
	mysql_query("SET SESSION group_concat_max_len=1000000");
	
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: *");
	if (file_exists("src/autoloader.php")) {
		//require "src/autoloader.php";
		//require "vendor/autoload.php";
		//echo "file exists";
		}
	else {
			echo "Please try back in five minutes...\n";
	}
	require_once('src/autoloader.php');
	require_once('vendor/autoload.php');
	use PubNub\PNConfiguration;
	use PubNub\PubNub;
	 
	$pnConfiguration = new PNConfiguration();
	 
	$pnConfiguration->setSubscribeKey("sub-c-9a2966f0-a3cf-11e8-bb88-163ac01f2f4e");
	$pnConfiguration->setPublishKey("pub-c-121bd49e-d8bc-4ca0-8a70-e86e447118e5");
	$pnConfiguration->setSecure(false);
 
$pubnub = new PubNub($pnConfiguration);

if($_GET['type']=="users"){	
	
	$data = json_decode(file_get_contents('php://input'), true);
	//if post
	if($data!=""){
		//POST logic
		$name = $data['name'];
		$profile_pic_url = $data['profile_pic_url'];
		$eth_address = $data['eth_address'];
		$query="INSERT INTO `users`(`name`,`profile_pic_url`,`eth_address`) VALUES ('".$name."','".$profile_pic_url."','".$eth_address."')";
		$go=mysql_query($query) or die(mysql_error());
		$last = mysql_insert_id();
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
	  WHERE id = ".$last."
	) AS more_json
	) AS yet_more_json;";
			$go=mysql_query($query) or die(mysql_error());
			$result = mysql_result($go, 0);
			echo($result);
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
} else if($_GET['type']=="messages"){
		$data = json_decode(file_get_contents('php://input'), true);
	//if post
	if($data!=""){
		//POST logic
		$content = $data['content'];
		$user_id = $data['user_id'];
		$conversation_id = $data['conversation_id'];
		$query="INSERT INTO `messages`(`content`,`user_id`,`conversation_id`) VALUES ('".$content."','".$user_id."','".$conversation_id."')";
		$go=mysql_query($query) or die(mysql_error());
		$last = mysql_insert_id();
		//fetch a specific record
			$query="SELECT CONCAT('[', better_result, ']') AS best_result FROM
	(
	SELECT GROUP_CONCAT('{', my_json, '}' SEPARATOR ',') AS better_result FROM
	(
	  SELECT 
		CONCAT
		(
		  '\"id\":'   , '\"', id   , '\"', ',' 
		  '\"created\":', '\"', created, '\"', ','
		  '\"content\":', '\"', content, '\"', ','
		  '\"user_id\":', '\"', user_id, '\"', ','
		  '\"conversation_id\":', '\"', conversation_id, '\"', ','
		  '\"reported\":', '\"', reported, '\"'
		) AS my_json
	  FROM messages
	  WHERE id = ".$last."
	) AS more_json
	) AS yet_more_json;";
			$go=mysql_query($query) or die(mysql_error());
			$result = mysql_result($go, 0);
			echo($result);
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
		  '\"created\":', '\"', created, '\"', ','
		  '\"content\":', '\"', content, '\"', ','
		  '\"user_id\":', '\"', user_id, '\"', ','
		  '\"conversation_id\":', '\"', conversation_id, '\"', ','
		  '\"reported\":', '\"', reported, '\"'
		) AS my_json
	  FROM messages
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
		  '\"created\":', '\"', created, '\"', ','
		  '\"content\":', '\"', content, '\"', ','
		  '\"user_id\":', '\"', user_id, '\"', ','
		  '\"conversation_id\":', '\"', conversation_id, '\"', ','
		  '\"reported\":', '\"', reported, '\"'
		) AS my_json
	  FROM messages
	) AS more_json
	) AS yet_more_json;";
			$go=mysql_query($query) or die(mysql_error());
			$result = mysql_result($go, 0);
			echo($result);
		}
	}
} else if($_GET['type']=="conversations"){
		$data = json_decode(file_get_contents('php://input'), true);
	//if post
	if($data!=""){
		//POST logic
		$name = $data['name'];
		$expiration_date = $data['expiration_date'];
		$start_distribution = $data['start_distribution'];
		$complete_distribution = $data['complete_distribution'];
		$user_id = $data['user_id'];
		$recipient_id = $data['recipient_id'];
		$amount = $data['amount'];
		$query="INSERT INTO `conversations`(`name`,`expiration_date`,`start_distribution`,`complete_distribution`,`user_id`,`recipient_id`,`amount`) VALUES ('".$name."','".$expiration_date."','".$start_distribution."','".$complete_distribution."','".$user_id."','".$recipient_id."','".$amount."')";
		$go=mysql_query($query) or die(mysql_error());
		$last = mysql_insert_id();
		//fetch a specific record
			$query="SELECT CONCAT('[', better_result, ']') AS best_result FROM
	(
	SELECT GROUP_CONCAT('{', my_json, '}' SEPARATOR ',') AS better_result FROM
	(
	  SELECT 
		CONCAT
		(
		 '\"id\":'   , '\"', id   , '\"', ',' 
		  '\"created\":', '\"', created, '\"', ','
		  '\"status\":', '\"', status, '\"', ','
		  '\"name\":', '\"', name, '\"', ','
		  '\"expiration_date\":', '\"', expiration_date, '\"', ','
		  '\"complete_distribution\":', '\"', complete_distribution, '\"', ','
		  '\"user_id\":', '\"', user_id, '\"', ','
		  '\"recipient_id\":', '\"', recipient_id, '\"', ','
		  '\"amount\":', '\"', amount, '\"', ','
		  '\"start_distribution\":', '\"', start_distribution, '\"'
		) AS my_json
	  FROM conversations
	  WHERE id = ".$last."
	) AS more_json
	) AS yet_more_json;";
			$go=mysql_query($query) or die(mysql_error());
			$result = mysql_result($go, 0);
			echo($result);
	} else {
		//GET logic
		if (isset($_GET['id'])){
			//fetch a specific record
			$query="SELECT CONCAT('[', better_result, '') AS best_result FROM
	(
	SELECT GROUP_CONCAT('{', my_json, ',\"messages\":' SEPARATOR ',') AS better_result FROM
	(
	  SELECT 
		CONCAT
		(
		 '\"id\":'   , '\"', id   , '\"', ',' 
		  '\"created\":', '\"', created, '\"', ','
		  '\"status\":', '\"', status, '\"', ','
		  '\"name\":', '\"', name, '\"', ','
		  '\"expiration_date\":', '\"', expiration_date, '\"', ','
		  '\"complete_distribution\":', '\"', complete_distribution, '\"', ','
		  '\"user_id\":', '\"', user_id, '\"', ','
		  '\"recipient_id\":', '\"', recipient_id, '\"', ','
		  '\"amount\":', '\"', amount, '\"', ','
		  '\"start_distribution\":', '\"', start_distribution, '\"'
		) AS my_json
	  FROM conversations
	  WHERE id = ".$_GET['id']."
	) AS more_json
	) AS yet_more_json;";
			$go=mysql_query($query) or die(mysql_error());
			$result = mysql_result($go, 0);
			echo($result);
			//fetch and append the messages from that conversation next
	$query="SELECT CONCAT('[', better_result, ']}]') AS best_result FROM
	(
		SELECT GROUP_CONCAT('{', my_json, '}' SEPARATOR ',') AS better_result FROM
	(
	  SELECT 
		CONCAT
		(
		'\"id\":'   , '\"', id   , '\"', ',' 
		  '\"created\":', '\"', created, '\"', ','
		  '\"content\":', '\"', content, '\"', ','
		  '\"user_id\":', '\"', user_id, '\"', ','
		  '\"conversation_id\":', '\"', conversation_id, '\"', ','
		  '\"reported\":', '\"', reported, '\"'
		) AS my_json
	  FROM messages
	  WHERE conversation_id = ".$_GET['id']."
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
		  '\"created\":', '\"', created, '\"', ','
		  '\"status\":', '\"', status, '\"', ','
		  '\"name\":', '\"', name, '\"', ','
		  '\"expiration_date\":', '\"', expiration_date, '\"', ','
		  '\"complete_distribution\":', '\"', complete_distribution, '\"', ','
		  '\"user_id\":', '\"', user_id, '\"', ','
		  '\"recipient_id\":', '\"', recipient_id, '\"', ','
		  '\"amount\":', '\"', amount, '\"', ','
		  '\"start_distribution\":', '\"', start_distribution, '\"'
		) AS my_json
	  FROM conversations
	) AS more_json
	) AS yet_more_json;";
			$go=mysql_query($query) or die(mysql_error());
			$result = mysql_result($go, 0);
			echo($result);
		}
	}
}  else if($_GET['type']=="confirmconversation"){
	//this is used to confirm a conversation
		$data = json_decode(file_get_contents('php://input'), true);
	//if post
	if($data!=""){
		//POST logic
		$id = $data['id'];
		$query="UPDATE `conversations` SET status = 'confirmed' WHERE id = ".$id."";
		$go=mysql_query($query) or die(mysql_error());
		$last = mysql_insert_id();
		//fetch a specific record
			$query="SELECT CONCAT('[', better_result, '') AS best_result FROM
	(
	SELECT GROUP_CONCAT('{', my_json, ',\"messages\":' SEPARATOR ',') AS better_result FROM
	(
	  SELECT 
		CONCAT
		(
		 '\"id\":'   , '\"', id   , '\"', ',' 
		  '\"created\":', '\"', created, '\"', ','
		  '\"status\":', '\"', status, '\"', ','
		  '\"name\":', '\"', name, '\"', ','
		  '\"expiration_date\":', '\"', expiration_date, '\"', ','
		  '\"complete_distribution\":', '\"', complete_distribution, '\"', ','
		  '\"user_id\":', '\"', user_id, '\"', ','
		  '\"recipient_id\":', '\"', recipient_id, '\"', ','
		  '\"amount\":', '\"', amount, '\"', ','
		  '\"start_distribution\":', '\"', start_distribution, '\"'
		) AS my_json
	  FROM conversations
	  WHERE id = ".$last."
	) AS more_json
	) AS yet_more_json;";
			$go=mysql_query($query) or die(mysql_error());
			$result = mysql_result($go, 0);
			echo($result);
			//fetch and append the messages from that conversation next
	$query="SELECT CONCAT('[', better_result, ']}]') AS best_result FROM
	(
		SELECT GROUP_CONCAT('{', my_json, '}' SEPARATOR ',') AS better_result FROM
	(
	  SELECT 
		CONCAT
		(
		'\"id\":'   , '\"', id   , '\"', ',' 
		  '\"created\":', '\"', created, '\"', ','
		  '\"content\":', '\"', content, '\"', ','
		  '\"user_id\":', '\"', user_id, '\"', ','
		  '\"conversation_id\":', '\"', conversation_id, '\"', ','
		  '\"reported\":', '\"', reported, '\"'
		) AS my_json
	  FROM messages
	  WHERE conversation_id = ".$last."
	) AS more_json
	) AS yet_more_json;";
			$go=mysql_query($query) or die(mysql_error());
			$result = mysql_result($go, 0);
			echo($result);
	} else {
		//GET logic
		echo ("this endpoint is for POST only");
	}
} else {
	echo("Please specify a type of users, messages, confirmconversation or conversations");
}

?>