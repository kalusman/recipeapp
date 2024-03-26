<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Categories</title>
<link rel="stylesheet" href="../css/catagories.css">
</head>
<body>
<div class="container">
    <h1>Categories</h1>
    <button id="addBtn">Add Category</button>
    <table id="categoryTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="categoryList"></tbody>
    </table>
</div>
<div id="overlay">
    <div id="modal">
        <span class="close">&times;</span>
        <h2 id="modalTitle"></h2>
        <input type="text" id="categoryName" placeholder="Category Name">
        <button id="saveBtn"></button>
        <button id="deleteBtn">Delete</button>
    </div>
</div>
<script src="../js/scripts.js"></script>
</body>
</html>
