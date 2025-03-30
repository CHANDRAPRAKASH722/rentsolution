<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the user exists in the database
$room_id = $_SESSION['user_id'];
$room_query = "SELECT * FROM mylo_regi WHERE id = '$room_id'";
$room_result = mysqli_query($conn, $room_query);

if (mysqli_num_rows($room_result) == 0) {
    // User does not exist, destroy session and redirect to login page
    session_destroy();
    header("Location: login.php");
    exit();
}

// Fetch the logged-in user's email
$user_email = "";
$user_query = "SELECT email FROM mylo_regi WHERE id = '$room_id'";
$user_result = mysqli_query($conn, $user_query);
if ($user_result && mysqli_num_rows($user_result) > 0) {
    $user_data = mysqli_fetch_assoc($user_result);
    $user_email = $user_data['email'];
}

// Fetch room data based on search query
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $query = "SELECT rooms.*, prof_up.address, prof_up.city, prof_up.state, prof_up.zip_code 
              FROM rooms 
              JOIN prof_up ON rooms.user_id = prof_up.user_id 
              WHERE prof_up.address LIKE '%$search_query%' 
              OR prof_up.city LIKE '%$search_query%' 
              OR prof_up.state LIKE '%$search_query%' 
              OR prof_up.zip_code LIKE '%$search_query%'";
} else {
    $query = "SELECT rooms.*, prof_up.address, prof_up.city, prof_up.state, prof_up.zip_code 
              FROM rooms 
              JOIN prof_up ON rooms.user_id = prof_up.user_id";
}
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Rent Solution</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Navbar styling */
        .navbar {
            margin-top: 20px;
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-size: 2em;
            font-weight: bold;
            margin: auto;
        }

        /* Card styling */
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card-img-top {
            height: 250px;
            object-fit: cover;
        }

        /* Page header styling */
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
        }

        /* Footer styling */
        footer {
            margin-top: 50px;
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa;
            color: #6c757d;
        }

        /* Search bar styling */
        .search-bar {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        /* Center button in card body */
        .card-body a {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand mx-auto" href="index.php">Rent Solution</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="add_room.php">Add Room</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                </ul>
<span class="navbar-text">
                    <?php echo htmlspecialchars($user_email); ?>
                </span>
            </div>
        </div>
    </nav>
    <div class="search-bar">
        <form method="GET" action="index.php">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search by address, city, state, or zip code" value="<?php echo htmlspecialchars($search_query); ?>">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
    </div>
    <div class="container mt-5">
        <h1>Welcome to Rent Solution</h1>
        <div class="row">
            <?php while ($room = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="uploads/<?php echo htmlspecialchars($room['image']); ?>" class="card-img-top" alt="Room Image">
                        <div class="card-body">
                            <h5 class="card-title">Price: <?php echo isset($room['price']) ? htmlspecialchars($room['price']) : 'N/A'; ?></h5>
                            <p class="card-text">Size: <?php echo isset($room['size']) ? htmlspecialchars($room['size']) : 'N/A'; ?></p>
                            <p class="card-text">Details: <?php echo isset($room['details']) ? htmlspecialchars($room['details']) : 'N/A'; ?></p>
                            <table>
                                <tr>
                                    <th>Address</th>
                                    <td><?php echo htmlspecialchars($room['address']); ?></td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td><?php echo htmlspecialchars($room['city']); ?></td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <td><?php echo htmlspecialchars($room['state']); ?></td>
                                </tr>
                                <tr>
                                    <th>Zip Code</th>
                                    <td><?php echo htmlspecialchars($room['zip_code']); ?></td>
                                </tr>
                            </table>
                            <a href="room_bock.php?id=<?php echo $room['id']; ?>" class="btn btn-primary"> Room bock</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Rent Solution. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>