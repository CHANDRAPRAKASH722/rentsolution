<?php

session_start();

include 'config.php';



// Check if the user is logged in

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");

    exit();

}



$user_id = $_SESSION['user_id'];



// Check if the user has updated their profile

$query = "SELECT * FROM prof_up WHERE user_id = '$user_id'";

$result = mysqli_query($conn, $query);



if (mysqli_num_rows($result) != 1) {

    header("Location: profile_update.php");

    exit();

}



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $price = $_POST['price'];

    $size = $_POST['size'];

    $details = $_POST['details'];

    $image = $_FILES['image']['name'];

    $target = "uploads/" . basename($image);



    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {

        $query = "INSERT INTO rooms (user_id, price, size, details, image) VALUES ('$user_id', '$price', '$size', '$details', '$image')";

        if (mysqli_query($conn, $query)) {

            header("Location: index.php");

            exit();

        } else {

            $error = "Error: " . mysqli_error($conn);

        }

    } else {

        $error = "Failed to upload image";

    }

}

?>



<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Room - Rent Solution</title>

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

        .btn-center {

            display: flex;

            justify-content: center;

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

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card">

                    <div class="card-header">

                        <h3 class="text-center">Add Room</h3>

                    </div>

                    <div class="card-body">

                        <?php if(isset($error)): ?>

                            <div class="alert alert-danger"><?php echo $error; ?></div>

                        <?php endif; ?>

                        

                        <form method="POST" enctype="multipart/form-data">

                            <div class="mb-3">

                                <label for="price" class="form-label">Price</label>

                                <input type="text" class="form-control" id="price" name="price" required>

                            </div>

                            <div class="mb-3">

                                <label for="size" class="form-label">Size</label>

                                <input type="text" class="form-control" id="size" name="size" required>

                            </div>

                            <div class="mb-3">

                                <label for="details" class="form-label">Room Details</label>

                                <textarea class="form-control" id="details" name="details" rows="3" required></textarea>

                            </div>

                            <div class="mb-3">

                                <label for="image" class="form-label">Image</label>

                                <input type="file" class="form-control" id="image" name="image" required>

                            </div>

                            <div class="btn-center">

                                <button type="submit" class="btn btn-primary">Add Room</button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>