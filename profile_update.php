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

$result = mysqli_query($conn, $query);



if (mysqli_num_rows($result) == 1) {

    $user = mysqli_fetch_assoc($result);

} else {

    $user = [

        'gender' => '',

        'first_name' => '',

        'last_name' => '',

        'address' => '',

        'city' => '',

        'state' => '',

        'zip_code' => ''

    ];

}



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $gender = $_POST['gender'];

    $first_name = $_POST['first_name'];

    $last_name = $_POST['last_name'];

    $address = $_POST['address'];

    $city = $_POST['city'];

    $state = $_POST['state'];

    $zip_code = $_POST['zip_code'];



    $query = "INSERT INTO prof_up (user_id, gender, first_name, last_name, address, city, state, zip_code) 

              VALUES ('$user_id', '$gender', '$first_name', '$last_name', '$address', '$city', '$state', '$zip_code')

              ON DUPLICATE KEY UPDATE 

              gender='$gender', first_name='$first_name', last_name='$last_name', address='$address', city='$city', state='$state', zip_code='$zip_code'";



    if (mysqli_query($conn, $query)) {

        header("Location: index.php");

        exit();

    } else {

        $error = "Error: " . mysqli_error($conn);

    }

}

?>



<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profile Update - Rent Solution</title>

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

        .form-container {

            margin-top: 50px;

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

    

    <div class="container form-container">

        <h1>Update Profile</h1>

        <?php if(isset($error)): ?>

            <div class="alert alert-danger"><?php echo $error; ?></div>

        <?php endif; ?>

        

        <form method="POST">

            <div class="mb-3">

                <label for="gender" class="form-label">Gender</label>

                <input type="text" class="form-control" id="gender" name="gender" value="<?php echo htmlspecialchars($user['gender']); ?>" required>

            </div>

            <div class="mb-3">

                <label for="first_name" class="form-label">First Name</label>

                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>

            </div>

            <div class="mb-3">

                <label for="last_name" class="form-label">Last Name</label>

                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>

            </div>

            <div class="mb-3">

                <label for="address" class="form-label">Address</label>

                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>

            </div>

            <div class="mb-3">

                <label for="city" class="form-label">City</label>

                <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" required>

            </div>

            <div class="mb-3">

                <label for="state" class="form-label">State</label>

                <input type="text" class="form-control" id="state" name="state" value="<?php echo htmlspecialchars($user['state']); ?>" required>

            </div>

            <div class="mb-3">

                <label for="zip_code" class="form-label">Zip Code</label>

                <input type="text" class="form-control" id="zip_code" name="zip_code" value="<?php echo htmlspecialchars($user['zip_code']); ?>" required>

            </div>

            <div class="btn-center">

                <button type="submit" class="btn btn-primary">Update Profile</button>

            </div>

        </form>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>