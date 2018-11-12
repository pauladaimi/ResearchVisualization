<?php

if(isset($_POST['funcname']))
{
    $funcname = $_POST['funcname'];

    if($funcname === "func1")
    {
		$TYPE = $_POST['Type'];
		$OFFSET = $_POST['Offset'];
        php_func($TYPE, $OFFSET);
    }
    else if($funcname ==="func2")
    {
		$ID = $_POST['ID'];
		$TIME = $_POST['Time'];
		$TYPE = $_POST['Type'];
		$LASTTIME = $_POST['LastTime'];
        php_func2($ID, $TIME, $TYPE, $LASTTIME);
    }
    else if($funcname ==="func3"){
        php_func3();
    }
}

function php_func($TYPE, $OFFSET){
$servername = "localhost";
$username = "root";
$password = "paul";
$dbname = "research";

// Create connection
global $conn;
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM measures where Time>0 LIMIT 1 OFFSET ".$OFFSET;
$result = $conn->query($sql);
$arrayResult = array();

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$arrayResult[] = $row["ID"];
        $arrayResult[] = $row["Time"];
        $arrayResult[] = $row["Lattitude"];
        $arrayResult[] = $row["Longitude"];
        $arrayResult[] = $row[$TYPE];
    }
} else {
    echo "0 results";
}

echo json_encode($arrayResult);

    }

function php_func2($ID, $TIME, $TYPE, $LASTTIME){
$servername = "localhost";
$username = "root";
$password = "paul";
$dbname = "research";

// Create connection
global $conn;
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM measures where ID=".$ID." and Time<".$TIME." and Time>".$LASTTIME;
$result = $conn->query($sql);
$arrayResult = array();

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$arrayResult[] = $row["ID"];
        $arrayResult[] = $row["Time"];
        $arrayResult[] = $row["Lattitude"];
        $arrayResult[] = $row["Longitude"];
        $arrayResult[] = $row[$TYPE];
    }
} else {
    echo "0 results";
}

echo json_encode($arrayResult);

    }

function php_func3(){
$servername = "localhost";
$username = "root";
$password = "paul";
$dbname = "research";

// Create connection
global $conn;
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT DISTINCT ID from measures";
$result = $conn->query($sql);
$arrayResult = array();

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
       // echo "Name: " . $row["Name"]. " - Age: " . $row["Age"];
        $arrayResult[] = $row["ID"];
    }
} else {
    echo "0 results";
}

echo json_encode($arrayResult);

    }

?>