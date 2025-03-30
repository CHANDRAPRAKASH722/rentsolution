<?php

session_start();

include 'config.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];

    $new_password = $_POST['new_password'];

    $confirm_password = $_POST['confirm_password'];



    if ($new_password !== $confirm_password) {

        $error = "Passwords do not match.";

    } else {

        // Check if the email exists in the database

        $query = "SELECT * FROM mylo_regi WHERE email = '$email'";

        $result = mysqli_query($conn, $query);



        if (mysqli_num_rows($result) == 1) {

            // Update the password

            $update_query = "UPDATE mylo_regi SET password = '$new_password' WHERE email = '$email'";

            if (mysqli_query($conn, $update_query)) {

                header("Location: login.php");

                exit();

            } else {

                $error = "Error updating password: " . mysqli_error($conn);

            }

        } else {

            $error = "Email not found.";

        }

    }

}

?>



<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Forgot Password - Rent Solution</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        .navbar-brand {

            font-size: 1.5em;

            font-weight: bold;

            margin: auto;

        }

        .card {

            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);

            transition: transform 0.2s ease-in-out;

        }

        .card:hover {

            transform: scale(1.05);

        }

        .card-header {

            background-color: #f8f9fa;

        }

        .btn-center {

            display: flex;

            justify-content: center;

        }

        a {

            text-decoration: none;

        }

    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">

        <div class="container-fluid">

            <a class="navbar-brand" href="index.php">Rent Solution</a> <!-- Updated to index.php -->

        </div>

    </nav>

    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card">

                    <div class="card-header">

                        <h3 class="text-center">Forgot Password</h3>

                    </div>

                    <div class="card-body">

                        <?php if (isset($error)): ?>

                            <div class="alert alert-danger"><?php echo $error; ?></div>

                        <?php endif; ?>

                        <?php if (isset($success)): ?>

                            <div class="alert alert-success"><?php echo $success; ?></div>

                        <?php endif; ?>



                        <form method="POST">

                            <div class="mb-3">

                                <label for="email" class="form-label">Email</label>

                                <input type="email" class="form-control" id="email" name="email" required>

                            </div>

                            <div class="mb-3">

                                <label for="new_password" class="form-label">New Password</label>

                                <input type="password" class="form-control" id="new_password" name="new_password" required>

                            </div>

                            <div class="mb-3">

                                <label for="confirm_password" class="form-label">Confirm Password</label>

                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>

                            </div>

                            <div class="btn-center">

                                <button type="submit" class="btn btn-primary">Update Password</button>

                            </div>

                        </form>

                        <div class="text-center mt-3">

                            <a href="login.php">Back to Login</a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>