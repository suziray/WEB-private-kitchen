<?php
header("Content-Type: application/json");
try {
     //a new MongoDB connection
    $conn = new Mongo('localhost');

     //connect to test database
    $db = $conn->users;
    
    // a new products collection object
    $collection = $db->faq;
    $cursor = $collection->find();
    $num = $cursor->count();
    if ($num>0){
        $ans = array();
        foreach ($cursor as $obj){
            $qaa = array("question"=> $obj['question'],
                         "answer"=> $obj['answer']
                         );
            array_push($ans, $qaa);
        }
        echo json_encode($ans);
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