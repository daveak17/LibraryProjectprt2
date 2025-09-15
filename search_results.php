<?php
// Database connection
require_once __DIR__ . '/db.php';


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Retrieve data from the form
$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$minYear = isset($_GET['minYear']) && $_GET['minYear'] !== '' ? (int)$_GET['minYear'] : null;
$maxYear = isset($_GET['maxYear']) && $_GET['maxYear'] !== '' ? (int)$_GET['maxYear'] : null;

// Build SQL query
$sql = "SELECT b.title, b.author, b.year, b.copies, b.categories, b.description, b.`condition` 
        FROM book b
        WHERE 1=1";

if (!empty($searchQuery)) {
    $sql .= " AND b.title LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
}

if (!empty($category)) {
    $sql .= " AND FIND_IN_SET('" . $conn->real_escape_string($category) . "', b.categories)";
}

if (!is_null($minYear)) {
    $sql .= " AND b.year >= $minYear";
}

if (!is_null($maxYear)) {
    $sql .= " AND b.year <= $maxYear";
}

$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.html">
            <img src="images/logo.png" alt="Library Logo" class="navbar-logo" />
            e-Shelf
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="insert_book.html">Insert Book</a></li>
                <li class="nav-item"><a class="nav-link active" href="search_results.php">Search Results</a></li>
            </ul>
            <form class="form-inline ml-auto" action="search_results.php" method="get">
                <input class="form-control mr-sm-2" type="search" name="query" value="<?php echo htmlspecialchars($searchQuery); ?>" placeholder="Search by title">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="mb-4 text-center">Search Results</h2>
        
        <form action="search_results.php" method="get" class="mb-4">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="category">Category</label>
                    <select id="category" name="category" class="form-control">
                        <option value="">All</option>
                        <option value="Fiction" <?php if ($category == 'Fiction') echo 'selected'; ?>>Fiction</option>
                        <option value="Non-fiction" <?php if ($category == 'Non-fiction') echo 'selected'; ?>>Non-fiction</option>
                        <option value="Personal Development" <?php if ($category == 'Personal Development') echo 'selected'; ?>>Personal Development</option>
                        <option value="Personal Finance" <?php if ($category == 'Personal Finance') echo 'selected'; ?>>Personal Finance</option>
                        <option value="Literacy Fiction" <?php if ($category == 'Literacy Fiction') echo 'selected'; ?>>Literacy Fiction</option>
                        <option value="Literature" <?php if ($category == 'Literature') echo 'selected'; ?>>Literature</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="minYear">Minimum Year of Publication</label>
                    <input type="number" id="minYear" name="minYear" class="form-control" value="<?php echo htmlspecialchars($minYear); ?>" placeholder="e.g., 1980">
                </div>
                <div class="form-group col-md-4">
                    <label for="maxYear">Maximum Year of Publication</label>
                    <input type="number" id="maxYear" name="maxYear" class="form-control" value="<?php echo htmlspecialchars($maxYear); ?>" placeholder="e.g., 2020">
                </div>
            </div>
            <input type="hidden" name="query" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button class="btn btn-primary" type="submit">Filter</button>
        </form>

        <div id="results">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="card-text">Author: <?php echo htmlspecialchars($row['author']); ?></p>
                            <p class="card-text">Condition: <?php echo htmlspecialchars($row['condition']); ?></p>
                            <p class="card-text">Year of Publication: <?php echo htmlspecialchars($row['year']); ?></p>
                            <p class="card-text">Available Copies: <?php echo htmlspecialchars($row['copies']); ?></p>
                            <p class="card-text">Categories: <?php echo htmlspecialchars($row['categories']); ?></p>
                            <p class="card-text">Description: <?php echo htmlspecialchars($row['description']); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No books found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
