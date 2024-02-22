<?php
session_start();

include "db_conn.php";

if(isset($_POST['uname']) && isset($_POST['password'])){
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);
    if(empty($uname)){
        header("Location: loginform.php?error=User Name is required");
        exit();
    } elseif(empty($pass)){
        header("Location: loginform.php?error=Password is required");
        exit();
    }else{
        $sql = "SELECT * FROM user WHERE username='$uname'"; 
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) === 1) { 
            $row = mysqli_fetch_assoc($result); 
            if (password_verify($pass, $row['password'])) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['user_id'] = $row['user_id'];
                header("Location: home.php"); 
                exit;
            } else {
                header("Location: loginform.php?error=Incorrect User name or Password"); 
                exit;
            }
        } else {
            header("Location: loginform.php?error=Incorrect User name or Password");
            exit;
        }
    }
} else{
    header("Location: loginform.php");
    exit();
}