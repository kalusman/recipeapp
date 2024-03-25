<style>
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
  color: white;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 0.5rem;
  text-decoration: none;
  display: inline-block;
  transition: background-color 0.3s;
}

.action-button :hover {
  background-color: #F5B041;
}
.add-btn {
    margin-bottom: 1rem;
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

</style>
<?php
// session_start();


// Include database connection file
include_once "../connection.php";
if (isset($_SESSION['loggedin']) && $_SESSION['role'] === 'admin') {

   echo '
 <div class="datatable-container container">
 <h1> Recipe Management </h1>
 <button class="action-button add-btn"><a href=\'?show=recipes&action=add\'>Add Recipe</a></button>
  <table>
     <thead>
     <tr>
         <th>ID</th>
         <th>Title</th>
         <th>Description</th>
         <th>UserName</th>
         <th>Category</th>
         <th>Actions</th>

     </tr>
     </thead>
     <tbody>';

   $limit = 10; 
   $page = isset($_GET['page']) ? $_GET['page'] : 1; 
   $start = ($page - 1) * $limit;

   $sql = "SELECT recipes.*, IFNULL(users.uname, '') AS uname, IFNULL(categories.name, '') AS name
   FROM recipes
   LEFT JOIN users ON recipes.user_id = users.id
   LEFT JOIN categories ON recipes.category_id = categories.id
   LIMIT $start, $limit";

   
   $result = mysqli_query($conn, $sql);
   while ($row = mysqli_fetch_assoc($result)) {
       echo '<tr>';
       echo '<td>' . $row['recipe_id'] . '</td>';
       echo '<td>' . $row['title'] . '</td>';
       echo '<td>' . $row['description'] . '</td>';
       echo '<td>' . $row['uname'] . '</td>';
       echo '<td>' . $row['name'] . '</td>';
       echo '<td class="actions">';
       echo '<button class="action-button"><a href=\'?show=recipes&action=edit&id=' . $row['recipe_id'] . '\'>Edit</a></button>';
       echo '<button class="action-button-delete"><a href=\'?show=recipes&action=delete&id=' . $row['recipe_id'] . '\'>Delete</a></button>';       
       echo '</td>';
       echo '</tr>';
   }

   // Pagination links
   $count_query = "SELECT COUNT(*) AS total FROM recipes";
   $count_result = mysqli_query($conn, $count_query);
   $count_row = mysqli_fetch_assoc($count_result);
   $total_records = $count_row['total'];
   
   // Calculate total pages
   $total_pages = ceil($total_records / $limit);
   
   // Display pagination links
   echo '<tr><td colspan="6"><div class="pagination">';
   for ($i = 1; $i <= $total_pages; $i++) {
       echo '<a href="?show=recipes&page=' . $i . '">' . $i . '</a>';
   }
   echo '</div></td></tr>';
   // Close connection
   mysqli_close($conn);

   echo '
     </tbody>
 </table>
 </div>';
} ?>