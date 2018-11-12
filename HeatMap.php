<?php

if(isset($_POST["fname"]))
{
  $offset = $_POST['Offset'];
  if($_POST["fname"] === "func1"){
    $time = $_POST['Time'];
    php_func($time,$offset);
  }
  else if($_POST["fname"] === "func2"){
    php_func2($offset);
  }
}

function php_func($time,$offset){
$servername = "localhost";
$username = "root";
$password = "paul";
$dbname = "research";
global $conn;

	// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM myfbg where time=".$time." limit 100 offset 0";
$result = $conn->query($sql);
$arrayResult = array();

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc())
	{
	   $r=array( $row["sensorid"],  $row["structureid"], $row["time"], $row["lattitude"], $row["longitude"], $row["altitude"], $row["strain"]);
       $arrayResult[] = $r;
    }
}
else
{
    
}
echo json_encode($arrayResult);

//echo json_encode($time);

 }


function php_func2($offset){
$servername = "localhost";
$username = "root";
$password = "paul";
$dbname = "research";
global $conn;

	// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM myfbg limit 1 offset ".$offset;
$result = $conn->query($sql);
$arrayResult = array();

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc())
	{
       $arrayResult[] = $row["sensorid"];
       $arrayResult[] = $row["structureid"];
       $arrayResult[] = $row["time"];
       $arrayResult[] = $row["lattitude"];
       $arrayResult[] = $row["longitude"];
       $arrayResult[] = $row["altitude"];
       $arrayResult[] = $row["strain"];

    }
}
else
{
    
}

echo json_encode($arrayResult);

//echo json_encode($time);

 }

?>