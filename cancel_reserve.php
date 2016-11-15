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
$year = $_POST['year'];
$month = $_POST['month'];
$date = $_POST['date'];
$time = $_POST['time'];
try {
     //a new MongoDB connection
    $conn = new Mongo('localhost');

     //connect to test database
    $db = $conn->users;
    
    // a new products collection object
    $collection = $db->reserve;
    
    $query = array(
                   "year" =>$year,
                   "month" =>$month,
                   "date" =>$date,
                   "time" => $time
                   );
    $cursor = $collection->find($query);
    $count = $cursor->count();
    if ($count==1){
        $collection->remove($query);
        echo json_encode(array("success" => true));
    }
    else {
        echo json_encode(array(
		"success" => false,
		"message" => "System error."
	    ));
    }
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