<?php
include("conn.php");
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
    <link rel="stylesheet" href="https://cdn.rawgit.com/Semantic-Org/Semantic-UI/next/dist/semantic.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>

<body>
    <div class="ui top fixed inverted borderless menu">
        <div class="ui head container">
            <div class="item">
            <a style="font-family:cursive; text-decoration:none;" class="navbar-brand" href="home.php">
      <img src="img/logo.png" alt="" width="38" height="28" class="d-inline-block align-text-top">
           My Admin Panel</a>
            </div>

            <p class="ui item right"><span class="greeting">Welcome, </span>
                <?php echo $_SESSION['username']; ?>
                <span class="logout">| <a style="text-decoration:none;" href="login.php" class="ui btn btn-dark ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right me-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z" />
                            <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                        </svg> Log out</a>
            </p>
        </div>
    </div>
    <div class="main container">
        <div class="ui grid">
            <div class="two column row">
                <div class="left floated column bottom aligned content">
                    <h1 class="ui header">Dashboard</h1>
                </div>
                <div class="right floated column right aligned">
                    <div class="middle aligned content">
                        <button type="button" class="ui labeled icon button primary button" data-bs-toggle="modal" data-bs-target="#adduser">
                            <i class="plus icon"></i>Add User</button>
                        <div class="modal fade" id="adduser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="crud.php" method="post">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Add User</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Username</span>
                                                <input type="text" class="form-control" placeholder="Enter Username" name="username" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Email Address</span>
                                                <input type="text" class="form-control" placeholder="Enter Email Address" name="email" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Password</span>
                                                <input type="password" class="form-control" placeholder="Enter password" name="password" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success" name="adduser">Add</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if (isset($_GET['alert'])) {
                if ($_GET['alert'] == 'something_went_wrong') {
                    echo <<< alert
                    <div class=" container alert alert-danger alert-dismissible text-center" role="alert">
                    <strong>User Can't Added</strong> Something Went Wrong
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    alert;
                }

                if ($_GET['alert'] == 'failed') {
                    echo <<< alert
                    <div class=" container alert alert-danger alert-dismissible text-center" role="alert">
                    <strong>User Can't Deleted</strong> Something Went Wrong
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    alert;
                }
                if ($_GET['alert'] == 'userfailed') {
                    echo <<< alert
                    <div class=" container alert alert-danger alert-dismissible text-center" role="alert">
                    <strong>User Can't Updated </strong> Something Went Wrong
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    alert;
                }
            } else if (isset($_GET['success'])) {
                if ($_GET['success'] == 'userAdded')
                    echo <<< alert
                    <div class=" container alert alert-success alert-dismissible text-center" role="alert">
                    <strong>User Added Successfully </strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    alert;
                if ($_GET['success'] == 'userRemoved')
                    echo <<< alert
                    <div class=" container alert alert-success alert-dismissible text-center" role="alert">
                    <strong>User Removed Successfully </strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    alert;
                if ($_GET['success'] == 'UserModified')
                    echo <<< alert
                    <div class=" container alert alert-success alert-dismissible text-center" role="alert">
                    <strong>User Updated Successfully </strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    alert;
            }
            ?>
            <div class="sixteen wide column ">
                <table class="ui celled table selectable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $qurey = "SELECT * FROM users";
                        $result = mysqli_query($db, $qurey);
                        $i = 1;
                        while ($row = mysqli_fetch_array($result)) {
                            echo <<< users
                           <tr class="align-middle">
                                <th scope="row">$i</th>
                                <td>$row[name]</td>
                                <td>$row[email]</td>
                                <td>$row[password]</td>
                                <td class="collapsing">
                                <a href="?edit=$row[id]" class="ui btn btn-warning me-2">
                                     <i class="pencil icon"></i></a>
                                     <button class="ui btn btn-danger" data-bs-toggle="modal" data-bs-target="#deluser{$row['id']}">
                                    <i class="trash icon"></i>
                                    </button>
                                </td>
                            </tr>
                        
                               <div class="modal fade" id="deluser{$row['id']}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                   <div class="modal-content">
                                      <div class="modal-header">
                                       <h5 class="modal-title" id="staticBackdropLabel">Delete User</h5>
                                      </div>
                                     <div class="modal-body">
                                      Are you sure you want to delete this User? 
                                     </div>
                                      <div class="modal-footer">
                                       <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" onclick="confirm_del({$row['id']})" class="btn btn-danger">Confirm</button>
                                     </div>
                                   </div>
                                 </div>
                               </div>
                           users;
                            $i++;
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="7">
                                <div class="ui right floated pagination menu tiny">
                                    <a class="item">1</a>
                                    <a class="item">2</a>
                                    <a class="icon item">
                                        <i class="right chevron icon"></i>
                                    </a>
                                </div>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edituser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="crud.php" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Username</span>
                            <input type="text" class="form-control" placeholder="Enter Username" id="editusername" name="editusername" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Email Address</span>
                            <input type="text" class="form-control" placeholder="Enter Email Address" id="editemail" name="editemail" required>
                        </div>
                        <input type='hidden' name=editid id='editid'>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" name="edituser">Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
<?php
if (isset($_GET['edit']) && $_GET['edit'] > 0) {
    $qurey = "SELECT * FROM users WHERE id = '$_GET[edit]'";
    $result = mysqli_query($db, $qurey);
    $row = mysqli_fetch_assoc($result);
    echo "
    <script>
        var myModal = new bootstrap.Modal(document.getElementById('edituser'), {
        keyboard: false
      });
        document.querySelector('#editusername').value=`$row[name]`;
        document.querySelector('#editemail').value=`$row[email]`;
        document.querySelector('#editid').value=`$row[id]`;
        myModal.show();  
    </script>
    ";
}
?>
<style>
    @import url(https://fonts.googleapis.com/css?family=Lato:300);

    body {
        background-color: #eaf0f2;
        padding-top: 40px;
    }


    .ui.segment {
        padding: 2rem;
    }

    .ui.head {
        height: 46px;
    }


    .greeting {
        color: rgba(255, 255, 255, 0.5) !important;
    }

    .greeting::after,
    .logout::before {
        content: "\00a0";
    }

    .logout,
    .logout a,
    .logout a:visited {
        color: rgb(255 255 255) !important;
        font-weight: 700;
        margin-left: 10px;
    }

    .logout a:hover {
        color: rgba(255, 255, 255, 0.8) !important;
    }

    .main.container {
        position: relative;
        max-width: 940px !important;
        left: 0px;
        margin-left: auto !important;
        margin-right: auto !important;
        padding: 2em 0em 7em;
    }

    .inverted {
        background-color: #28556f !important;
    }



    @media only screen and (max-width: 767px) {

        .ui.table[class*="center aligned"],
        .ui.table [class*="center aligned"] {
            text-align: left;
        }
    }
</style>

<script>
    function confirm_del(id) {
        window.location.href = "crud.php?id="+id;
    }
</script>

</html>