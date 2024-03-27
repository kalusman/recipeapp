
<?php
// Include database connection file
include_once "../connection.php";
if (isset($_SESSION['loggedin']) && $_SESSION['role'] === 'admin') {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
            $id = $_GET["id"];

    $sql = "SELECT * FROM recipes WHERE recipe_id=$id";
    $result = mysqli_query($conn, $sql);
    $cat = mysqli_fetch_assoc($result);
    
}
    // Display confirmation message
    echo '
    <style>
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 10px;
        }

        #delete, .cancel {
            padding: 10px 20px;
            margin-right: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #delete {
            background-color: #dc3545;
            color: white;
        }

        .cancel {
            background-color: #007bff;
            color: white;
            text-decoration: none;
        }

        #delete:hover, .cancel:hover {
            opacity: 0.8;
        }
    </style>
    <div class="container">
        <h2>Confirm Deletion</h2>
        <p>Are you sure you want to delete the following user?</p>
        <p><strong>Name:</strong> ' . $cat['title'] . '</p>
        <form method="post" action="delete-recipe.php">
            <input type="hidden" name="id" value="' . $cat['recipe_id'] . '">
            <button id="delete" type="submit" name="delete">Delete</button>
            <a class="cancel" href="?show=account">Cancel</a>
        </form>
    </div>';

    // Close connection
    mysqli_close($conn);
}
?>
