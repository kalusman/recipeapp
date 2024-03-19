<?php
if (isset($_SESSION['loggedin']) && $_SESSION['role'] === 'admin') {
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
<div class="container">
    <h1>Dashboard</h1>
    <div class="stats-container">
        <div class="stat-box">
            <div class="stat-label">Total Users</div>
            <div class="stat-value">
                <?php
                include_once "../connection.php";
                $sql = "SELECT COUNT(*) as total_users FROM users";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                echo $row['total_users'];
                ?>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Total Chefs</div>
            <div class="stat-value">
                <?php
                $sql = "SELECT COUNT(*) as total_chefs FROM users WHERE role = 'chef'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                echo $row['total_chefs'];
                ?>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Total Recipe Seekers</div>
            <div class="stat-value">
                <?php
                $sql = "SELECT COUNT(*) as total_seekers FROM users WHERE role = 'RecipeSeeker'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                echo $row['total_seekers'];
                ?>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Total Recipes</div>
            <div class="stat-value">
                <?php
                $sql = "SELECT COUNT(*) as total_recipes FROM recipes";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                echo $row['total_recipes'];
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php
}?>