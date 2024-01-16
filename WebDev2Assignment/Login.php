<?php 
        //Connect to database
        require_once"DatabaseConnect.php";

        // Start the session to track the logged-in user
        session_start(); 

        //If the form is submitted.
        if ( isset($_POST["Username"]) && isset($_POST["Password"]) )
        {
            $username=$_POST["Username"];
            $password=$_POST["Password"];

            //SQL query to check user info
            $query = "SELECT * FROM users WHERE Username='$username' AND Password='$password'";
        
            //execute the query
            $res = mysqli_query($conn, $query) or die("Failed to query database: " . mysqli_error($conn));

            // Fetch a row from the result
            $row=mysqli_fetch_array($res);

            //Check if row is fetched
            if ($row!=0)
            {   
                echo "<h1>Login success!! Welcome </h1>".$row['Username'];
                $_SESSION["success"] = "Logged in.";
                $_SESSION["Username"] = $_POST["Username"];
                header( 'Location: Main.html' ) ;
                return;
            }
            else
            {
                echo "Invalid Login. Please register.";
                $_SESSION["error"] = "Incorrect username or password.";
                header( 'Location: Login.php' ) ;
                return;
            } 
        }
        else if ( count($_POST) > 0 )
        { 

            $_SESSION["error"] = "Missing Required Information";
            header( 'Location: Login.php' ) ;
            return;
        }

        //Check if user is already loggin in
        if (isset($_SESSION['Username'])) {
            $Username = $_SESSION['Username'];
            //Displays user options
            echo '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
                    <title>Library Website</title>
                    <link rel="preconnect" href="https://fonts.googleapis.com">
                    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,500;1,400&family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
                    </head>
                    <body>
                        <section class="sub-header">
                            <nav>
                                <div class="nav-links">
                                    <ul>
                                        <li><a href="Main.html">Home</a></li>
                                        <li><a href="Search.php">Search</a></li>
                                        <li><a href="Reserve.php">Reserve</a></li>
                                        <li><a href="Register.php">Register</a></li>
                                        <li><a href="Login.php">My Account</a></li>
                                    </ul>
                                </div>
                            </nav>
                            <h1>Login</h1>
                        </section>
                        <section class="login-form">
                            <div class="Form">
                                <h1>Hello ' . $Username . '<br></h1>
                                <p>You have successfully logged in. <br></p>
                                <p>What would you like to do? <br></p>
                                <br>
                                <h1><a href="Search.php" class="button-link">Search For Books</a> <br></h1>
                                <br>
                                <h1><a href="Main.html" class="button-link">Go To Main Page</a> <br></h1>
                                <br>
                                <h1><a href="LogOut.php" class="button-link">Not you? Logout.</a> <br></h1>
                                <br>
                            </div>
                            <br><br>
                        </section>
                        <section class="footer">
                            <p>Aileen Coliban <br>2023 &copy;</p>
                        </section>
                    </body>
                    </html>';
        } else {
        
            //Displays login form
            echo '
        
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
                        <title>Library Website</title>
                        <link rel="preconnect" href="https://fonts.googleapis.com">
                        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,500;1,400&family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
                    </head>
                    <body>
        
        
                        <section class="sub-header">
                            <nav>
                                <div class="nav-links">
                                <ul>
                                    <li><a href="Main.html">Home</a></li>
                                    <li><a href="Search.php">Search</a></li>
                                    <li><a href="Reserve.php">Reserve</a></li>
                                    <li><a href="Register.php">Register</a></li>
                                    <li><a href="Login.php">My Account</a></li>
                                </ul>
                                </div>
                            </nav>
                            <h1>Login</h1>
                        </section>
        
        
        
        
                        <section class="login-form">';
            if (isset($_SESSION["error"])) {
                echo '<p style="color:red">Error:' . $_SESSION["error"] . "</p>\n";
                unset($_SESSION["error"]);
            }
            echo '<form action="" method="post">
                                 <label>Username</label>
                                 <input type="text" name="Username" placeholder="Username" required><br>
                                    
                                 <label>Password</label>
                                 <input type="password" name="Password" placeholder="Password" required><br>
                                    
                                 <button type="submit">Login</button>
                             </form>
                             <p>Not registered yet? <a href=\'Register.php\'>Register Here</a></p>
                        </section>
                                   
                        <!-------footer---->
                        <section class="footer">
                            <p>Aileen Coliban <br>2023 &copy;</p>
                        </section>
                                    
                                    
                    </body>
                    </html>';

        }
    
?>
