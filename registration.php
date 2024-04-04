<?php 
require_once "database.php";

$email = $_POST['email'];
$password = $_POST['password'];
$repeat_password = $_POST['repeat_password'];
$user_name = $_POST['user_name'];
 
$sql = "INSERT INTO users (UserName, Email, Password) VALUES ( ?, ?, ? )";
$stmt = mysqli_stmt_init($connection);
$prepareStmt = mysqli_stmt_prepare($stmt,$sql);
if ($prepareStmt) {
    mysqli_stmt_bind_param($stmt,"sss",$user_name, $email, $password);
    mysqli_stmt_execute($stmt);
    exit;
}

http_response_code(400);
?>