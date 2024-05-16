<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

if(isset($_POST['editAttendance'])) {
    // Check if the attendance data is submitted
    if(isset($_POST['attendance'])) {
        // Loop through the submitted attendance data
        foreach($_POST['attendance'] as $attendanceId => $attendanceStatus) {
            // Update the attendance status in the database based on checkbox state
            $query = "UPDATE tblattendance SET status = '$attendanceStatus' WHERE Id = '$attendanceId'";
            $result = $conn->query($query);
            if(!$result) {
                // Handle the error if any
                $statusMsg = "Error updating attendance.";
            }
        }
        // Provide a success message if the update is successful
        $statusMsg = "Attendance updated successfully.";
    } else {
        // Provide a message if no attendance data is submitted
        $statusMsg = "No attendance data submitted.";
    }
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
  <title>Dashboard</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
      <?php include "Includes/sidebar.php";?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
       <?php include "Includes/topbar.php";?>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">View Class Attendance</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">View Class Attendance</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">View Class Attendance</h6>
                    <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                        <div class="col-xl-6">
                        <label class="form-control-label">Select Date<span class="text-danger ml-2">*</span></label>
                            <input type="date" class="form-control" name="dateTaken" id="exampleInputFirstName" placeholder="Class Arm Name">
                        </div>
                        
                    </div>
                    <button type="submit" name="view" class="btn btn-primary">View Attendance</button>
                  </form>
                </div>
              </div>

              <!-- Input Group -->
                 <div class="row">
              <div class="col-lg-6">
              <div class="card mb-4" style="height: 930px; width:1200px ">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Class Attendance</h6>
                </div>
                <div class="table-responsive p-3">
                <form method="post">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                      <th>Sr.No</th>
                        
                        <th>Enrollment No</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                       
                        <th>Status</th>
                              <th>Date</th>
                              <th>Edit Attendance</th>
                      </tr>
                    </thead>
                   
                    <tbody>

                  <?php

                    if(isset($_POST['view'])){

                      $dateTaken =  $_POST['dateTaken'];

                      $query = "SELECT tblattendance.Id,tblattendance.status,tblattendance.dateTimeTaken,tblcourse.courseName,
                      tblsessionterm.sessionName,tblsessionterm.termId,tblterm.termName,
                      tblstudents.firstName,tblstudents.lastName,tblstudents.enrollmentNo
                      FROM tblattendance
                      INNER JOIN tblcourse ON tblcourse.courseId = tblattendance.courseId
                     
                      INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                      INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                      INNER JOIN tblstudents ON tblstudents.enrollmentNo = tblattendance.enrollmentNo
                      where tblattendance.dateTimeTaken = '$dateTaken' and tblattendance.courseId = '$_SESSION[courseId]' ";
                      $rs = $conn->query($query);
                      $num = $rs->num_rows;
                      $sn=0;
                      $status="";
                      if($num > 0) { 
                        while ($rows = $rs->fetch_assoc()) {
                          if($rows['status'] == '1') {
                            $status = "Present"; 
                            $colour = "rgba(0, 255, 0, 0.6)";
                            $checked = "checked"; // Checkbox initially checked if present
                          } else {
                            $status = "Absent";
                            $colour = "rgba(255, 0, 0, 0.6)";
                            $checked = ""; // Checkbox initially unchecked if absent
                          }
                          $sn = $sn + 1;
                          echo "
                          <tr>
                            <td>".$sn."</td>
                            <td>".$rows['enrollmentNo']."</td>
                            <td>".$rows['firstName']."</td>
                            <td>".$rows['lastName']."</td>
                            <td style='background-color:".$colour."'>".$status."</td>
                            <td>".$rows['dateTimeTaken']."</td>
                            <td>
                              <input type='hidden' name='attendance[".$rows['Id']."]' value='0'>
                              <input type='checkbox' name='attendance[".$rows['Id']."]' value='1' ".$checked.">
                            </td>
                          </tr>";
                        }
                      } else {
                        echo "<div class='alert alert-danger' role='alert'>No Record Found!</div>";
                      }
                    }
                    ?>
                    </tbody>
                  </table>
                  <button type="submit" name="editAttendance" class="btn btn-primary">Edit Attendance</button>
                      </form>
                </div>
              </div>
            </div>
            
            
            </div>
            
            <div class="col-lg-6" style="display:flex;width: 1100px;">
              <div class="card mb-4" style="display: inline-block; width: 48%; margin-right: 10px; margin-bottom: 10px;justify-content: center">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Attendance Summary</h6>
                </div>
                <div class="card-body">
                  <canvas id="attendanceChart" width="400" height="400"></canvas>
                  <?php
                    if(isset($_POST['view'])){
                      $dateTaken = $_POST['dateTaken'];
                      $courseId = $_SESSION['courseId'];
                      $query = "SELECT status, COUNT(*) AS count FROM tblattendance WHERE dateTimeTaken = '$dateTaken' AND courseId = '$courseId' GROUP BY status";
                      $result = $conn->query($query);
                      $attendanceData = array(
                          'Present' => 0,
                          'Absent' => 0
                      );
                      $totalStudents = 0;
                      while ($row = $result->fetch_assoc()) {
                          if($row['status'] == '1') {
                              $attendanceData['Present'] = $row['count'];
                          } else {
                              $attendanceData['Absent'] = $row['count'];
                          }
                          $totalStudents += $row['count'];
                      }
                      $absentStudents = $totalStudents - $attendanceData['Present'];
                      echo "<script>
                            var data = ".json_encode($attendanceData).";
                            var ctx = document.getElementById('attendanceChart').getContext('2d');
                            var chart = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    labels: Object.keys(data),
                                    datasets: [{
                                        label: 'Attendance',
                                        data: Object.values(data),
                                        backgroundColor: [
                                            'rgba(0, 255, 0, 0.6)', // Green for Present
                                            'rgba(255, 0, 0, 0.6)', // Red for Absent
                                        ]
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    legend: {
                                        position: 'right'
                                    }
                                }
                            });
                            document.getElementById('attendanceSummary').innerHTML = 'Total Students: ".$totalStudents." | Present: ".$attendanceData['Present']." | Absent: ".$absentStudents."';
                          </script>";
                    }
                  ?>
                  <div id="attendanceSummary"></div>
                </div>
              </div>
              <div class="card mb-4" style="display: inline-block;justify-content: center">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Individual Attendance</h6>
                </div>
                <div class="card-body">
                  <canvas id="individualAttendanceChart" width="400" height="400"></canvas>
                  <?php
                    if(isset($_POST['view'])){
                      $dateTaken = $_POST['dateTaken'];
                      $courseId = $_SESSION['courseId'];
                      $query = "SELECT enrollmentNo, status FROM tblattendance WHERE dateTimeTaken = '$dateTaken' AND courseId = '$courseId'";
                      $result = $conn->query($query);
                      $studentData = array();
                      while ($row = $result->fetch_assoc()) {
                          $studentData[$row['enrollmentNo']] = $row['status'];
                      }
                      echo "<script>
                            var studentData = ".json_encode($studentData).";
                            var ctx = document.getElementById('individualAttendanceChart').getContext('2d');
                            var chart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: ".json_encode(array_keys($studentData)).",
                                    datasets: [{
                                        label: 'Attendance',
                                        data: ".json_encode(array_values($studentData)).",
                                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                          </script>";
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>
          

        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
       <?php include "Includes/footer.php";?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
   <!-- Page level plugins -->
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>
</body>

</html>
