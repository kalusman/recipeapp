<?php
include '../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];

    $sql = "UPDATE categories SET name='$name' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        header("Location: admin-menu.php?show=category");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
