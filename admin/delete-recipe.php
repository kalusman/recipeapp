<?php

session_start();

include_once "../connection.php";

// Check if user is logged in as admin
if (isset($_SESSION['loggedin']) && $_SESSION['role'] === 'admin') {

    if (isset($_POST['delete']) && isset($_POST['id'])) {
        $id = $_POST['id'];

       
        $sql = "DELETE FROM recipes WHERE recipe_id=$id";
        if (mysqli_query($conn, $sql)) {
            
            header("Location: admin-menu.php?show=recipes");
            exit();
        } else {
            
            echo "Error deleting record: " . mysqli_error($conn);
        }
    }
}

// Close connection
mysqli_close($conn);
?>
