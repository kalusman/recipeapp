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
    <title>Add Recipe</title>
    <link rel="stylesheet" type="text/css" href="../css/addrecipe.css">

</head>
<body>


    <div class="container">
        <h1>Add Recipe</h1>
        <form id="recipeForm" method="post" action="../addRecipes.php" enctype="multipart/form-data">
        <div class="step" id="step1" <?php if ($step != 1) echo 'style="display: none;"'; ?>>

            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label for="instructions">Instructions:</label>
                <textarea id="instructions" name="instructions" class="form-control" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label for="prep_time">Prep Time (minutes):</label>
                <input type="number" id="prep_time" name="prep_time" class="form-control" min="0" required>
            </div>

            <div class="form-group">
                <label for="cook_time">Cook Time (minutes):</label>
                <input type="number" id="cook_time" name="cook_time" class="form-control" min="0" required>
            </div>

            <div class="form-group">
                <label for="total_time">Total Time (minutes):</label>
                <input type="number" id="total_time" name="total_time" class="form-control" min="0" required>
            </div>

            <button type="button" class="btn btn-primary" onclick="nextStep(1)">Next</button>
            </div>
            <div class="step" id="step2" <?php if ($step != 2) echo 'style="display: none;"'; ?>>

            <div class="form-group">
                <label for="serving_size">Serving Size:</label>
                <input type="number" id="serving_size" name="serving_size" class="form-control" min="1" required>
            </div>

            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="category" class="form-control">
                    <?php
                    // Include database connection file
                    include_once "connection.php";

                    // Fetch categories from database
                    $result = mysqli_query($conn, "SELECT * FROM Categories");
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
           


            <div class="form-group" id="ingredientContainer">
                <label for="ingredient_list">Ingredients:</label>
                <div class="ingredientEntry">
                    <input type="text" name="ingredient_name[]" class="form-control" placeholder="Ingredient Name" required>
                    <input type="text" name="ingredient_quantity[]" class="form-control" placeholder="Quantity">
                    <button type="button" class="btn btn-danger" onclick="removeIngredient(this)">Remove</button>
                </div>
            </div>
            <button type="button" class="btn btn-primary" onclick="addIngredient()">Add Ingredient</button>

            <div class="form-group" id="stepContainer">
                <label for="step_list">Preparation Steps:</label>
                <div class="stepEntry">
                    <input type="number" name="step_number[]" class="form-control" placeholder="Step Number" min="1" required>
                    <textarea name="step_description[]" class="form-control" placeholder="Step Description" rows="4"></textarea>
                    <button type="button" class="btn btn-danger" onclick="removeStep(this)">Remove</button>
                </div>
            </div>
            <button type="button" class="btn btn-primary" onclick="addStep()">Add Step</button>

            <div class="form-group">
                <label for="file">Upload File:</label>
                <input type="file" id="file" name="file" class="form-control-file">
            </div>

                <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                <button type="submit" class="btn btn-success">Submit Recipe</button>
            </div>
        </form>
    </div>

    <script>

        function nextStep(currentStep) {
            document.getElementById('step' + currentStep).style.display = 'none';
            document.getElementById('step' + (currentStep + 1)).style.display = 'block';
            console.log(currentStep);
        }


        function prevStep() {
    var currentStep = <?php echo $step; ?>;
    var steps = document.getElementsByClassName('step');

    for (var i = 0; i < steps.length; i++) {
        if (steps[i].id === 'step' + currentStep) {
            steps[i].style.display = 'none';
        }
        if (steps[i].id === 'step' + (currentStep - 1)) {
            steps[i].style.display = 'block';
        }
    }

    window.location.href = 'add-recipe-admin.php';
}



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