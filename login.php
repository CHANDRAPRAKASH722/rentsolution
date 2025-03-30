<?php

session_start();

include 'config.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $identifier = $_POST['identifier'];

    $password = $_POST['password'];



    $query = "SELECT * FROM mylo_regi WHERE (email = '$identifier' OR mobile = '$identifier') AND password = '$password'";

    $result = mysqli_query($conn, $query);



    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $user['id'];

        // Redirect to index.php instead of home.php
        header("Location: index.php");

        exit();

    } else {

        $error = "Invalid login credentials";

    }

}

?>



<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Rent Solution</title>

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

            <a class="navbar-brand" href="#">Rent Solution</a>

        </div>

    </nav>



    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card">

                    <div class="card-header">

                        <h3 class="text-center">Login</h3>

                    </div>

                    <div class="card-body">

                        <?php if(isset($error)): ?>

                            <div class="alert alert-danger"><?php echo $error; ?></div>

                        <?php endif; ?>

                        

                        <form method="POST">

                            <div class="mb-3">

                                <label for="identifier" class="form-label">Mobile Number or Email</label>

                                <input type="text" class="form-control" id="identifier" name="identifier" required>

                            </div>

                            <div class="mb-3">

                                <label for="password" class="form-label">Password</label>

                                <input type="password" class="form-control" id="password" name="password" required>

                            </div>

                            <div class="btn-center">

                                <button type="submit" class="btn btn-primary">Login</button>

                            </div>

                        </form>

                        <div class="text-center mt-3">

                            <p>Don't have an account? <a href="register.php">Register here</a></p>

                        </div>

                        <div class="text-center mt-3">

                            <p><a href="forget_p.php">Forgot password?</a></p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>