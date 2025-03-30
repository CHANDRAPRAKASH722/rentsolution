<?php
session_start();
include 'config.php';

function sendOTP($mobile, $otp) {
    // Implement the actual OTP sending logic here using an SMS gateway
    // For example, using Twilio, Nexmo, etc.
    // This is a placeholder function
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['verify_otp'])) {
        $entered_otp = $_POST['otp'];
        $session_otp = $_SESSION['otp'];
        $mobile = $_SESSION['mobile'];
        $email = $_SESSION['email'];
        $password = $_SESSION['password'];

        if ($entered_otp == $session_otp) {
            $query = "INSERT INTO mylo_regi (mobile, email, password) VALUES ('$mobile', '$email', '$password')";
            if (mysqli_query($conn, $query)) {
                unset($_SESSION['otp']);
                unset($_SESSION['mobile']);
                unset($_SESSION['email']);
                unset($_SESSION['password']);
                header("Location: login.php");
                exit();
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        } else {
            $error = "Invalid OTP";
        }
    } else {
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        if ($password !== $cpassword) {
            $error = "Passwords do not match";
        } else {
            $check_query = "SELECT * FROM mylo_regi WHERE email = '$email' OR mobile = '$mobile'";
            $check_result = mysqli_query($conn, $check_query);

            if (mysqli_num_rows($check_result) > 0) {
                $error = "Email or mobile number already exists";
            } else {
                $otp = rand(100000, 999999);
                if (sendOTP($mobile, $otp)) {
                    $_SESSION['otp'] = $otp;
                    $_SESSION['mobile'] = $mobile;
                    $_SESSION['email'] = $email;
                    $_SESSION['password'] = $password;
                    $otp_sent = true;
                } else {
                    $error = "Failed to send OTP";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Rent Solution</title>
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
                        <h3 class="text-center">Register</h3>
                    </div>
                    <div class="card-body">
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <?php if(isset($otp_sent) && $otp_sent): ?>
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="otp" class="form-label">Enter OTP</label>
                                    <input type="text" class="form-control" id="otp" name="otp" required>
                                </div>
                                <div class="btn-center">
                                    <button type="submit" name="verify_otp" class="btn btn-primary">Verify OTP</button>
                                </div>
                            </form>
                        <?php else: ?>
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="mobile" class="form-label">Mobile Number</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="cpassword" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="cpassword" name="cpassword" required>
                                </div>
                                <div class="btn-center">
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </div>
                            </form>
                        <?php endif; ?>
                        <div class="text-center mt-3">
                            <p>Already have an account? <a href="login.php">Login here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>