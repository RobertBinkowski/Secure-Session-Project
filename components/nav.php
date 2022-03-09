<nav>
    <style>
        nav{
            width: 100vw;
            padding:1em;
            background-color: gray;
            position: fixed;
            display: flex;
            justify-content: space-around;
            text-align:center;
            top: 0;
            left: 0;
        }
        a{
            text-decoration: none;
            color: yellow;
        }
    </style>
    <a href="index.php">Home</a>
    <a href="dashboard.php">Dashboard</a>
    <a href="userInfo.php">User Info</a>    

    <?php

        if(isset($_SESSION["Username"])){
            if($_SESSION["Username"] == "Admin"){
                echo '<a href="logs.php">Logs</a>';
            }
            echo '<a href="logOut.php">Log Out</a><!-- Log out -->';
        }else{
            echo '<a href="signIn.php">Sign In</a>';
        }
    
    ?>
    <a href="register.php">Register</a>    
</nav>