<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Category</title>
<link rel="stylesheet" href="../css/categories.css">
</head>
<body>
<div class="container">
    <h1>Edit Category</h1>
    <?php
    include '../connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $id = $_GET["id"];

        $sql = "SELECT * FROM categories WHERE id=$id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        ?>
        <form action="updateCategory.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="name">Category Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>
            <button type="submit">Update</button>
        </form>
        <?php
    }

    mysqli_close($conn);
    ?>
</div>
</body>
</html>
