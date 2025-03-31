<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
