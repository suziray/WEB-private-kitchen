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
$dishname = $_POST['dishname'];
$comment = $_POST['comment'];
try {
     //a new MongoDB connection
    $conn = new Mongo('localhost');

     //connect to test database
    $db = $conn->users;
    
    // a new products collection object
    $collection = $db->comment;
    $insert = array(
        "dishname"=> $dishname,
        "comment" => $comment
    );
    $collection->insert($insert);
    echo json_encode(array(
		"success" => true
	    ));
    $conn->close();
	exit;
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