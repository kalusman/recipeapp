<?php
include('connection.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
// Check if a recipe ID is provided in the URL
if (isset($_GET['id'])) {
    $recipe_id = mysqli_real_escape_string($conn, $_GET['id']); // Sanitize the input

    // Query to select recipe information based on the provided ID
    $sql = "SELECT * FROM Recipes WHERE recipe_id = $recipe_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $recipe = mysqli_fetch_assoc($result);
        // Fetch category, steps, ingredients, and user information based on the recipe ID
        $category_id = $recipe['category_id'];
        $user_id = $recipe['user_id'];

        $category_sql = "SELECT * FROM categories WHERE id = $category_id";
        $category_result = mysqli_query($conn, $category_sql);
        $category = mysqli_fetch_assoc($category_result);

        $user_sql = "SELECT * FROM users WHERE id = $user_id";
        $user_result = mysqli_query($conn, $user_sql);
        $user = mysqli_fetch_assoc($user_result);

        // Fetch steps for the recipe
        $steps_sql = "SELECT * FROM preparationsteps WHERE recipe_id = $recipe_id";
        $steps_result = mysqli_query($conn, $steps_sql);

        // Fetch ingredients for the recipe
        $ingredients_sql = "SELECT * FROM Ingredients WHERE recipe_id = $recipe_id";
        $ingredients_result = mysqli_query($conn, $ingredients_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Details</title>
    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 1.5rem;
            margin: 4rem;
            padding: 5rem;
            box-shadow: 0 8px 16px rgba(255, 245, 255, 0.3);
        }

        .card-details {
            text-align: center;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
            background-color: #ffg;

        }

        .recipe-details {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
            text-align: left;
        }

        .recipe-details-content {
            max-width: 50%;
        }

        .recipe-image {
            max-width: 50%;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        h2 {
            margin-top: 0;
        }

        p {
            margin-bottom: 10px;
        }

        ul,
        ol {
            margin-top: 0;
        }
        .mt-6 {
            margin-top: 2rem
        }
        .ingredients {
            text-align: "center"
        }
    </style>
</head>

<body>

<?php include("./header/header.php"); ?>

<div class="card">
    <div class="card-details">
            <h2><?php echo $recipe['title']; ?>  By Chef  <?php echo $user['uname']; ?></h2>
            <p><?php echo $recipe['description']; ?></p>
        <div class="recipe-details mt-6">
            
            <div class="recipe-details-content ">
                
                <p>Prep Time: <?php echo $recipe['prep_time']; ?> minutes</p>
                <p>Cook Time: <?php echo $recipe['cook_time']; ?> minutes</p>
                <p>Total Time: <?php echo $recipe['total_time']; ?> minutes</p>
                <p>Serving Size: <?php echo $recipe['serving_size']; ?></p>

                <h3>Category: <?php echo $category['name'] ?? 'Uncategorized'; ?></h3>
                <h3>User: <?php echo $user['uname']; ?></h3>

                <h3>Ingredients:</h3>
                <ul>
                    <?php while ($ingredient = mysqli_fetch_assoc($ingredients_result)) { ?>
                        <li><?php echo $ingredient['quantity']; ?> - <?php echo $ingredient['name']; ?> </li>
                        <?php } ?>
                    <?php if (mysqli_num_rows($ingredients_result) == 0) { ?>
                        <li>No ingredients found</li>
                    <?php } ?>

                </ul>
            </div>
            <div class="recipe-image">
                <?php if ($recipe['files'] !== null) { ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($recipe['files']); ?>" alt="<?php echo $recipe['title']; ?>">
                <?php } else { ?>
                    <p>No image available</p>
                <?php } ?>
            </div>

        </div>
        <div> 
        <h3 class="ingredients">Steps:</h3>
        <ol>
            <?php while ($step = mysqli_fetch_assoc($steps_result)) { ?>
                <li><?php echo $step['description']; ?></li>
            <?php } ?>
        </ol>
        </div>
    </div>
</div>
<?php include("./header/footer.php"); ?>

</body>

</html>



<?php
    } else {
        echo "Recipe not found.";
    }
} else {
    echo "No recipe ID provided.";
}

// Close the database connection
mysqli_close($conn);
?>
