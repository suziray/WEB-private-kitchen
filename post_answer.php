<?php
header("Content-Type: application/json");
//session_start();
//if (!isset($_SESSION['username'])||$_POST['token']!==$_SESSION['token']){
//    echo json_encode(array(
//		"success" => false,
//                "message" => "You have not logged in"
//	));
//	exit;
//}
$question = $_POST['question'];
$answer = $_POST['answer'];
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
    if ($num!=1){
        echo json_encode(array(
		"success" => false,
                "message" => "System Error"
	));
    }
    else {
       $collection->update(array("question"=>$question), array('$set' => array("question"=>$question, "answer"=>$answer)));
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