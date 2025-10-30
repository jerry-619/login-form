<?php
include('conn.php');

if (isset($_POST['adduser'])) 
{
    foreach ($_POST as $key => $value) {
        if (!is_array($value)) {
            $_POST[$key] = mysqli_real_escape_string($db, $value);
        }
    }
    
    $hobbies = '';
    if (isset($_POST['hobbies']) && is_array($_POST['hobbies'])) {
        $hobbies = implode(', ', $_POST['hobbies']);
        $hobbies = mysqli_real_escape_string($db, $hobbies);
    }
    
    $hash = md5($_POST['password']);
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
    
    $qurey = "INSERT INTO users (name, email, password, gender, dob, hobbies) values ('$_POST[username]', '$_POST[email]', '$hash', '$gender', '$dob', '$hobbies')";
    if (mysqli_query($db, $qurey)) {
        header("location: home.php?success=userAdded");
        
    } else {
        header("location: home.php?alert=something_went_wrong");
    }
}

if(isset($_GET['id']) && $_GET['id']> 0) 
{

      $qurey= "DELETE FROM users WHERE id='$_GET[id]'";
      if (mysqli_query($db, $qurey)) {
        header("location: home.php?success=userRemoved");
    } else {
        header("location: home.php?alert=failed");
    }

}

if (isset($_POST['edituser'])) 
{
    foreach ($_POST as $key => $value) {
        if (!is_array($value)) {
            $_POST[$key] = mysqli_real_escape_string($db, $value);
        }
    }
    
    $hobbies = '';
    if (isset($_POST['edithobbies']) && is_array($_POST['edithobbies'])) {
        $hobbies = implode(', ', $_POST['edithobbies']);
        $hobbies = mysqli_real_escape_string($db, $hobbies);
    }
    
    $gender = isset($_POST['editgender']) ? $_POST['editgender'] : '';
    $dob = isset($_POST['editdob']) ? $_POST['editdob'] : '';

    $update = "UPDATE `users` SET `name`='$_POST[editusername]', `email`='$_POST[editemail]', `gender`='$gender', `dob`='$dob', `hobbies`='$hobbies' WHERE `id`='$_POST[editid]' ";
    if (mysqli_query($db, $update)) {
        header("location: home.php?success=UserModified");
    } else {
        header("location: home.php?alert=userfailed");
    }
}