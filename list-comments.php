<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function dbConnect(){
  $dbHost = "localhost";
  $dbName = "forum";
  $dbUser = "a";
  $dbPass = "a";

  $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
  return $db;
}  

$db = dbConnect();
//only show the two lastest comments.
$select = $db->query("SELECT * FROM messages ORDER BY id DESC LIMIT 5");
$output = '';
while($row = $select->fetch()) {
  $output .= "<p>" . $row['name'] . " : " . $row['message'] . "</p>";
}
echo $output;

?>