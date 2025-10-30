<?php
include("conn.php");
session_start();
if (!isset($_SESSION['username'])) {
    header('location: login.php');
    exit;
} else {

    $session_timeout = 1800;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>

<body>
    <nav class="admin-navbar">
        <div class="admin-container">
            <div class="navbar-brand">
                <span>My Admin Panel</span>
            </div>
            <div class="navbar-user">
                <span class="welcome-text">Welcome, <strong><?php echo $_SESSION['username']; ?></strong></span>
                <a href="login.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </nav>
    <div class="admin-main-container">
        <div class="admin-content">
            <div class="admin-header">
                <h1 class="admin-title">
                    <i class="fas fa-chart-line"></i> Dashboard
                </h1>
                <button type="button" class="add-user-btn" data-bs-toggle="modal" data-bs-target="#adduser">
                    <i class="fas fa-plus"></i> Add User
                </button>
            </div>
            <?php
            if (isset($_GET['alert'])) {
                if ($_GET['alert'] == 'something_went_wrong') {
                    echo <<< alert
                    <div class="  alert alert-danger alert-dismissible text-center" role="alert">
                    <strong>User Can't Added</strong> Something Went Wrong
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    alert;
                }

                if ($_GET['alert'] == 'failed') {
                    echo <<< alert
                    <div class="  alert alert-danger alert-dismissible text-center" role="alert">
                    <strong>User Can't Deleted</strong> Something Went Wrong
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    alert;
                }
                if ($_GET['alert'] == 'userfailed') {
                    echo <<< alert
                    <div class="  alert alert-danger alert-dismissible text-center" role="alert">
                    <strong>User Can't Updated </strong> Something Went Wrong
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    alert;
                }
            } else if (isset($_GET['success'])) {
                if ($_GET['success'] == 'userAdded')
                    echo <<< alert
                    <div class="  alert alert-success alert-dismissible text-center" role="alert">
                    <strong>User Added Successfully </strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    alert;
                if ($_GET['success'] == 'userRemoved')
                    echo <<< alert
                    <div class="  alert alert-success alert-dismissible text-center" role="alert">
                    <strong>User Removed Successfully </strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    alert;
                if ($_GET['success'] == 'UserModified')
                    echo <<< alert
                    <div class="  alert alert-success alert-dismissible text-center" role="alert">
                    <strong>User Updated Successfully </strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    alert;
            }
            ?>
            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>DOB</th>
                            <th>Hobbies</th>
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
                           <tr>
                                <td>$i</td>
                                <td>{$row['name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['gender']}</td>
                                <td>{$row['dob']}</td>
                                <td class="hobbies-cell">{$row['hobbies']}</td>
                                <td class="action-cell">
                                    <a href="?edit={$row['id']}" class="action-btn edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="action-btn delete-btn" data-bs-toggle="modal" data-bs-target="#deluser{$row['id']}" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                           users;
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php
    $qurey = "SELECT * FROM users";
    $result = mysqli_query($db, $qurey);
    while ($row = mysqli_fetch_array($result)) {
        echo <<< modal
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
        modal;
    }
    ?>

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
                            <input type="email" class="form-control" placeholder="Enter Email Address" name="email" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Password</span>
                            <input type="password" class="form-control" placeholder="Enter password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" value="Male" id="male" required>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" value="Female" id="female" required>
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" value="Other" id="other" required>
                                    <label class="form-check-label" for="other">Other</label>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Date of Birth</span>
                            <input type="date" class="form-control" name="dob" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hobbies</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hobbies[]" value="Reading" id="hobby1">
                                        <label class="form-check-label" for="hobby1">Reading</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hobbies[]" value="Gaming" id="hobby2">
                                        <label class="form-check-label" for="hobby2">Gaming</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hobbies[]" value="Sports" id="hobby3">
                                        <label class="form-check-label" for="hobby3">Sports</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hobbies[]" value="Music" id="hobby4">
                                        <label class="form-check-label" for="hobby4">Music</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hobbies[]" value="Traveling" id="hobby5">
                                        <label class="form-check-label" for="hobby5">Traveling</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hobbies[]" value="Cooking" id="hobby6">
                                        <label class="form-check-label" for="hobby6">Cooking</label>
                                    </div>
                                </div>
                            </div>
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
                            <input type="email" class="form-control" placeholder="Enter Email Address" id="editemail" name="editemail" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="editgender" value="Male" id="editMale" required>
                                    <label class="form-check-label" for="editMale">Male</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="editgender" value="Female" id="editFemale" required>
                                    <label class="form-check-label" for="editFemale">Female</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="editgender" value="Other" id="editOther" required>
                                    <label class="form-check-label" for="editOther">Other</label>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Date of Birth</span>
                            <input type="date" class="form-control" name="editdob" id="editdob" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hobbies</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="edithobbies[]" value="Reading" id="editHobby1">
                                        <label class="form-check-label" for="editHobby1">Reading</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="edithobbies[]" value="Gaming" id="editHobby2">
                                        <label class="form-check-label" for="editHobby2">Gaming</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="edithobbies[]" value="Sports" id="editHobby3">
                                        <label class="form-check-label" for="editHobby3">Sports</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="edithobbies[]" value="Music" id="editHobby4">
                                        <label class="form-check-label" for="editHobby4">Music</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="edithobbies[]" value="Traveling" id="editHobby5">
                                        <label class="form-check-label" for="editHobby5">Traveling</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="edithobbies[]" value="Cooking" id="editHobby6">
                                        <label class="form-check-label" for="editHobby6">Cooking</label>
                                    </div>
                                </div>
                            </div>
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
    
    $hobbiesArray = !empty($row['hobbies']) ? explode(', ', $row['hobbies']) : [];
    
    echo "
    <script>
        var myModal = new bootstrap.Modal(document.getElementById('edituser'), {
        keyboard: false
      });
        document.querySelector('#editusername').value=`{$row['name']}`;
        document.querySelector('#editemail').value=`{$row['email']}`;
        document.querySelector('#editdob').value=`{$row['dob']}`;
        document.querySelector('#editid').value=`{$row['id']}`;
        
        const genderValue = '{$row['gender']}';
        if (genderValue === 'Male') {
            document.getElementById('editMale').checked = true;
        } else if (genderValue === 'Female') {
            document.getElementById('editFemale').checked = true;
        } else if (genderValue === 'Other') {
            document.getElementById('editOther').checked = true;
        }
        
        const hobbies = " . json_encode($hobbiesArray) . ";
        hobbies.forEach(hobby => {
            const trimmedHobby = hobby.trim();
            if (trimmedHobby === 'Reading') document.getElementById('editHobby1').checked = true;
            if (trimmedHobby === 'Gaming') document.getElementById('editHobby2').checked = true;
            if (trimmedHobby === 'Sports') document.getElementById('editHobby3').checked = true;
            if (trimmedHobby === 'Music') document.getElementById('editHobby4').checked = true;
            if (trimmedHobby === 'Traveling') document.getElementById('editHobby5').checked = true;
            if (trimmedHobby === 'Cooking') document.getElementById('editHobby6').checked = true;
        });
        
        myModal.show();  
    </script>
    ";
}
?>

<script>
    function confirm_del(id) {
        window.location.href = "crud.php?id="+id;
    }
</script>

</html>