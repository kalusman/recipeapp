<?php
session_start();
include('connection.php');

$limit = 6;
$page = isset($_GET['page']) ? $_GET['page'] : 1; 
$start = ($page - 1) * $limit; 

$sql = "SELECT * FROM `Recipes`";

if (isset($_GET['category']) && !empty($_GET['category'])) {
    $categoryId = mysqli_real_escape_string($conn, $_GET['category']);
    $sql .= " WHERE `category_id` = $categoryId";
}
if (isset($_SESSION['loggedin']) && $_SESSION['role'] === 'chef') {
    $userId = $_SESSION['user_id'];
    $sql .= isset($_GET['category']) ? " AND `user_id` = $userId" : " WHERE `user_id` = $userId";
}
$sql .= " LIMIT $start, $limit";

$result = mysqli_query($conn, $sql);


$totalRecipes = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM Recipes"));

$totalPages = ceil($totalRecipes / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Website</title>
    <link rel="stylesheet" href="./css/style.css">
    <style> 
.pagination {
    margin-top: 20px;
    text-align: center;
}

.hero-image {
  background-image: url("./images/background.jpg");
  background-color: #cccccc;
  /* height: 500px; */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
}

.pagination a {
    display: inline-block;
    padding: 8px 16px;
    margin: 0 4px;
    color: #333;
    border: 1px solid #ccc;
    text-decoration: none;
    border-radius: 4px;
}

.pagination a.active {
    background-color: #333;
    color: white;
}
#categoryFilter {
    margin-left: 0.5rem
}
</style>

</head>

<body class=" hero-image">
  <div >
   <?php include("./header/header.php"); ?>
      <div class="recipe-card-main mb-4">
          <div class="recipe-card-content">
          <?php
if (isset($_SESSION['loggedin'])) {
    echo '<h2>Welcome, ' . $_SESSION['username'] . ' To Open Kitchen Recipes</h2>';
} else {
    echo '<h2>Welcome, To Open Kitchen Recipes</h2>';
}
?>


              
              <p>"Open Kitchen Recipes" is a platform for sharing and discovering diverse culinary ideas and recipes.
                 It fosters a community spirit by welcoming contributions from anyone interested in cooking and sharing their culinary creations.</p>
          </div>
      </div>
      
      <div class="d-flex">
    <?php
    if (isset($_SESSION['loggedin']) && ($_SESSION['role'] === 'chef' || $_SESSION['role'] === 'admin')) {
        echo '<a href="add_recipe.php" class="btn btn-primary">';
        echo '<img src="./images/add.png" alt="Add" class="icon"> Add Recipe';
        echo '</a>';
    }
    ?>
    
        <select id="categoryFilter" class="form-select">
            <option value="">All Categories</option>
            <?php
            $categoriesResult = mysqli_query($conn, "SELECT * FROM `categories`");
            while ($category = mysqli_fetch_assoc($categoriesResult)) {
                echo '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';
            }
            ?>
        </select>
</div>

      <div class="container">
    <?php
    while ($recipe = mysqli_fetch_assoc($result)) {
        echo '<div style="background-color: white;" class="max-w-sm rounded overflow-hidden shadow-lg mb-4 mt-4">';
        echo '<a href="recipeDetails.php?id=' . $recipe['recipe_id'] . '" style="text-decoration: none; color: inherit;">';
        echo '<img class="w-full" style="height: 19rem;" src="data:image/jpeg;base64,' . base64_encode($recipe['files']) . '" alt="' . $recipe['title'] . '">';
        echo '<div class="px-6 py-4">';
        echo '<div class="font-bold text-xl mb-2">' . $recipe['title'] . '</div>';
        echo '<p class="text-gray-700 text-base">' . $recipe['description'] . '</p>';
        echo '</div>';
        echo '<div class="px-6 pt-4 pb-2 mb-4">';
        echo '<span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">Prep Time: ' . $recipe['prep_time'] . '</span>';
        echo '<span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">Cock Time: ' . $recipe['cook_time'] . '</span>';
        echo '</div>';
        echo '<div class="px-6 pt-4 pb-2">';
        if (isset($_SESSION['loggedin']) && ($_SESSION['role'] === 'chef' || $_SESSION['role'] === 'admin')) {
            echo '<a href="edit_recipe.php?id=' . $recipe['recipe_id'] . '" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2"><img src="./images/edit.png" alt="Edit"></a>';
            echo '<a href="delete_recipe.php?id=' . $recipe['recipe_id'] . '" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"><img src="./images/delete.png" alt="Delete"></a>';
        }
        echo '</div>';
        echo '</a>';
        echo '</div>';

    }
    ?>
    
</div>
    <div class="pagination">
        <?php
        // Pagination links
        for ($i = 1; $i <= $totalPages; $i++) {
            echo '<a href="?page=' . $i . '" class="' . ($page == $i ? 'active' : '') . '">' . $i . '</a>';
        }
        ?>
    </div>
    <?php include("./header/footer.php"); ?>

  </div>
  <script>
    document.getElementById('categoryFilter').addEventListener('change', function () {
        var categoryId = this.value;
        window.location.href = 'index.php' + (categoryId ? '?category=' + categoryId : '');
    });
</script>
</body>

</html>

<?php
mysqli_close($conn);
?>
