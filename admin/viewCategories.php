<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Categories</title>
<link rel="stylesheet" href="../css/categories.css">
<style>
    /* categories.css */



.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    background-color: #fff;
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}
.action-button {
  background-color: #F1A72B;
  color: #fff;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 0.5rem;
  text-decoration: none;
  display: inline-block;
  transition: background-color 0.3s;
}
.action-button-delete {
  background-color: #E74C3C ;
  color: #fff;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 0.5rem;
  text-decoration: none;
  display: inline-block;
  transition: background-color 0.3s;
}
.action-button-delete :hover {
    background-color: #B03A2E;
}

.action-button :hover {
  background-color: #F5B041;
}
.add-btn {
    margin-bottom: 1rem;
}



    </style>
</head>
<body>
<div class="container">
    <h1>Categories</h1>
    <button class="action-button add-btn"> <a href="?show=category&action=add">Add User</a></button>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../connection.php';

            $sql = "SELECT * FROM categories";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo '<td class="actions">';
                    echo '<button class="action-button"><a href=\'?show=category&action=edit&id=' . $row['id'] . '\'>Edit</a></button>';
                    echo '<button class="action-button-delete"><a href=\'?show=category&action=delete&id=' . $row['id'] . '\'>Delete</a></button>';       
                    echo '</td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No categories found</td></tr>";
            }

            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
