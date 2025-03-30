<?php

session_start();

include 'config.php';



// Check if the user is logged in

if (!isset($_SESSION['user_id'])) {

    exit();

}



// Fetch all users data

$query = "SELECT * FROM mylo_regi";

$result = mysqli_query($conn, $query);



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['delete_user_id'])) {

        $delete_user_id = $_POST['delete_user_id'];

        $delete_query = "DELETE FROM mylo_regi WHERE id = '$delete_user_id'";

        mysqli_query($conn, $delete_query);

        header("Location: view_user.php");

        exit();

    } elseif (isset($_POST['delete_room_id'])) {

        $delete_room_id = $_POST['delete_room_id'];

        

        // Fetch the room image path

        $room_query = "SELECT image FROM rooms WHERE id = '$delete_room_id'";

        $room_result = mysqli_query($conn, $room_query);

        if (mysqli_num_rows($room_result) == 1) {

            $room = mysqli_fetch_assoc($room_result);

            $image_path = "uploads/" . $room['image'];

            

            // Delete the room record from the database

            $delete_room_query = "DELETE FROM rooms WHERE id = '$delete_room_id'";

            if (mysqli_query($conn, $delete_room_query)) {

                // Delete the image file from the server

                if (file_exists($image_path)) {

                    unlink($image_path);

                }

            }

        }

        

        header("Location: view_user.php");

        exit();

    }

}

?>



<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>View Users - Rent Solution</title>

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

        .table-container {

            margin-top: 50px;

        }

        .btn-delete {

            background-color: #dc3545;

            color: white;

            border: none;

            padding: 5px 10px;

            cursor: pointer;

        }

        .btn-delete:hover {

            background-color: #c82333;

        }

    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">

        <div class="container-fluid">

            <a class="navbar-brand mx-auto" href="home.php">Rent Solution</a>

        </div>

    </nav>



    <div class="container table-container">

        <h1 class="text-center">All Users</h1>

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Mobile</th>

                    <th>Email</th>

                    <th>Profile</th>

                    <th>Rooms</th>

                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                <?php while ($user = mysqli_fetch_assoc($result)): ?>

                    <tr>

                        <td><?php echo htmlspecialchars($user['id']); ?></td>

                        <td><?php echo htmlspecialchars($user['mobile']); ?></td>

                        <td><?php echo htmlspecialchars($user['email']); ?></td>

                        <td>

                            <?php

                            $profile_query = "SELECT * FROM prof_up WHERE user_id = '{$user['id']}'";

                            $profile_result = mysqli_query($conn, $profile_query);

                            if (mysqli_num_rows($profile_result) == 1) {

                                $profile = mysqli_fetch_assoc($profile_result);

                                echo "Gender: " . htmlspecialchars($profile['gender']) . "<br>";

                                echo "First Name: " . htmlspecialchars($profile['first_name']) . "<br>";

                                echo "Last Name: " . htmlspecialchars($profile['last_name']) . "<br>";

                                echo "Address: " . htmlspecialchars($profile['address']) . "<br>";

                                echo "City: " . htmlspecialchars($profile['city']) . "<br>";

                                echo "State: " . htmlspecialchars($profile['state']) . "<br>";

                                echo "Zip Code: " . htmlspecialchars($profile['zip_code']);

                            } else {

                                echo "Profile not updated.";

                            }

                            ?>

                        </td>

                        <td>

                            <?php

                            $room_query = "SELECT * FROM rooms WHERE user_id = '{$user['id']}'";

                            $room_result = mysqli_query($conn, $room_query);

                            if (mysqli_num_rows($room_result) > 0) {

                                while ($room = mysqli_fetch_assoc($room_result)) {

                                    echo "Price: " . htmlspecialchars($room['price']) . "<br>";

                                    echo "Size: " . htmlspecialchars($room['size']) . "<br>";

                                    echo "Details: " . htmlspecialchars($room['details']) . "<br>";

                                    echo "<img src='uploads/" . htmlspecialchars($room['image']) . "' alt='Room Image' style='width: 100px; height: 100px;'><br>";

                                    echo "<form method='POST' onsubmit='return confirm(\"Are you sure you want to delete this room?\");'>";

                                    echo "<input type='hidden' name='delete_room_id' value='" . $room['id'] . "'>";

                                    echo "<button type='submit' class='btn-delete'>Delete Room</button>";

                                    echo "</form><br>";

                                }

                            } else {

                                echo "No rooms added.";

                            }

                            ?>

                        </td>

                        <td>

                            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">

                                <input type="hidden" name="delete_user_id" value="<?php echo $user['id']; ?>">

                                <button type="submit" class="btn-delete">Delete User</button>

                            </form>

                        </td>

                    </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>