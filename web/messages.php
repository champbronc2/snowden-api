<?PHP
include 'mysql.php';

$data = json_decode(file_get_contents('php://input'), true);
//if post
if($data!=""){
	//POST logic
	$content = $data['content'];
	$user_id = $data['user_id'];
	$conversation_id = $data['conversation_id'];
	$query="INSERT INTO `messages`(`content`,`user_id`,`conversation_id`) VALUES ('".$content."','".$user_id."','".$conversation_id."')";
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

?>