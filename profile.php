<?php

session_start();

include 'config.php';



// Check if the user is logged in

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");

    exit();

}



$user_id = $_SESSION['user_id'];



// Fetch user profile information

$query = "SELECT * FROM prof_up WHERE user_id = '$user_id'";

//$query = "SELECT * FROM mylo_regi WHERE user_id = '$user_id'";

$result = mysqli_query($conn, $query);



if (mysqli_num_rows($result) == 1) {

    $user = mysqli_fetch_assoc($result);

} else {

    $error = "Profile not found.";

}

?>



<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profile - Rent Solution</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        .navbar {

            margin-top: 20px;

        }

        .navbar-brand {

            font-size: 2em;

            font-weight: bold;

            margin: auto;

        }

        .profile-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 20px;

        }

        .profile-header h1 {

            margin: 0;

        }

        .profile-table {

            margin-top: 20px;

        }

    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">

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

            </div>

        </div>

    </nav>

    <div class="container mt-5">

        <div class="profile-header">

            <h1>Profile</h1>

            <a href="profile_update.php" class="btn btn-primary">Update Profile</a>

        </div>

        <?php if(isset($error)): ?>

            <div class="alert alert-danger"><?php echo $error; ?></div>

        <?php else: ?>

            <table class="table table-bordered profile-table">

                <tr>

                    <th>Gender</th>

                    <td><?php echo htmlspecialchars($user['gender']); ?></td>

                </tr>

                <tr>

                    <th>First Name</th>

                    <td><?php echo htmlspecialchars($user['first_name']); ?>  <?php echo htmlspecialchars($user['last_name']); ?></td>

                </tr>

                <tr>

                    <th>Email</th>

                    <td><?php 
                        if (isset($user['email'])) {
                            $email = $user['email'];
                        } else {
                            $email = "Email not available"; // Provide a fallback value
                        }
                        echo htmlspecialchars($email); 
                    ?></td>

                </tr>

                <tr>

                    <th>Address</th>

                    <td><?php echo htmlspecialchars($user['address']); ?></td>

                </tr>

                <tr>

                    <th>City</th>

                    <td><?php echo htmlspecialchars($user['city']); ?></td>

                </tr>

                <tr>

                    <th>State</th>

                    <td><?php echo htmlspecialchars($user['state']); ?></td>

                </tr>

                <tr>

                    <th>Zip Code</th>

                    <td><?php echo htmlspecialchars($user['zip_code']); ?></td>

                </tr>

            </table>

        <?php endif; ?>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>