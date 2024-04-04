<?php 
session_start();

$action = $_REQUEST["action"];

switch ($action) {
  case "getUserByName":
    getUserByName();
    break;
  case "updateUserByName":
    updateUserByName();
    break;
  case "logout":
    logout();
    break;
}

function getUserByName(){
    require_once "database.php";
    $name = $_GET['name'] ?? $_SESSION["UserName"];

    $sql = "SELECT * FROM users WHERE UserName = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "s", $name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $response = mysqli_fetch_assoc($result);

    echo json_encode($response);
}

function updateUserByName(){
    require_once "database.php";
    $name = $_POST['name'] ?? $_SESSION["UserName"];
    $email = $_POST['email'];
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    
    $sql = "UPDATE users SET 
            Email = ?, 
            UserName = ?, 
            Password = ?
            WHERE UserName = ?";
    
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $email, $user_name, $password, $name);
    
    if(mysqli_stmt_execute($stmt)){
        echo "User data updated successfully";
    } else {
        http_response_code(400);
        echo "Failure updating user data: " . mysqli_error($connection);
    }
}


function logout(){
    session_start();
    session_destroy();
}
?>
