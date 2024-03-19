<?php
session_start();
include('connection.php');



if(isset($_POST['submit'])) {
    $uname = mysqli_real_escape_string($conn, $_POST['uname']);
    $upwd = mysqli_real_escape_string($conn, $_POST['upwd']);
    $sql = "SELECT * FROM users WHERE uname='$uname' AND upwd='$upwd'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $_SESSION['role'] = $data['role'];
        $_SESSION['username'] = $data['uname'];
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $data['id'];

        if ($data['role'] == 'chef') {
            header('location:index.php');
            exit();
        } elseif ($data['role'] == 'admin') {
            header('location:admin/admin-menu.php?show=dashboard');
            exit();
        }
        else {
            header('location:index.php');
        }
    } else {
        $error = "Invalid username or password";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            /* background-color: #f9f9f9; */
            background-image: url('./images/logback.jpg');
  background-color: #cccccc;
  height: 500px;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
        }

        .container {
            max-width: 400px;
            margin: 10rem auto;
            padding: 20px;
            /* background-color: #fff; */
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 16px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
        }

        .btn:hover {
            filter: brightness(90%);
        }
        
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


    </style>
</head>

<body>

<div class="container">
        <h2>Login form</h2>
        <?php if(isset($error)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php } ?>
        <form method="post">
        <div class="mb-3 mt-3">
            <label for="email">Username:</label>
            <input type="text" class="form-control" id="email" placeholder="Enter username" name="uname">
        </div>
        <div class="mb-2">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="upwd">
        </div>
        <div class="mb-3 d-flex justify-content-between">
            <button type="submit" name="submit" class="btn btn-primary">Login</button>
            <a href="user-registration.php" class="btn btn-secondary ml-2">Sign Up</a>
        </div>
        <div>
            <div>
                <a href="index.php" class="btn btn-secondary">Go Back</a>
            </div>
  
</div>

</form>

    </div>

</body>

</html>
