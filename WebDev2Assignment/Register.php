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
    <?php
        //Connect Database
        require_once"DatabaseConnect.php";

        // Start the session to track the logged-in user
        session_start(); 

        // Check if the form is submitted using POST 
        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            //Retrive form data
            $username = mysqli_real_escape_string($conn, $_POST["Username"]);
            $password = mysqli_real_escape_string($conn, $_POST["Password"]); 
            $firstname = mysqli_real_escape_string($conn, $_POST["FirstName"]);
            $surname = mysqli_real_escape_string($conn, $_POST["Surname"]);
            $addressline1 = mysqli_real_escape_string($conn, $_POST["AddressLine1"]);
            $addressline2 = mysqli_real_escape_string($conn, $_POST["AddressLine2"]);
            $city = mysqli_real_escape_string($conn, $_POST["City"]);
            $telephone = mysqli_real_escape_string($conn, $_POST["Telephone"]);
            $mobile = mysqli_real_escape_string($conn, $_POST["Mobile"]);

            // Insert user data into the database
            $sql = "INSERT INTO users (Username, Password, FirstName, Surname, AddressLine1, AddressLine2, City, Telephone, Mobile)
            VALUES ('$username', '$password', '$firstname', '$surname', '$addressline1', '$addressline2', '$city', '$telephone', '$mobile')";

            // Check if the query is executed successfully
            if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
            } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            }

        }
        

    ?>

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
        <h1>Register</h1>
    </section>

    <!-- Registration form section -->
    <section class="contact-form">
        <div class="container">
            <form method="post" action="">
                <div class="con-row">
                    <div class="con-col1">
                        <label for="Username">Username:</label>
                    </div>
                    <div class="con-col2">
                        <input type="text" name="Username" required><br>
                    </div>
                </div>
                <div class="con-row">
                    <div class="con-col1">
                        <label for="Password">Password:</label>
                    </div>
                    <div class="con-col2">
                        <input type="Password" name="Password" required><br>
                    </div>
                </div>
                <div class="con-row">
                    <div class="con-col1">
                        <label for="FirstName">First Name:</label>
                    </div>
                    <div class="con-col2">
                        <input type="text" name="FirstName" required><br>
                    </div>
                </div>
                <div class="con-row">
                    <div class="con-col1">
                        <label for="Surname">Surname:</label>
                    </div>
                    <div class="con-col2">
                        <input type="text" name="Surname" required><br>
                    </div>
                </div>
                <div class="con-row">
                    <div class="con-col1">
                        <label for="AddressLine1">Address Line 1:</label>
                    </div>
                    <div class="con-col2">
                        <input type="text" name="AddressLine1" required><br>
                    </div>
                </div>
                <div class="con-row">
                    <div class="con-col1">
                        <label for="AddressLine2">Address Line 2:</label>
                    </div>
                    <div class="con-col2">
                        <input type="text" name="AddressLine2" required><br>
                    </div>
                </div>
                <div class="con-row">
                    <div class="con-col1">
                        <label for="City">City:</label>
                    </div>
                    <div class="con-col2">
                        <input type="text" name="City" required><br>
                    </div>
                </div>
                <div class="con-row">
                    <div class="con-col1">
                        <label for="Telephone">Telephone:</label>
                    </div>
                    <div class="con-col2">
                        <input type="text" name="Telephone" required><br>
                    </div>
                </div>
                <div class="con-row">
                    <div class="con-col1">
                        <label for="Mobile">Mobile:</label>
                    </div>
                    <div class="con-col2">
                        <input type="text" name="Mobile" required><br>
                    </div>
                </div>
                <div class="con-row">
                <input type="submit" value="Register" class="submit-button">
                </div>

            </form>
        </div> 
    </section>
    <!-------footer---->
    <section class="footer">
        <p>Aileen Coliban <br>2023 &copy;</p>
    </section>

</body>
</html>
