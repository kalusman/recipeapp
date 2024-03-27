<?php
// Start session
session_start();

// Include database connection file
include_once "../connection.php";

// Check if user is logged in as admin
if (isset($_SESSION['loggedin']) && $_SESSION['role'] === 'admin') {
    // Check if 'delete' button is clicked and 'id' is set
    if (isset($_POST['delete']) && isset($_POST['id'])) {
        $id = $_POST['id'];

        // Delete the user from the database
        $sql = "DELETE FROM categories WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            // Redirect back to the account page after successful deletion
            header("Location: admin-menu.php?show=category");
            exit();
        } else {
            // Display error message if deletion fails
            echo "Error deleting record: " . mysqli_error($conn);
        }
    }
}

// Close connection
mysqli_close($conn);
?>
