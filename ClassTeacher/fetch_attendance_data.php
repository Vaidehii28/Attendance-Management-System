<?php
include '../Includes/dbcon.php';

$dateTaken = $_POST['dateTaken'];
$courseId = $_POST['courseId'];

$query = "SELECT status, COUNT(*) AS count FROM tblattendance WHERE dateTimeTaken = '$dateTaken' AND courseId = '$courseId' GROUP BY status";
$result = $conn->query($query);

$attendanceData = array();
while ($row = $result->fetch_assoc()) {
    $status = ($row['status'] == '1') ? 'Present' : 'Absent';
    $attendanceData[$status] = $row['count'];
}

echo json_encode($attendanceData);
?>
