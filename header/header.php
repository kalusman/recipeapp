<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" href="./css/header.css">
    <style>
.navbar-buttons {
    margin-right: 3rem;
}         /* Style for the circular user icon */
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
    <nav class="navbar">
        <div class="container-header">
            <a href="#" class="logo">
                <!-- <img src="https://flowbite.com/docs/images/logo.svg" alt="Flowbite Logo" class="logo-img"> -->
                <span class="logo-text">Open Kitchen</span>
            </a>
            
            <div class="navbar-menu">
                <ul class="menu-items">
                    <li><a href="index.php" class="menu-link active">Home</a></li>
                    <li><a href="about.php" class="menu-link">About</a></li>
                    <li><a href="contact.php" class="menu-link">Contact</a></li>
                </ul>
            </div>
            <div class="navbar-buttons">
            <?php
                // Check if the user is logged in
                if (isset($_SESSION['loggedin'])) {
                    // User is logged in, show username and dropdown panel
                    echo '<div>Welcome, ' . $_SESSION['username'] .  '</div>';

                    echo '<div class="dropdown">';
                    echo '<div class="user-icon">' . strtoupper(substr($_SESSION['username'], 0, 1)) . '</div>';
                    echo '<div class="dropdown-panel">';
                    echo '<a href="logout.php" class="dropdown-item">Logout</a>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    // User is not logged in, show "Get started" button
                    echo '<button id="loginButton" class="btn btn-primary">Get started</button>';
                }
                ?>
            </div>
        </div>
    </nav>

    <script>
        document.getElementById("loginButton").addEventListener("click", function() {
            window.location.href = "login.php";
        });

        document.addEventListener("DOMContentLoaded", function () {
            var menuLinks = document.querySelectorAll(".menu-link");
            var currentUrl = window.location.href;

            menuLinks.forEach(function (link) {
                if (link.href === currentUrl) {
                    link.classList.add("active");
                } else {
                    link.classList.remove("active");
                }
            });
        });
    </script>
</body>
</html>
