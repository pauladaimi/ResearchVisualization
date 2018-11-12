<?php

$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "myschema";

// Create connection
global $conn;
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM mytable";
$result = $conn->query($sql);
$arrayResult = array();

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	   $r=array( $row["Time"],  $row["AX"] );
       $arrayResult[] = $r;
    }
} else {
    echo "0 results";
}

echo json_encode($arrayResult);

?>