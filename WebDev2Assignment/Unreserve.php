<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
    <title>Library Website - Unreserve</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,500;1,400&family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body id='unreserved-body'>

    <section class="sub-header">
        <nav>
            <div class="nav-links">
                <ul>
                    <li><a href="Main.html">Home</a></li>
                    <li><a href="Search.php">Search</a></li>
                    <li><a href="Reserve.php">Reserve</a></li>
                    <li><a href="Register.php">Register</a></li>
                    <li><a href="Login.php">My Account</a></li>
                    <li><a href="Unreserve.php">Unreserve</a></li>
                </ul>
            </div>
        </nav>
        <h1>Unreserve</h1>
    </section>

    <?php
    //Connects the database
    require_once "DatabaseConnect.php";

    // Start the session to track the logged-in user
    session_start();

    //Function to display reserved books to the user
    function displayReservedBooks($conn, $username)
    {
        //retrieves reserved books
        $resBooks = "SELECT booktable.ISBN, booktable.BookTitle, booktable.Author, reservations.ReservedDate
                              FROM booktable
                              JOIN reservations ON booktable.ISBN = reservations.ISBN
                              WHERE reservations.Username = '$username'";

        //Execute the Query
        $resBooksResult = mysqli_query($conn, $resBooks);

        //Check if it was successful
        if ($resBooksResult) {
            //Display reserved books
            echo'<section class="reserved-books-container">';
            echo "<h2>Your Reserved Books:</h2>";
            echo "<form action='Unreserve.php' method='post' class='unreserve-form'>";
            echo "<table class='reserved-books-table'>
                    <tr>
                        <th>Select</th>
                        <th>ISBN</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Reserved Date</th>
                    </tr>";

            //Loop through result set and desplay each reserved book
            while ($row = mysqli_fetch_assoc($resBooksResult)) {
                echo "<tr>
                        <td><input type='radio' name='selected' value='{$row['ISBN']}'></td>
                        <td>{$row['ISBN']}</td>
                        <td>{$row['BookTitle']}</td>
                        <td>{$row['Author']}</td>
                        <td>{$row['ReservedDate']}</td>
                      </tr>";
            }

            echo "</table>";
            echo "<button type='submit'>Unreserve Selected Book</button>";
            echo "</form>";
        } else {
            //Display error message if query fails
            echo "Error: " . mysqli_error($conn);
        }
        echo ' </section>';
    }

    // Check if the user is logged in
    if (!isset($_SESSION['Username'])) {
        //Displays message if user is not logged in
        echo "<p>You are not logged in. Please <a href='Login.php'>login</a> to unreserve books.</p>";
    } else {
        // Check if the form is submitted to unreserve a book
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["selected"])) {
                //Get ISBN and username to unreserve the book
                $isbnToUnreserve = mysqli_real_escape_string($conn, $_POST["selected"]);
                $username = mysqli_real_escape_string($conn, $_SESSION["Username"]);

                //query to delete the book from reservations table
                $unreserve = "DELETE FROM reservations WHERE ISBN = '$isbnToUnreserve' AND Username = '$username'";
                //executes the query
                $unreserveResult = mysqli_query($conn, $unreserve);

                //Check if it was unreserved successfully
                if ($unreserveResult) {
                    echo "Book unreserved successfully!";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }
        }

        // Display reserved books for the current user
        displayReservedBooks($conn, $_SESSION['Username']);
    }
    ?>
    <!--footer-->
    <section class="footer">
                            <p>Aileen Coliban <br>2023 &copy;</p>
                        </section>

</body>

</html>

