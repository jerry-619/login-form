<?php
session_start();
include("conn.php");

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($db, trim($_POST['username']));
    $email = mysqli_real_escape_string($db, trim($_POST['email']));
    $pass = mysqli_real_escape_string($db, trim($_POST['password']));
    $cpass = mysqli_real_escape_string($db, trim($_POST['cpassword']));
    $gender = mysqli_real_escape_string($db, $_POST['gender']);
    $dob = mysqli_real_escape_string($db, $_POST['dob']);
    
    $hobbies = '';
    if (isset($_POST['hobbies']) && is_array($_POST['hobbies'])) {
        $hobbies = implode(', ', $_POST['hobbies']);
    }
    $hobbies = mysqli_real_escape_string($db, $hobbies);
    
    $chkmail = "SELECT * FROM users where email = '$email'";
    $result = mysqli_query($db, $chkmail);
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        header("location: reg.php?alert=email_exists");
    } else {
        $hashed = md5($pass);
        $qurey = "INSERT INTO users (name, email, password, gender, dob, hobbies) values ('$name', '$email', '$hashed', '$gender', '$dob', '$hobbies')";
        mysqli_query($db, $qurey);
        header("Location: login.php");
    }
    mysqli_close($db);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Register Page</title>
</head>

<body>
    <div class="container">
        <div class="box box-register-page">
            <div class="socialicons" style="top:20px">
                <a href="https://google.com" target="_blank">
                    <i class="fa-brands fa-google-plus"></i></a>
                <a href="https://facebook.com" target="_blank">
                    <i class="fa-brands fa-facebook"></i></a>
                <a href="https://x.com" target="_blank">
                    <i class="fa-brands fa-twitter"></i></a>
            </div>
            <div class="box-register">

                <div class="top-header">
                    <h3>Sign Up, Now</h3>
                    <small>We are happy to have you with us.</small>
                </div>
                <form action="reg.php" method="post">
                    <div class="input-group">
                        <div class="input-field">
                            <input type="text" class="input-box" name="username" id="username" required>
                            <label for="username">Username</label>
                        </div>
                        <div class="input-field">
                            <input type="email" class="input-box" name="email" id="email" required>
                            <label for="email">Email address</label>
                            <?php 
                            if (isset($_GET['alert'])) {
                             if ($_GET['alert'] == 'email_exists') {
                                 echo <<< alert
                                 <strong class="em-exist"> <img src="https://cdn.discordapp.com/emojis/708338924250202183.gif?quality=lossless">Email Already Exists</strong>
                                alert;
                             }
                         }
                         ?>
                        </div>
                        <div class="input-field">
                            <input type="password" class="input-box" name="password" id="password" oncontextmenu="return false;" required>
                            <label for="password">Password</label>
                        </div>
                        <div class="input-field">
                            <input type="password" class="input-box" name="cpassword" id="cpassword" required>
                            <label for="cpassword">Confirm Password</label>
                            <span id="mismatch"></span>
                        </div>
                        <div class="input-field-group">
                            <span class="field-label">Gender</span>
                            <div class="radio-group">
                                <label class="radio-label">
                                    <input type="radio" name="gender" value="Male" required>
                                    <span>Male</span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="gender" value="Female" required>
                                    <span>Female</span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="gender" value="Other" required>
                                    <span>Other</span>
                                </label>
                            </div>
                        </div>
                        <div class="input-field">
                            <input type="date" class="input-box" name="dob" id="dob" required>
                            <label for="dob">Date of Birth</label>
                        </div>
                        <div class="input-field-group">
                            <span class="field-label">Hobbies</span>
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="hobbies[]" value="Reading">
                                    <span>Reading</span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="hobbies[]" value="Gaming">
                                    <span>Gaming</span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="hobbies[]" value="Sports">
                                    <span>Sports</span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="hobbies[]" value="Music">
                                    <span>Music</span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="hobbies[]" value="Traveling">
                                    <span>Traveling</span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="hobbies[]" value="Cooking">
                                    <span>Cooking</span>
                                </label>
                            </div>
                        </div>
                        <div class="input-field">
                            <input type="submit" class="input-submit" id="register" name="register" value="Register">
                        </div>
                </form>
            </div>
            <div class="bottom-link-register">
                <span>Already a User?</span>
                <input type="button" class="login" onclick="window.location.href='login.php'" value="Login">
            </div>
        </div>
    </div>
    <div id="pswd-cri" class="hide">
                    <p class="title">
                        Password strength:
                        <span class="strength-text"></span>
                    </p>
                    <div class="strength-bar-wrapper">
                        <div id="strength-bar"></div>
                    </div>
                    <h6 class="txt-info">Password must contain:</h6>
                    <ul>
                        <li id="capital" class="invalid"> At Least <strong>one Uppercase letter</strong></li>
                        <li id="small" class="invalid"> At Least <strong>one lowercase letter</strong></li>
                        <li id="digit" class="invalid"> At Least <strong>one Digit</strong></li>
                        <li id="special" class="invalid"> At Least <strong>one Special-Character</strong></li>
                        <li id="length" class="invalid"> At Least <strong>8 characters</strong></li>
                    </ul>
                </div>
</body>
<script src="js/script.js"></script>

</html>