<?php
header("Content-Type: application/json");
session_start();
if (!isset($_SESSION['username'])||$_POST['token']!==$_SESSION['token']){
    echo json_encode(array(
		"success" => false,
                "message" => "You have not logged in"
	));
	exit;
}
$username = $_POST['username'];
try {
     //a new MongoDB connection
    $conn = new Mongo('localhost');

     //connect to test database
    $db = $conn->users;
    
    // a new products collection object
    $collection = $db->reserve;
    if ($username=="owner"){
        $cursor = $collection->find();
    $ans = array();
    foreach ($cursor as $obj){
        $order = array(
            "year" => $obj['year'],
            "month" => $obj['month'],
            "date" => $obj['date'],
            "time" => $obj['time']
        );
        array_push($ans, $order);
    }
    echo json_encode($ans);
    $conn->close();
	exit;
    }
    else {
    $query = array("username"=>$username);
    $cursor = $collection->find($query);
    $ans = array();
    foreach ($cursor as $obj){
        $order = array(
            "year" => $obj['year'],
            "month" => $obj['month'],
            "date" => $obj['date'],
            "time" => $obj['time']
        );
        array_push($ans, $order);
    }
    echo json_encode($ans);
    $conn->close();
	exit;
    }
}
catch ( MongoConnectionException $e )
{
    // if there was an error, we catch and display the problem here
    echo $e->getMessage();
}
catch ( MongoException $e )
{
    echo $e->getMessage();
}
?>