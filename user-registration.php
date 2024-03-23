
<?php
include('connection.php');

$errors = [];


function insertUser($conn, $uname, $upwd ) {

    $sql_u = "SELECT * FROM users WHERE uname='$uname'";
    $res_u = mysqli_query($conn, $sql_u);

    if (mysqli_num_rows($res_u) > 0) {
        $name_error = "Sorry... username already taken";  
    }
    else {
        $sql = "INSERT INTO users (uname, upwd, role, added_date) VALUES ('$uname', '$upwd', 'RecipeSeeker', NOW())";
        return mysqli_query($conn, $sql);
    }

}

if(isset($_POST['submit'])) {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $uname = mysqli_real_escape_string($conn, $_POST['uname']);
    $upwd = mysqli_real_escape_string($conn, $_POST['upwd']);

    if(empty($uname)) {
        $errors[] = 'Username is required';
    }

    if(empty($upwd)) {
        $errors[] = 'Password is required';
    }

    if(empty($errors)) {

            if(insertUser($conn, $uname, $upwd)) {
                echo 'User inserted successfully';
                header("Location: login.php");
            } else {
                echo 'Error inserting user, UserName Already Exists';
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
         .alert {
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
        }

        .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
        }

        .alert-danger a {
        color: #721c24;
        text-decoration: underline;
        }
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
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <?php foreach ($errors as $error): ?>
                <?php echo $error . '<br>'; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form method="post">
        <?php if (isset($user)): ?>
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <?php endif; ?>
        <label for="uname">Username:</label>
        <input type="text" id="uname" name="uname" placeholder="Enter username" required value="<?php echo isset($user) ? $user['uname'] : ''; ?>">

        <label for="upwd">Password:</label>
        <input type="password" id="upwd" name="upwd" placeholder="Enter password" required value="<?php echo isset($user) ? $user['upwd'] : ''; ?>">

        <button type="submit" name="submit"><?php echo isset($user) ? 'Update' : 'Submit'; ?></button>
    </form>
</div>

</body>
</html>
