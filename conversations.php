<?PHP
include 'mysql.php';

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
	echo("record created");
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

?>