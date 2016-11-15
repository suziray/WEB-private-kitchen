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
else {
$username = $_SESSION['username'];
$dish = $_POST['dish'];
$year = $_POST['year'];
$month = $_POST['month'];
$date = $_POST['date'];
$time = $_POST['time'];
$noon = $_POST['noon'];
$evening = $_POST['evening'];
try {
     //a new MongoDB connection
    $conn = new Mongo('localhost');

     //connect to test database
    $db = $conn->users;
    
    // a new products collection object
    $collection = $db->reserve;
    if ($noon=="true"){
        $query = array("date"=>$date, "noon"=>$noon);
        $cursor = $collection->find($query);
        $num = $cursor->count();
        if ($num==0){
            $insert = array("username"=> $username, "dish"=>$dish, "year"=>$year, "month"=>$month, "date"=>$date, "time"=>$time, "noon"=>$noon, "evening" =>$evening);
    $collection->insert($insert);
    echo json_encode(array(
		"success" => true
	    ));
        }
        else {
            echo json_encode(array(
		"success" => false,
                "message" => "Please do not try to reserve on a booked slot"
	    ));
        }
    }
    if ($evening=="true"){
        $query = array("date"=>$date, "evening"=>$evening);
        $cursor = $collection->find($query);
        $num = $cursor->count();
        if ($num==0){
            $insert = array("username"=> $username, "dish"=>$dish, "year"=>$year, "month"=>$month, "date"=>$date, "time"=>$time, "noon"=>$noon, "evening" =>$evening);
    $collection->insert($insert);
    echo json_encode(array(
		"success" => true
	    ));
        }
        else {
            echo json_encode(array(
		"success" => false,
                "message" => "Please do not try to reserve on a booked slot"
	    ));
        }
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
}
?>