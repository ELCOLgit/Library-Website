<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
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
        <h1>Reserve</h1>
    </section>

    <?php
    //Connect to database
    require_once "DatabaseConnect.php";

    // Start the session to track the logged-in user
    session_start();

    //function to check if user is logged in
    function isLoggedIn()
    {
        return isset($_SESSION['Username']);
    }

    //Function to display reserved books
    function displayReservedBooks($conn, $username)
    {
        //retrieves books
        $resBooks = "SELECT booktable.ISBN, booktable.BookTitle, booktable.Author, reservations.ReservedDate
                              FROM booktable
                              JOIN reservations ON booktable.ISBN = reservations.ISBN
                              WHERE reservations.Username = '$username'";
        //Executes query
        $resBooksResult = mysqli_query($conn, $resBooks);

        if ($resBooksResult) {
            echo "<h2>Your Reserved Books:</h2>";
            echo "<table border='1'>
                    <tr>
                        <th>ISBN</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Reserved Date</th>
                    </tr>";

            //Loop through the result to display each reserved book
            while ($row = mysqli_fetch_assoc($resBooksResult)) {
                echo "<tr>
                        <td>{$row['ISBN']}</td>
                        <td>{$row['BookTitle']}</td>
                        <td>{$row['Author']}</td>
                        <td>{$row['ReservedDate']}</td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    // Check if the user is logged in
    if (!isLoggedIn()) {
        //message and link if the user is not logged in
        echo "<p>You are not logged in. You cannot reserve a book. 
              <a href='Login.php'>Login</a> to reserve books.</p>";
    } else {
        // Check if the form is submitted to reserve a book
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["isbn"]) && isset($_POST["username"])) {
                $isbn = mysqli_real_escape_string($conn, $_POST["isbn"]);
                $username = mysqli_real_escape_string($conn, $_POST["username"]);

                // Check if the book is not already reserved
                $checkReserve = "SELECT * FROM reservations WHERE ISBN = '$isbn'";
                $checkReserveResult = mysqli_query($conn, $checkReserve);

                if (mysqli_num_rows($checkReserveResult) == 0) {
                    // If book is not reserved, reserve it
                    $reservedDate = date("Y-m-d"); // Capture the current date

                    $reserve = "INSERT INTO reservations (ISBN, Username, ReservedDate) VALUES ('$isbn', '$username', '$reservedDate')";
                    $reserveResult = mysqli_query($conn, $reserve);

                    if ($reserveResult) {
                        echo "Book reserved successfully!";
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                } else {
                    echo "This book is already reserved by someone else.";
                }
            }
        
           
        }
    
        // Display reservation options for the logged-in user
        echo "<section class='reserve-options'>";
        echo "<form action='Reserve.php' method='post'>
                <label for='isbn'>ISBN:</label>
                <input type='text' id='isbn' name='isbn' required>
                <input type='hidden' name='username' value='" . $_SESSION['Username'] . "'>
                <button type='submit'>Reserve Book</button>
              </form>";

        echo "<br><p><a href='Unreserve.php' class='button-link'>Unreserve a Book</a></p><br>";
        echo "<p><a href='ReservedBooks.php' class='button-link'>View Reserved Books</a></p>";
        echo "</section>";
    }

    ?>
    <!-------footer---->
    <section class="footer">
                            <p>Aileen Coliban <br>2023 &copy;</p>
                        </section>

</body>

</html>
