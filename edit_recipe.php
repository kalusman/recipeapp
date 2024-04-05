<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$step = isset($_GET['step']) ? $_GET['step'] : 1;

if (isset($_SESSION['loggedin']) && ($_SESSION['role'] === 'chef' || $_SESSION['role'] === 'admin')) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Recipe</title>
    <link rel="stylesheet" type="text/css" href="./css/addrecipe.css">
</head>
<body>
<?php include("./header/header.php"); ?>

    <div class="container">
        <h1>Edit Recipe</h1>
        <?php
        include_once "connection.php";

        if (isset($_GET['id'])) {
            $recipe_id = $_GET['id'];
            $query = "SELECT * FROM Recipes WHERE recipe_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $recipe_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $recipe = $result->fetch_assoc();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $instructions = $_POST['instructions'];
            $prep_time = $_POST['prep_time'];
            $cook_time = $_POST['cook_time'];
            $total_time = $_POST['total_time'];
            $serving_size = $_POST['serving_size'];
            $category_id = $_POST['category_id'];
            // Validate category_id
          
            // Add validation and sanitization as needed
           // Update the recipe details
    $query = "UPDATE Recipes SET title=?, description=?, instructions=?, prep_time=?, cook_time=?, total_time=?, serving_size=?, category_id=? WHERE recipe_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssiiiiii", $title, $description, $instructions, $prep_time, $cook_time, $total_time, $serving_size, $category_id, $recipe_id);
    if (!$stmt->execute()) {
        echo "Error updating recipe details: " . $conn->error;
        exit();
    }

    // Update ingredients
    $ingredient_names = $_POST['ingredient_name'];
    $ingredient_quantities = $_POST['ingredient_quantity'];
    $delete_ingredients_query = "DELETE FROM Ingredients WHERE recipe_id=?";
    $stmt = $conn->prepare($delete_ingredients_query);
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $insert_ingredient_query = "INSERT INTO Ingredients (recipe_id, name, quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_ingredient_query);
    $stmt->bind_param("iss", $recipe_id, $ingredient_name, $ingredient_quantity);
    foreach ($ingredient_names as $key => $ingredient_name) {
        $ingredient_quantity = $ingredient_quantities[$key];
        $stmt->execute();
    }

    // Update preparation steps
    $step_numbers = $_POST['step_number'];
    $step_descriptions = $_POST['step_description'];
    $delete_steps_query = "DELETE FROM preparationsteps WHERE recipe_id=?";
    $stmt = $conn->prepare($delete_steps_query);
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $insert_step_query = "INSERT INTO preparationsteps (recipe_id, step_number, description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_step_query);
    $stmt->bind_param("iis", $recipe_id, $step_number, $step_description);
    foreach ($step_numbers as $key => $step_number) {
        $step_description = $step_descriptions[$key];
        $stmt->execute();
    }
   // Handle file upload if a file was selected
