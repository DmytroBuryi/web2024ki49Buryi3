<?php 
session_start();
require_once "database.php";

$email = $_POST['email'];
$type = $_POST['type'];

$sql = "SELECT * FROM users WHERE Email = '$email'";
$result = mysqli_query($connection, $sql);
$response = mysqli_fetch_assoc($result);

if(empty($response))
{
    http_response_code(404);
    echo "Invalid login";
    exit;
}

if($type == "common"){
    
    $password = $_POST['password'];

    if($response["Password"] != $password)
    {
        http_response_code(400);
        echo "Invalid Password";
        exit;
    }
}

 $_SESSION['ID'] = $response['Id'];
?>