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
$question = $_POST['question'];
$answer = "Waiting for answer...";
try {
     //a new MongoDB connection
    $conn = new Mongo('localhost');

     //connect to test database
    $db = $conn->users;
    
    // a new products collection object
    $collection = $db->faq;
    $query = array("question"=>$question);
    $cursor = $collection->find($query);
    $num = $cursor->count();
    if ($num!=0){
        echo json_encode(array(
		"success" => false,
                "message" => "There is exactly the same question!"
	));
    }
    else {
        $insert = array(
        "question"=> $question,
        "answer" => $answer
    );
        $collection->insert($insert);
    echo json_encode(array(
		"success" => true
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