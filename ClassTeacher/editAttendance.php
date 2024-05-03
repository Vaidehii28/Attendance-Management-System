<?php
// editAttendance.php

// Include necessary files and database connection
error_reporting(0); // You may adjust error reporting based on your needs
include '../Includes/dbcon.php';

// Check if 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    $attendanceId = $_GET['id'];

    // Fetch the attendance record based on $attendanceId
    $query = "SELECT * FROM tblattendance WHERE Id = '$attendanceId'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $attendanceData = $result->fetch_assoc();

        // You can now use $attendanceData to pre-fill a form for editing
        $status = $attendanceData['status'];
        $dateTimeTaken = $attendanceData['dateTimeTaken'];

        // Perform the necessary actions for editing attendance
        if (isset($_POST['updateAttendance'])) {
            $newStatus = $_POST['status'];
            $newDateTimeTaken = $_POST['dateTimeTaken'];

            // Update the attendance record in the database
            $updateQuery = "UPDATE tblattendance SET status='$newStatus', dateTimeTaken='$newDateTimeTaken' WHERE Id='$attendanceId'";
            if ($conn->query($updateQuery) === TRUE) {
                echo "Attendance updated successfully!";
            } else {
                echo "Error updating attendance: " . $conn->error;
            }
        }

        // Close the database connection
        $conn->close();
    } else {
        // Handle the case when no attendance record is found with the given 'id'
        echo "Attendance record not found.";
    }
} else {
    // Handle the case when no 'id' parameter is provided
    echo "Attendance ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/iiitn.png" rel="icon">
    <title>Edit Attendance</title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <!-- Your HTML content for the edit form goes here -->
                    <form method="post">
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <input type="text" class="form-control" name="status" value="<?php echo $status; ?>">
                        </div>
                        <div class="form-group">
                            <label for="dateTimeTaken">Date and Time:</label>
                            <input type="text" class="form-control" name="dateTimeTaken" value="<?php echo $dateTimeTaken; ?>">
                        </div>
                        <!-- Add other form fields as needed -->

                        <!-- Add a submit button to update the attendance -->
                        <button type="submit" name="updateAttendance" class="btn btn-primary">Update Attendance</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include necessary JS scripts -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
</body>

</html>
