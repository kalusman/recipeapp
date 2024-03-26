<?php
include '../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];

    $sql = "INSERT INTO categories (name) VALUES ('$name')";
    if (mysqli_query($conn, $sql)) {
        header("Location: admin-menu.php?show=category");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
