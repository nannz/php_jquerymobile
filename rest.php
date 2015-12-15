<?php
//echo'php is the best language';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

//echo " Slim";

function dbConnect(){
  $dbHost = "localhost";
  $dbName = "forum";
  $dbUser = "a";
  $dbPass = "a";

  $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
  return $db;
}

//echo "{\n";
//echo '"api":{' . "\n";

$app->post('/message/', function() {

  echo "{\n";
  echo '"api":{' . "\n";
  $name = $_POST['name'];
  $message = $_POST['comment'];

  $db = dbConnect();
  $insert = $db->prepare("INSERT INTO messages (name,message) VALUES ('$name','$message')"); 
  $insert->execute();
  print_r($insert);
  echo '"status":"success"';

  echo "}\n";
  echo "}\n";
});

$app->get('/comment/', function() {
  $db = dbConnect();
  $select = $db->query("SELECT * FROM messages");
  //echo '"name": ' . "[\n";
  $output = '';
  while($row = $select->fetch()) {
    $output .= "<p>" . $row['name'] . " : " . $row['message'] . "</p>";
  }
  echo $output;


 /* $db = dbConnect();
  $select = $db->query("SELECT * FROM messages");
  echo '"message": ' . "[\n";
  $message = '';
  while($row = $select->fetch()) {
    $message .= $row['message'] . ',';
  }
  $message = rtrim($message, ",");
  echo $message;
  echo "]\n";*/
});

// $app->get('/messages/','getMessages');
// function getMessages(){
//   $db = dbConnect();
//   $select = $db->query("SELECT * FROM messages");
//   $values='';
//   while($row = $select->fetch()){
//     $values .= '"' . $row['message'] . '"' . ',';
//   }
//   $values = rtrim($values,",");

//   echo $values;
//   echo "\n";
// }
$app->run();

//echo "}\n";
//echo "}\n";

?>