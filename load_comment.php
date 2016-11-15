<?php
header("Content-Type: application/json");
$dishname = $_POST['dishname'];
try {
     //a new MongoDB connection
    $conn = new Mongo('localhost');

     //connect to test database
    $db = $conn->users;
    
    // a new products collection object
    $collection = $db->comment;
    $query = array("dishname"=>$dishname);
    $cursor = $collection->find($query);
    $num = $cursor->count();
    if ($num>0){
        $ans = array();
        foreach ($cursor as $obj){
            $comment = array("comment"=> $obj['comment']);
            array_push($ans, $comment);
        }
        echo json_encode($ans);
    }
    else {
        echo "";
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