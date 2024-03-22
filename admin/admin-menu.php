<?php
session_start();
include('../connection.php');
function isActive($page) {
    $currentShow = isset($_GET['show']) ? $_GET['show'] : 'dashboard';
    return $currentShow === $page ? 'active' : '';
}

if (isset($_SESSION['loggedin']) && ($_SESSION['role'] === 'chef' || $_SESSION['role'] === 'admin')) {

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin.css">

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .actions {
            display: flex;
            gap: 5px;
        }

        .action-button {
            padding: 5px 10px;
            cursor: pointer;
            background-color: #F1A72B;
            color: white;
            border: none;
            border-radius: 3px;
        }

        .action-button:hover {
            background-color: #F5B041;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
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

        .header-actions {
            display: flex;
            align-items: center; /* Align items vertically */
        }


       /* Style for the circular user icon */
         .user-icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #F1A72B;
            color: #fff;
            font-size: 20px;
            text-align: center;
            line-height: 40px;
            margin-right: 10px;
            margin-right: 4rem
        }

        /* Dropdown panel styles */
        .dropdown {
            position: relative;
            display: inline-block;
            /* margin-right: 10px; */
        }

        .dropdown-panel {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 80px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 5px;
            padding: 10px;
        }

        .dropdown:hover .dropdown-panel {
            display: block;
        }

        .dropdown-item {
            /* padding: 8px 16px; */
            text-decoration: none;
            display: block;
            color: #333;
        }

        .dropdown-item:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<input type="checkbox" name="" id="menu-toggle">
<div class="overlay"><label for="menu-toggle">
  </label>
</div>
<div class="sidebar">
  <div class="sidebar-container">
    
    <div class="brand">
      <h3>
        <span class="lab la-staylinked"></span>
        Open K
      </h3>
    </div>
  
    <div class="sidebar-menu">
        <ul>
            <li><a href="?show=dashboard" class="<?php echo isActive('dashboard'); ?>"><span class="las la-adjust"></span><span>Dashboard</span></a></li>
            <li><a href="?show=recipes" class="<?php echo isActive('recipes'); ?>"><span class="las la-video"></span><span>Recipes</span></a></li>
            <li><a href="?show=category" class="<?php echo isActive('category'); ?>"><span class="las la-chart-bar"></span><span>Category</span></a></li>
            <li><a href="?show=account" class="<?php echo isActive('account'); ?>"><span class="las la-user"></span><span>Account</span></a></li>
        </ul>
    </div>

  </div>
</div>
<div class="main-content">
  <header>
    <div class="header-wrapper">
      <label for="menu-toggle">
        <span class="las la-bars"></span>
      </label>
      <div class="header-title">
        <h1>Dashboard</h1>
        <p>Dashboard For Open Kitchen <span class="las la-chart-line"></span></p>
      </div>
    </div>
    <div class="header-action">
    <?php
                // Check if the user is logged in
                if (isset($_SESSION['loggedin'])) {
                    // User is logged in, show username and dropdown panel
                    //echo '<div class="welcome">Welcome, ' . $_SESSION['username'] .  '</div>';

                    echo '<div class="dropdown">';
                    echo '<div class="user-icon">' . strtoupper(substr($_SESSION['username'], 0, 1)) . '</div>';
                    echo '<div class="dropdown-panel">';
                    echo '<a href="../logout.php" class="dropdown-item">Logout</a>';
                    echo '</div>';
                    echo '</div>';
                } 
                ?>
    </div>
  </header>
  <main>
  <?php

   switch ($_GET['show']) {
        case 'dashboard' :
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'add':
                        include('dashboard.php');
                        break;
                    case 'edit':
                        include('dashboard.php');
                        break;
                    case 'delete':
                        include('dashboard.php');
                        break;
                    default:
                        include('dashboard.php');
                        break;
                }
            } else {
                include('dashboard.php'); 
            }
      break;
       case 'account':
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'add':
                    include('registration.php');
                    break;
                case 'edit':
                    include('registration.php');
                    break;
                case 'delete':
                    include('deleteUser.php');
                    break;
                default:
                    include('viewUser.php');
                    break;
            }
        } else {
            include('viewUser.php'); 
        }
  break;
  case 'category':
    // Render the appropriate catagory action based on the action parameter
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'add':
                include('addCategory.php');
                break;
            case 'edit':
                include('editCategory.php');
                break;
            case 'delete':
                include('deleteCategory.php');
                break;
            default:
                include('viewCategories.php');
                break;
        }
    } else {
        include('viewCategories.php'); 
    }
    break;
    case 'recipes':
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'add':
                    include('add-recipe-admin.php');
                    break;
                case 'edit':
                    include('edit-recipe-admin.php');
                    break;
                case 'delete':
                    include('delete-recipe-admin.php');
                    break;
                default:
                    include('admin-recipes.php');
                    break;
            }
        } else {
            include('admin-recipes.php'); 
        }
        break;
}
  ?>
  </main>
</div>


</body>
</html>
<?php
}
?>