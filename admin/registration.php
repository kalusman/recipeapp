
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

            } else {
                echo 'Error updating user';
            }
        } else {
            if(insertUser($conn, $uname, $upwd, $role)) {
                echo 'User inserted successfully';
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
   
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #F1A72B;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color:#F5B041;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><?php echo isset($user) ? 'Edit User' : 'Registration Form'; ?></h2>
        <form method="post">
            <?php if(isset($user)): ?>
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <?php endif; ?>
            <label for="uname">Username:</label>
            <input type="text" id="uname" name="uname" placeholder="Enter username" required value="<?php echo isset($user) ? $user['uname'] : ''; ?>">

            <label for="upwd">Password:</label>
            <input type="password" id="upwd" name="upwd" placeholder="Enter password" required value="<?php echo isset($user) ? $user['upwd'] : ''; ?>">

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="" disabled>Select Role</option>
                <option value="RecipeSeeker" <?php echo (isset($user) && $user['role'] == 'RecipeSeeker') ? 'selected' : ''; ?>>Recipe Seeker</option>
                <option value="Chef" <?php echo (isset($user) && $user['role'] == 'Chef') ? 'selected' : ''; ?>>Chef</option>
                <option value="Admin" <?php echo (isset($user) && $user['role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
            </select>

            <button type="submit" name="submit"><?php echo isset($user) ? 'Update' : 'Submit'; ?></button>
        </form>
    </div>
</body>
</html>
