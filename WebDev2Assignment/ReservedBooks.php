<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
    <title>Library Website - Reserved Books</title>
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
                    <li><a href="Unreserve.php">Unreserve</a></li>
                </ul>
            </div>
        </nav>
        <h1>Reserved Books</h1>
    </section>

    <?php
    //Connects to database
    require_once "DatabaseConnect.php";

    // Start the session to track the logged-in user
    session_start();

    // Function to display reserved books 
    function displayReservedBooks($conn, $username)
    {
        //Retrieves reserved books for the user
        $resBooks = "SELECT booktable.ISBN, booktable.BookTitle, booktable.Author, reservations.ReservedDate
                              FROM booktable
                              JOIN reservations ON booktable.ISBN = reservations.ISBN
                              WHERE reservations.Username = '$username'";

        //Execute the query
        $resBooksResult = mysqli_query($conn, $resBooks);

        if ($resBooksResult) {
            echo'<section class="reserved">';
                echo "<h2>Your Reserved Books:</h2>";
                echo "<table>
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
            echo '</section>';
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    // Check if the user is logged in
    if (!isset($_SESSION['Username'])) {
        //message if the user is not logged in
        echo "<p>You are not logged in. Please <a href='Login.php'>login</a> to view reserved books.</p>";
    } else {
        // Display reserved books for the current user
        displayReservedBooks($conn, $_SESSION['Username']);
    }
    ?>
    <!-------footer---->
    <section class="footer">
                            <p>Aileen Coliban <br>2023 &copy;</p>
                        </section>

</body>

</html>
