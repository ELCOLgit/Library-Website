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
            <h1>Search Results</h1>
        </section>


        <?php
            //Connects to database
            require_once "DatabaseConnect.php";

            // Get the current page number
            $page = isset($_GET['page']) ? $_GET['page'] : 1;

            // Check if the connection is successful
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            //Check if form is submitted via POST
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $title = mysqli_real_escape_string($conn, $_POST["title"]);
                $author = mysqli_real_escape_string($conn, $_POST["author"]);
                $category = mysqli_real_escape_string($conn, $_POST["category"]);
        
                // Construct the SQL query based on the search parameters
                $query = "SELECT * FROM booktable WHERE 1";
        
                if (!empty($title)) {
                    $query .= " AND BookTitle LIKE '%$title%'";
                }
        
                if (!empty($author)) {
                    $query .= " AND Author LIKE '%$author%'";
                }
        
                if (!empty($category)) {
                    $query .= " AND Category = '$category'";
                }
        
                // Set the number of results per page
                $resultsPerPage = 5;
        
                // Calculate the offset for the SQL query
                $offset = ($page - 1) * $resultsPerPage;
        
                // Modify your query to include LIMIT and OFFSET
                $query .= " LIMIT $resultsPerPage OFFSET $offset";
        
                // Executes query
                $result = mysqli_query($conn, $query);
        
                // Check for errors
                if (!$result) {
                    die("Query failed: " . mysqli_error($conn));
                }
        
                //Displays search results
                echo "<div class='search-results'>";
        
                while ($row = mysqli_fetch_assoc($result)) {
                    $isbn = $row['ISBN'];
                    $bookTitle = $row['BookTitle'];
                    $bookAuthor = $row['Author'];
        
                    // Check if the book is already reserved
                    $reservedQuery = "SELECT * FROM reservations WHERE ISBN = '$isbn'";
                    $reservedResult = mysqli_query($conn, $reservedQuery);
        
                    echo "<section class='book-item'>
                              <h4>{$bookTitle} by {$bookAuthor} (ISBN: {$isbn})</h1>";
        
                              echo "</div>";
                              echo "</section>";
                    // Display the reserve button based on reservation status
                    if (mysqli_num_rows($reservedResult) == 0) {
                        echo "<form action='Reserve.php' method='get'>
                                  <input type='hidden' name='isbn' value='$isbn'>
                                  <input type='hidden' name='page' value='$page'>
                                  <input type='submit' value='Reserve' class='submit-button'>
                              </form>";
                              echo "</div>";
                              echo "</section>";
                    } else {
                        echo "<section class='book-item'>";
                        echo "<p>This book is already reserved</p>";
                        
                        echo "</section>";
                        echo "</div>";
                    }
        
                    
                }
        
                
        
                // Display pagination links --- not working properly
                echo "<div class='pagination'>";
                $totalResults = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM booktable WHERE 1"));
                $totalPages = ceil($totalResults / $resultsPerPage);
        
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo "<a href='SearchResults.php?page=$i'>$i</a> ";
                }
        
                echo "</div>";
        
                mysqli_close($conn);
            } else {
                //Redirect to the search page if form does not submit
                header("Location: Search.php");
                exit();
            }
            ?>

        <!---footer--->
        <section class="footer">
            <p>Aileen Coliban <br>2023 &copy;</p>
        </section>

</body>
</html>


