
<?php
include('../connection.php');

$errors = [];

function getUserById($conn, $id) {
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function updateUser($conn, $id, $uname, $upwd, $role) {
    $sql = "UPDATE users SET uname='$uname', upwd='$upwd', role='$role' WHERE id=$id";
    return mysqli_query($conn, $sql);
}

function insertUser($conn, $uname, $upwd, $role) {
    $sql = "INSERT INTO users (uname, upwd, role, added_date) VALUES ('$uname', '$upwd', '$role', NOW())";
    return mysqli_query($conn, $sql);
}

if(isset($_POST['submit'])) {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $uname = mysqli_real_escape_string($conn, $_POST['uname']);
    $upwd = mysqli_real_escape_string($conn, $_POST['upwd']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    if(empty($uname)) {
        $errors[] = 'Username is required';
    }

    if(empty($upwd)) {
        $errors[] = 'Password is required';
    }

    if(empty($role)) {
        $errors[] = 'Role is required';
    }

    if(empty($errors)) {
        if($id) {
            if(updateUser($conn, $id, $uname, $upwd, $role)) {
                echo 'User updated successfully';
                header("Location: admin-menu.php?show=account");

            } else {
                echo 'Error updating user';
            }
        } else {
            if(insertUser($conn, $uname, $upwd, $role)) {
                echo 'User inserted successfully';
                header("Location: admin-menu.php?show=account");
            } else {
                echo 'Error inserting user';
            }
        }
    } else {
        foreach($errors as $error) {
            echo $error . '<br>';
        }
    }
}

$user = null;
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = getUserById($conn, $id);
}
?>