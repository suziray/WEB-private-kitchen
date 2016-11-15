<?php
header("Content-Type: application/json");
try {
     //a new MongoDB connection
    $conn = new Mongo('localhost');

     //connect to test database
    $db = $conn->users;
    
    // a new products collection object
    $collection = $db->reserve;
    
    $cursor = $collection->find();
    //
    ////// How many results found
    $num_docs = $cursor->count();
    if ($num_docs>0){
        $reservations = array();
        foreach ($cursor as $obj){
            $order = array(
                "username" => $obj['username'],
                "dish" => $obj['dish'],
                "year" => $obj['year'],
                "month" => $obj['month'],
                "date" => $obj['date'],
                "time" => $obj['time'],
                "noon" => $obj['noon'],
                "evening" => $obj['evening']
            );
            array_push($reservations, $order);
        }
        echo json_encode($reservations);
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