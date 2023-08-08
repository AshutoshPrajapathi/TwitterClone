<?php
include("functions.php");
if($_GET['action']=="loginSignup"){
    $error ="";
    if(!$_POST['email']){
        $error="Email  is required";
    }elseif(!$_POST['password']){
        $error="Password is required";

    }elseif (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)===false) {
        $error = "Please enter a valid email address.";
    }

   if($error !=""){
        echo $error;
        exit();
    }


    
    if($_POST['loginActive']=='0'){
        
        $query = "SELECT *FROM `users` WHERE email='".mysqli_real_escape_string($link,$_POST['email'])."'LIMIT 1";
        $result = mysqli_query($link,$query);
        if(mysqli_num_rows($result)>0){
            $error = "email already exist";
        }else{
            $query = "INSERT INTO users(`email`,`password`) VALUES('".mysqli_real_escape_string($link,$_POST['email'])."','".mysqli_real_escape_string($link,$_POST['password'])."') LIMIT 1";
            if(mysqli_query($link,$query)){
                $_SESSION['id']=mysqli_insert_id($link);
                $query = "UPDATE `users` SET `password`='".md5(md5($_SESSION['id']).$_POST['password'])."'WHERE id='".$_SESSION['id']."'LIMIT 1";
                mysqli_query($link,$query);
                echo 1;
            }else{
                $error = "Coudn't signed in";
            }

        }
    }else{
        $query = "SELECT *FROM `users` WHERE email='".mysqli_real_escape_string($link,$_POST['email'])."'LIMIT 1";
        $result = mysqli_query($link,$query);
        
        if($row = mysqli_fetch_assoc($result)){
        if($row['password'] == md5(md5($row['id']).$_POST['password'])){
            $_SESSION['id']=$row['id'];
            echo 1;

        }
    }
     else{
            $error = "Couldn't find account please check email/password";
        }


    }
    
    if($error !=""){
        echo $error;
        exit();
    }
}

if($_GET['action']== 'toggleFollow'){
   $query = "SELECT *FROM isfollowing WHERE follower=".mysqli_real_escape_string($link,$_SESSION['id'])." AND isFollowing=".mysqli_real_escape_string($link,$_POST['userId'])." LIMIT 1";
   $result = mysqli_query($link,$query);
   if(mysqli_num_rows($result)>0){
    $row = mysqli_fetch_assoc($result);
    mysqli_query($link,"DELETE FROM isfollowing WHERE id=".mysqli_real_escape_string($link,$row['id'])." limit 1 ");
    echo "1";
   }else{
    mysqli_query($link,"INSERT INTO isfollowing (follower,isFollowing) VALUES(".mysqli_real_escape_string($link,$_SESSION['id']).",".mysqli_real_escape_string($link,$_POST['userId']).")");
    echo "2";
   }
}

if($_GET['action'] == 'postTweet'){
    if(!$_POST['tweetContent']){
        echo "Your tweet is empty.";
    }else if(strlen($_POST['tweetContent']) > 140){
        echo "Your tweet is too long!";
    }else{
        mysqli_query($link,"INSERT INTO tweets(`tweets`,`userid`,`datetime`)VALUES('".mysqli_real_escape_string($link,$_POST['tweetContent'])."',".mysqli_real_escape_string($link,$_SESSION['id']).",NOW() )");
        echo "1";

    }
}
?>