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
        <h1>Search</h1>
    </section>

    <!---SEARCH FORM--->
    <form action="SearchResults.php" method="post" class="search-form">
        <!----Book Title input---->
        <label for="title" class="form-label">Book Title:</label>
        <input type="text" name="title" id="title" placeholder="Enter book title" class="form-input">

        <!----Author input---->
        <label for="author" class="form-label">Author:</label>
        <input type="text" name="author" id="author" placeholder="Enter author" class="form-input">
    
        <!----Category dropdown---->
        <label for="category" class="form-label">Category:</label>
        <select name="category" id="category" class="form-input">
            <option value="">Select category</option>
            <?php
                // Fetch categories from the database and populate the dropdown
                require_once "DatabaseConnect.php";
                $query = "SELECT * FROM categories";
                $result = mysqli_query($conn, $query);
    
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['CategoryID']}'>{$row['CategoryDesc']}</option>";
                }
            
                mysqli_close($conn);
            ?>
        </select>
            
        <input type="submit" value="Search" class="submit-button">
    </form>

    <!-------footer---->
    <section class="footer">
        <p>Aileen Coliban <br>2023 &copy;</p>
    </section>

</body>
</html>


