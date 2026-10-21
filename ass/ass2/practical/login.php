<?php

session_start();
require_once "dbcofig.in.php";

$erorr=" ";

if($_SERVER[REQUEST_METHOD=="POST"]){
    $email=$_post["email"];
    $password=$_post["password"];

    $sql="SELECT *from user WHERE email=:email";
    $stmt=$PDO ->Prepare($sql);
    $stmt ->excute([":email" =>$email])
    

    $user=$stmt->fetch(PDO::FATCH_ASSOS);
       if($user && password_verify($password,$user["passeord"])){ 
        $_SESSION["user_id"]=$user["user_id"];

        header("Location:");
        exit();
       }
    else{
    $erorr="invalid email or password";
}

}

?>