if (isset($_FILES['file']) && $_FILES['file']['name'] != '') {
    $file = $_FILES['file']['tmp_name'];
    $file_content = file_get_contents($file);
    $file_content = mysqli_real_escape_string($conn, $file_content);
    $query = "UPDATE Recipes SET files = '$file_content' WHERE recipe_id = $recipe_id";
    mysqli_query($conn, $query);
}

  
    header("Location: recipeDetails.php?id=$recipe_id");
    exit();
        }
        ?>
        <form id="recipeForm" method="post" action="">
            <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" class="form-control" value="<?php echo $recipe['title']; ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control" rows="4"><?php echo $recipe['description']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="instructions">Instructions:</label>
                <textarea id="instructions" name="instructions" class="form-control" rows="4"><?php echo $recipe['instructions']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="prep_time">Prep Time (minutes):</label>
                <input type="number" id="prep_time" name="prep_time" class="form-control" value="<?php echo $recipe['prep_time']; ?>" min="0" required>
            </div>

            <div class="form-group">
                <label for="cook_time">Cook Time (minutes):</label>
                <input type="number" id="cook_time" name="cook_time" class="form-control" value="<?php echo $recipe['cook_time']; ?>" min="0" required>
            </div>

            <div class="form-group">
                <label for="total_time">Total Time (minutes):</label>
                <input type="number" id="total_time" name="total_time" class="form-control" value="<?php echo $recipe['total_time']; ?>" min="0" required>
            </div>

            <div class="form-group">
                <label for="serving_size">Serving Size:</label>
                <input type="number" id="serving_size" name="serving_size" class="form-control" value="<?php echo $recipe['serving_size']; ?>" min="1" required>
            </div>

            <div class="form-group">
                <label for="category_id">Category:</label>
                <select id="category_id" name="category_id" class="form-control">
                    <?php
                    $query = "SELECT * FROM Categories";
                    $result = $conn->query($query);
                    while ($row = $result->fetch_assoc()) {
                        $selected = ($row['id'] == $recipe['id']) ? 'selected' : '';
                        echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group" id="ingredientContainer">
                <label for="ingredient_list">Ingredients:</label>
                <?php
                $ingredients_query = "SELECT * FROM Ingredients WHERE recipe_id = ?";
                $stmt = $conn->prepare($ingredients_query);
                $stmt->bind_param("i", $recipe_id);
                $stmt->execute();
                $ingredients_result = $stmt->get_result();
                while ($ingredient = $ingredients_result->fetch_assoc()) {
                    echo "<div class='ingredientEntry'>";
                    echo "<input type='text' name='ingredient_name[]' class='form-control' value='{$ingredient['name']}' placeholder='Ingredient Name' required>";
                    echo "<input type='text' name='ingredient_quantity[]' class='form-control' value='{$ingredient['quantity']}' placeholder='Quantity'>";
                    echo "<button type='button' class='btn btn-danger' onclick='removeIngredient(this)'>Remove</button>";
                    echo "</div>";
                }
                ?>
            </div>
            <button type="button" class="btn btn-primary" onclick="addIngredient()">Add Ingredient</button>

            <div class="form-group" id="stepContainer">
                <label for="step_list">Preparation Steps:</label>
                <?php
                $steps_query = "SELECT * FROM preparationsteps WHERE recipe_id = ?";
                $stmt = $conn->prepare($steps_query);
                $stmt->bind_param("i", $recipe_id);
                $stmt->execute();
                $steps_result = $stmt->get_result();
                while ($step = $steps_result->fetch_assoc()) {
                    echo "<div class='stepEntry'>";
                    echo "<input type='number' name='step_number[]' class='form-control' value='{$step['step_number']}' placeholder='Step Number' min='1' required>";
                    echo "<textarea name='step_description[]' class='form-control' placeholder='Step Description' rows='4'>{$step['description']}</textarea>";
                    echo "<button type='button' class='btn btn-danger' onclick='removeStep(this)'>Remove</button>";
                    echo "</div>";
                }
                ?>
            </div>
            <button type="button" class="btn btn-primary" onclick="addStep()">Add Step</button>

            <div class="form-group">
                <label for="file">Upload File:</label>
                <input type="file" id="file" name="file" class="form-control-file">
            </div>

            <button type="submit" class="btn btn-success">Update Recipe</button>
        </form>
    </div>
    <?php include("./header/footer.php"); ?>

    <script>
       function addIngredient() {
    var container = document.getElementById("ingredientContainer");
    var entry = document.createElement("div");
    entry.classList.add("ingredientEntry", "form-row");
    entry.innerHTML = `
        <div class="col">
            <input type="text" name="ingredient_name[]" class="form-control" placeholder="Ingredient Name" required>
        </div>
        <div class="col">
            <input type="text" name="ingredient_quantity[]" class="form-control" placeholder="Quantity">
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-danger" onclick="removeIngredient(this)">Remove</button>
        </div>`;
    container.appendChild(entry);
    updateRemoveButtons();
}

function removeIngredient(button) {
    var div = button.parentElement.parentElement;
    div.parentElement.removeChild(div);
    updateRemoveButtons();
}

function addStep() {
    var container = document.getElementById("stepContainer");
    var entry = document.createElement("div");
    entry.classList.add("stepEntry", "form-row");
    entry.innerHTML = `
        <div class="col">
            <input type="number" name="step_number[]" class="form-control" placeholder="Step Number" min="1" required>
        </div>
        <div class="col">
            <textarea name="step_description[]" class="form-control" placeholder="Step Description" rows="4"></textarea>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-danger" onclick="removeStep(this)">Remove</button>
        </div>`;
    container.appendChild(entry);
    updateRemoveButtons();
}

function removeStep(button) {
    var div = button.parentElement.parentElement;
    div.parentElement.removeChild(div);
    updateRemoveButtons();
}

function updateRemoveButtons() {
    var ingredientEntries = document.querySelectorAll("#ingredientContainer .ingredientEntry");
    var stepEntries = document.querySelectorAll("#stepContainer .stepEntry");

    // Hide remove button for first entry
    if (ingredientEntries.length > 0) {
        ingredientEntries[0].querySelector(".btn-danger").style.display = "none";
    }
    if (stepEntries.length > 0) {
        stepEntries[0].querySelector(".btn-danger").style.display = "none";
    }

    // Show remove button for other entries
    for (var i = 1; i < ingredientEntries.length; i++) {
        ingredientEntries[i].querySelector(".btn-danger").style.display = "block";
    }
    for (var i = 1; i < stepEntries.length; i++) {
        stepEntries[i].querySelector(".btn-danger").style.display = "block";
    }
}

// Initial call to hide remove buttons
updateRemoveButtons();

    </script>

</body>
</html>
<?php
}
?>