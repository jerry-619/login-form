<?php
session_start();
include("conn.php");

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($db, trim($_POST['username']));
    $email = mysqli_real_escape_string($db, trim($_POST['email']));
    $pass = mysqli_real_escape_string($db, trim($_POST['password']));
    $cpass = mysqli_real_escape_string($db, trim($_POST['cpassword']));
    $chkmail = "SELECT * FROM users where email = '$email'";
    $result = mysqli_query($db, $chkmail);
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        echo "<script>
                     alert('Email Already Exists');
                     </script>";
    } else {
        $hashed = md5($pass);
        $qurey = "INSERT INTO users (name, email, password) values ('$name', '$email', '$hashed')";
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
        <div class="box">
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
                            <input type="text" class="input-box" name="email" id="email" required>
                            <label for="email">Email address</label>
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
                        <div class="input-field">
                            <input type="submit" class="input-submit" id="register" name="register" value="Register">
                        </div>
                </form>
            </div>
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