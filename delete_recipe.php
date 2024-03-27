<!DOCTYPE html>
<html>
<head>
    <title>Add Recipe</title>
    <link rel="stylesheet" type="text/css" href="./css/message.css">

</head>
<body>
<?php
include_once "connection.php";

if (isset($_GET['id'])) {
    $recipe_id = $_GET['id'];
    $query = "DELETE FROM Recipes WHERE recipe_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $recipe_id);
    $result = $stmt->execute();

    if ($result) {
        // Insertion successful, show success toast
        echo '<section class="c-container"><div class="o-circle c-container__circle o-circle__sign--success"><div class="o-circle__sign"></div></div></section>';
    } else {
        // Insertion failed, show failure toast
        echo '<section class="c-container"><div class="o-circle c-container__circle o-circle__sign--failure"><div class="o-circle__sign"></div></div></section>';
    }
    // Redirect to success page

    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        echo '<script>setTimeout(function() { window.location.href = "./admin/admin-menu.php?show=recipes"; }, 2000);</script>';
    } else {
        echo '<script>setTimeout(function() { window.location.href = "index.php"; }, 2000);</script>';
    }
    // header("Location: index.php"); // Redirect to the recipe list page
    // exit();
}
?>
</body>
    </html>