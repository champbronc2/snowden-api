<?PHP
include 'mysql.php';

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