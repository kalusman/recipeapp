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
 <h1> User Management </h1>
 <button class="action-button add-btn"><a href=\'?show=account&action=add\'>Add User</a></button>
  <table>
     <thead>
     <tr>
         <th>ID</th>
         <th>Name</th>
         <th>Role</th>
         <th>Actions</th>
     </tr>
     </thead>
     <tbody>';

   // Pagination variables
   $limit = 10; // Number of records to show per page
   $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number, default is 1
   $start = ($page - 1) * $limit; // Calculate starting point for fetching records

   // Fetch users from the database with pagination
   $sql = "SELECT * FROM users LIMIT $start, $limit";
   $result = mysqli_query($conn, $sql);
   while ($row = mysqli_fetch_assoc($result)) {
       echo '<tr>';
       echo '<td>' . $row['id'] . '</td>';
       echo '<td>' . $row['uname'] . '</td>';
       echo '<td>' . $row['role'] . '</td>';
       echo '<td class="actions">';
       echo '<button class="action-button"><a href=\'?show=account&action=edit&id=' . $row['id'] . '\'>Edit</a></button>';
       echo '<button class="action-button-delete"><a href=\'?show=account&action=delete&id=' . $row['id'] . '\'>Delete</a></button>';       
       echo '</td>';
       echo '</tr>';
   }

   // Pagination links
   $sql = "SELECT COUNT(*) AS total FROM users";
   $result = mysqli_query($conn, $sql);
   $row = mysqli_fetch_assoc($result);
   $total_records = $row['total'];
   $total_pages = ceil($total_records / $limit);

   echo '<tr><td colspan="4"><div class="pagination">';
   for ($i = 1; $i <= $total_pages; $i++) {
       echo '<a href="?show=account&page=' . $i . '">' . $i . '</a>';
   }
   echo '</div></td></tr>';

   // Close connection
   mysqli_close($conn);

   echo '
     </tbody>
 </table>
 </div>';
} ?>