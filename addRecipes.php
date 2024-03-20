<!DOCTYPE html>
<html>
<head>
    <title>Add Recipe</title>
    <link rel="stylesheet" type="text/css" href="./css/message.css">

</head>
<body>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection file
include_once "connection.php";
if (isset($_SESSION['loggedin']) && ($_SESSION['role'] === 'chef' || $_SESSION['role'] === 'admin')) {

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $instructions = mysqli_real_escape_string($conn, $_POST['instructions']);
    $prep_time = intval($_POST['prep_time']);
    $cook_time = intval($_POST['cook_time']);
    $total_time = intval($_POST['total_time']);
    $serving_size = intval($_POST['serving_size']);
    $category_id = isset($_POST['category']) ? intval($_POST['category']) : 1;

// Validate category_id
if (!isset($category_id) || empty($category_id) || $category_id == 0) {
    echo "Category is required.";
    exit();
}
    // Insert recipe into database
    $query = "INSERT INTO Recipes (title, description, instructions, prep_time, cook_time, total_time, serving_size, user_id,category_id ) 
              VALUES ('$title', '$description', '$instructions', $prep_time, $cook_time, $total_time, $serving_size, {$_SESSION['user_id']}, $category_id)";
    mysqli_query($conn, $query);
    $recipe_id = mysqli_insert_id($conn);

    // Insert ingredients into database
    $ingredient_names = $_POST['ingredient_name'];
    $ingredient_quantities = $_POST['ingredient_quantity'];
    for ($i = 0; $i < count($ingredient_names); $i++) {
        $ingredient_name = mysqli_real_escape_string($conn, $ingredient_names[$i]);
        $ingredient_quantity = mysqli_real_escape_string($conn, $ingredient_quantities[$i]);
        $query = "INSERT INTO Ingredients (name, quantity, recipe_id) VALUES ('$ingredient_name', '$ingredient_quantity', $recipe_id)";
        mysqli_query($conn, $query);
    }

    // Insert preparation steps into database
    $step_numbers = $_POST['step_number'];
    $step_descriptions = $_POST['step_description'];
    for ($i = 0; $i < count($step_numbers); $i++) {
        $step_number = intval($step_numbers[$i]);
        $step_description = mysqli_real_escape_string($conn, $step_descriptions[$i]);
        $query = "INSERT INTO PreparationSteps (step_number, description, recipe_id) VALUES ($step_number, '$step_description', $recipe_id)";
        mysqli_query($conn, $query);
    }

    // Handle file upload if a file was selected
    if ($_FILES['file']['name'] != '') {
        $file = $_FILES['file']['tmp_name'];
        $file_content = file_get_contents($file);
        $file_content = mysqli_real_escape_string($conn, $file_content);
        $query = "UPDATE Recipes SET files = '$file_content' WHERE recipe_id = $recipe_id";
        mysqli_query($conn, $query);
    }

    $result = mysqli_query($conn, $query);

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

}
}
// Close connection
mysqli_close($conn);
?>

</body>
</html>
