<?php
include('conn.php');
session_start();
if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string($db, trim($_POST['username']));
    $password = mysqli_real_escape_string($db, trim($_POST['password']));
    $pass = md5($password);
    $sql = "SELECT * FROM users WHERE name  = '$username' AND password = '$pass'";
    $result = mysqli_query($db, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row) {

            $_SESSION['username'] = $username;
            $_SESSION['start_time'] = time();

            if (isset($_POST['chk'])) {

                $cookie_username = $username;
                $cookie_password = $password;
                $cookie_duration = 60;

                // Set cookies with username and password
                setcookie('remember_username', $cookie_username, time() + $cookie_duration, '/');
                setcookie('remember_password', $cookie_password, time() + $cookie_duration, '/');
            }
            header('Location: home.php');
        } else {
            echo "<script>
               alert('Invalid username or password OR \\nYou don\'t have an account. Please Register now.');
            </script>";
        }
    }
    mysqli_close($db);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style/styles.css">
    <title>Login Page</title>
</head>

<body>

    <div class="container">
        <div class="box">
            <div class="socialicons">
                <a href="https://google.com" target="_blank">
                    <i class="fa-brands fa-google-plus"></i></a>
                <a href="https://facebook.com" target="_blank">
                    <i class="fa-brands fa-facebook"></i></a>
                <a href="https://x.com" target="_blank">
                    <i class="fa-brands fa-twitter"></i></a>
            </div>
            <!------------------ Login Box --------------------->
            <div class="box-login">

                <div class="top-header">
                    <h3>Login Now</h3>
                    <small>We are happy to have you back.</small>
                </div>
                <form action="login.php" method="post">
                    <div class="input-group">
                        <div class="input-field">
                            <input type="text" class="input-box" name="username" id="username" required>
                            <label for="username">Username</label>
                        </div>
                        <div class="input-field">
                            <input type="password" class="input-box" name="password" id="password" required>
                            <label for="password">Password</label>
                        </div>
                        <div class="remember">
                            <input type="checkbox" name="chk" id="chk" class="check">
                            <label for="rem"> Remember Me</label>
                        </div>
                        <div class="input-field">
                            <input type="submit" name="login" class="input-submit" id="login" value="Log in">
                        </div>
                        <div class="forgot">
                            <a href="#">Forgot password?</a>
                        </div>
                    </div>
                </form>

            </div>
            <span style="left: 36%;top: 79%;">New User?</span>
            <input type="button" class="register" onclick="window.location.href='reg.php'" value="Register">

        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
<?php
if (!empty($_COOKIE['remember_username']) && !empty($_COOKIE['remember_password'])) {
    $u = $_COOKIE['remember_username'];
    $p = $_COOKIE['remember_password'];
    echo "<script>
document.getElementById('username').value = '$u';
document.getElementById('password').value = '$p';
</script>";
}

?>