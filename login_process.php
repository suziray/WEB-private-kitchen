<?php
header("Content-Type: application/json");
$username = $_POST['username'];
$password = $_POST['password'];
try {
     //a new MongoDB connection
    $conn = new Mongo('localhost');

     //connect to test database
    $db = $conn->users;
    
    // a new products collection object
    $collection = $db->userinfo;
    
    $query = array("username" => $username);
    //// fetch all product documents
    $cursor = $collection->find($query);
    //
    ////// How many results found
    $num_docs = $cursor->count();
    if ($num_docs != 1){
	echo json_encode(array(
		"success" => false,
		"message" => "No such username!"
	    ));
	$conn->close();
	exit;
    }
    else{
        $entry = $collection->findOne($query);
        $correct_pwd = $entry['password'];
        if (crypt($password, $correct_pwd)==$correct_pwd){
            session_start();
            $_SESSION['username'] = $username;
	    $_SESSION['token'] = substr(md5(rand()), 0, 10);
 
	echo json_encode(array(
		"success" => true,
                "token" => $_SESSION['token'],
                "user" => $username
	));
	exit;
        }
        else {
            echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
	));
	exit;
        }
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