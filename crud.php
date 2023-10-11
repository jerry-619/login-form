<?php
include('conn.php');
//Add user

if (isset($_POST['adduser'])) 
{
    foreach ($_POST as $key => $value) {
        $_POST[$key] = mysqli_real_escape_string($db, $value);
    }
    $hash = md5($_POST['password']);
    $qurey = "INSERT INTO users (name, email, password) values ('$_POST[username]', '$_POST[email]', '$hash')";
    if (mysqli_query($db, $qurey)) {
        header("location: home.php?success=userAdded");
        
    } else {
        header("location: home.php?alert=something_went_wrong");
    }
}
//Delete user

if(isset($_GET['id']) && $_GET['id']> 0) 
{

      $qurey= "DELETE FROM users WHERE id='$_GET[id]'";
      if (mysqli_query($db, $qurey)) {
        header("location: home.php?success=userRemoved");
    } else {
        header("location: home.php?alert=failed");
    }


}
//Update user

if (isset($_POST['edituser'])) 
{
    foreach ($_POST as $key => $value) {
        $_POST[$key] = mysqli_real_escape_string($db, $value);
    }

    $update = "UPDATE `users` SET `name`='$_POST[editusername]', `email`='$_POST[editemail]' WHERE `id`='$_POST[editid]' ";
    if (mysqli_query($db, $update)) {
        header("location: home.php?success=UserModified");
    } else {
        header("location: home.php?alert=userfailed");
    }
}