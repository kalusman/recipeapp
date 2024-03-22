<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Category</title>
<link rel="stylesheet" href="../css/categories.css">
<style>
    .card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin: 20px;
}

    </style>
</head>
<body>

<div class="card">

    <h1>Add Category</h1>
    <form action="saveCategory.php" method="post">
        <label for="name">Category Name:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">Save</button>
    </form>

</div>

</body>
</html>
