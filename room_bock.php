<?php
        session_start();
        include 'config.php';

        // Require the Composer autoloader for PHPMailer
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';
        require 'PHPMailer/src/Exception.php';

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }

        // Check if the room ID is provided
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            die("Room ID is missing.");
        }

        $room_id = $_GET['id'];

        // Fetch room details and owner's email from the database
        $query = "SELECT rooms.*, mylo_regi.email AS owner_email 
                FROM rooms 
                JOIN mylo_regi ON rooms.user_id = mylo_regi.id 
                WHERE rooms.id = '$room_id'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $room = mysqli_fetch_assoc($result);
            $owner_email = $room['owner_email'];
            $room_details = "Room Details:\nPrice: " . $room['price'] . "\nSize: " . $room['size'] . "\nDetails: " . $room['details'];

            // Create a new PHPMailer instance and send the email
            $mail = new PHPMailer(true);
            
            try {
                // Configure the mailer to use SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';               // Your SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'your-email@gmail.com';      // Your SMTP username
                $mail->Password = 'your-email-password';       // Your SMTP password or app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;                             // Common SMTP port for TLS

                // Ensure less secure app access is enabled or use an app-specific password
                // Check your email provider's documentation for SMTP configuration details
        
                // Set email information
                $mail->setFrom('no-reply@rentsolution.com', 'Rent Solution');
                $mail->addAddress($owner_email);
                $mail->Subject = 'Room Booking Notification';
                $mail->Body = "Dear User,\n\nYour room has been booked.\n\n" . $room_details . "\n\nThank you,\nRent Solution Team";
                
                // Send the email
                $mail->send();
                echo "Room booked successfully. An email notification has been sent to the owner.";
                header("Location: index.php"); // Redirect to the index page
                exit();
            } catch (Exception $e) {
                // Provide a more descriptive error message
                ?>

    <?php
                echo "Room booked successfully.";
                header("Location: index.php"); // Redirect to the index page
                exit();
            }
        } else {
            echo "Room not found.";
        }
    ?>