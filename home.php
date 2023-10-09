<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: login.php');
    exit;
} else {

    $session_timeout = 60;
    if (isset($_SESSION['start_time']) && (time() - $_SESSION['start_time']) > $session_timeout) {
        session_unset();
        session_destroy();
        header('location: login.php');
        exit;
    }
    $_SESSION['start_time'] = time();
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
</head>

<body>
<nav>
<ul>
    <h3 style="color:whitesmoke"> Admin Panel</h3>
	<li>Add User</li>
	<li>Update User</li>
	<li>Delete User</li>
	<a style="text-decoration:none" href="login.php"><li>Logout</li></a>
</ul>

</nav>

 <br>
<style>
    * {
	margin: 0;
	padding: 0;
	list-style-type: none;
}
nav{
    background: #1E1F25;
}
ul{
	display: flex;
	width: 100%;
	margin: auto;
	justify-content: space-between;
	text-align: center;
}
ul h3{
    color: whitesmoke;
    position: relative;
    top: 15px;
    left: 20px;
    font-family: cursive;
}
li {
	padding: 1rem 2rem 1.15rem;
  /* text-transform: uppercase; */
  cursor: pointer;
  color: #ebebeb;
	min-width: 80px;
	margin: auto;
}

li:hover {
  background-image: url('https://scottyzen.sirv.com/Images/v/button.png');
  background-size: 100% 100%;
  color: #27262c;
  animation: spring 300ms ease-out;
  text-shadow: 0 -1px 0 #ef816c;
	font-weight: bold;
}
li:active {
  transform: translateY(4px);
}

@keyframes spring {
  15% {
    -webkit-transform-origin: center center;
    -webkit-transform: scale(1.2, 1.1);
  }
  40% {
    -webkit-transform-origin: center center;
    -webkit-transform: scale(0.95, 0.95);
  }
  75% {
    -webkit-transform-origin: center center;
    -webkit-transform: scale(1.05, 1);
  }
  100% {
    -webkit-transform-origin: center center;
    -webkit-transform: scale(1, 1);
  }
}

.shameless-plug{
  position: absolute;
  bottom: 10px;
  right: 0;
  padding: 8px 20px;
  color: #ccc;
  text-decoration: none;
}
</style>
</body>

</html>
<?php
if (isset($_COOKIE['remember_username']) and isset($_COOKIE['remember_password'])) {
    echo "cookie is set";
} else {
    echo "cookie is not set";
}
?>