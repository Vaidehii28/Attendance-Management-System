<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
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
  <link rel="stylesheet" href="css/custom.css">

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    function typeDropDown(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","ajaxCallTypes.php?tid="+str,true);
        xmlhttp.send();
    }
}

function lowAttendance(){
  const myHeaders = new Headers();
myHeaders.append("Authorization", "App 856928a45c2e59bdc0b6b925afd76339-45751347-fa9a-48b1-a1a0-b2aa5758c437");
myHeaders.append("Content-Type", "application/json");
myHeaders.append("Accept", "application/json");

const raw = JSON.stringify({
    "messages": [
        {
            "from": "447860099299",
            "to": "918732908047",
            "messageId": "8a837b2c-b2b5-4f4a-83c1-52fef5926c1c",
            "content": {
                "templateName": "message_test",
                "templateData": {
                    "body": {
                        "placeholders": ["Sunny"]
                    }
                },
                "language": "en"
            }
        }
    ]
});

const requestOptions = {
    method: "POST",
    headers: myHeaders,
    body: raw,
    redirect: "follow"
};

fetch("https://3gynrv.api.infobip.com/whatsapp/1/message/template", requestOptions)
    .then((response) => response.text())
    .then((result) => console.log(result))
    .catch((error) => console.error(error));
}
</script>

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
            <h1 class="h3 mb-0 text-gray-800">View Student Attendance</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">View Student Attendance</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">View Student Attendance</h6>
                    <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                        <div class="col-xl-6">
                        <label class="form-control-label">Select Student<span class="text-danger ml-2">*</span></label>
                        <?php
                        $qry= "SELECT * FROM tblstudents where courseId = '$_SESSION[courseId]'  ORDER BY firstName ASC";
                        $result = $conn->query($qry);
                        $num = $result->num_rows;		
                        if ($num > 0){
                          echo ' <select required name="enrollmentNo" class="form-control mb-3">';
                          echo'<option value="">--Select Student--</option>';
                          while ($rows = $result->fetch_assoc()){
                          echo'<option value="'.$rows['enrollmentNo'].'" >'.$rows['firstName'].' '.$rows['lastName'].'</option>';
                              }
                                  echo '</select>';
                              }
                            ?>  
                        </div>
                        <div class="col-xl-6">
                        <label class="form-control-label">Type<span class="text-danger ml-2">*</span></label>
                          <select required name="type" onchange="typeDropDown(this.value)" class="form-control mb-3">
                          <option value="">--Select--</option>
                          <option value="1" >All</option>
                          <option value="2" >By Single Date</option>
                          <option value="3" >By Date Range</option>
                        </select>
                        </div>
                    </div>
                      <?php
                        echo"<div id='txtHint'></div>";
                      ?>
                    
                    <button type="submit" name="view" class="btn btn-primary">View Attendance</button>
                  </form>
                </div>
              </div>

              <!-- Input Group -->
                 <div class="row">
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Class Attendance</h6>
                </div>
                <div class="table-responsive p-3">
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
                        <!-- <th>Attendance Percentage</th> -->
                      </tr>
                    </thead>
                   



                    <tbody>
  <?php
  if (isset($_POST['view'])) {
    $enrollmentNo = $_POST['enrollmentNo'];
    $type = $_POST['type'];

    if ($type == "1") { // All Attendance
      $query = "SELECT tblattendance.Id, tblattendance.status, tblattendance.dateTimeTaken, tblcourse.courseName,
                    tblsessionterm.sessionName, tblsessionterm.termId, tblterm.termName,
                    tblstudents.firstName, tblstudents.lastName, tblstudents.enrollmentNo
                FROM tblattendance
                INNER JOIN tblcourse ON tblcourse.courseId = tblattendance.courseId
                INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                INNER JOIN tblstudents ON tblstudents.enrollmentNo = tblattendance.enrollmentNo
                WHERE tblattendance.enrollmentNo = '$enrollmentNo' AND tblattendance.courseId = '$_SESSION[courseId]' ";
    } elseif ($type == "2") { // Single Date Attendance
      $singleDate = $_POST['singleDate'];
      $query = "SELECT tblattendance.Id, tblattendance.status, tblattendance.dateTimeTaken, tblcourse.courseName,
                    tblsessionterm.sessionName, tblsessionterm.termId, tblterm.termName,
                    tblstudents.firstName, tblstudents.lastName, tblstudents.enrollmentNo
                FROM tblattendance
                INNER JOIN tblcourse ON tblcourse.courseId = tblattendance.courseId
                INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                INNER JOIN tblstudents ON tblstudents.enrollmentNo = tblattendance.enrollmentNo
                WHERE tblattendance.dateTimeTaken = '$singleDate' AND tblattendance.enrollmentNo = '$enrollmentNo' AND tblattendance.courseId = '$_SESSION[courseId]' ";
    } elseif ($type == "3") { // Date Range Attendance
      $fromDate = $_POST['fromDate'];
      $toDate = $_POST['toDate'];
      $query = "SELECT tblattendance.Id, tblattendance.status, tblattendance.dateTimeTaken, tblcourse.courseName,
                    tblsessionterm.sessionName, tblsessionterm.termId, tblterm.termName,
                    tblstudents.firstName, tblstudents.lastName, tblstudents.enrollmentNo
                FROM tblattendance
                INNER JOIN tblcourse ON tblcourse.courseId = tblattendance.courseId
                INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                INNER JOIN tblstudents ON tblstudents.enrollmentNo = tblattendance.enrollmentNo
                WHERE tblattendance.dateTimeTaken BETWEEN '$fromDate' AND '$toDate' AND tblattendance.enrollmentNo = '$enrollmentNo' AND tblattendance.courseId = '$_SESSION[courseId]' ";
    }

    $rs = $conn->query($query);
    $num = $rs->num_rows;

    if ($num > 0) {
      $sn = 0;
      $totalDays = 0;
      $presentDays = 0;

      while ($rows = $rs->fetch_assoc()) {
        $sn++;
        $status = ($rows['status'] == '1') ? "Present" : "Absent";
        $colour = ($rows['status'] == '1') ? "#00FF00" : "#FF0000";

        // Count total days
        $totalDays++;

        // Count present days
        $presentDays += ($rows['status'] == '1') ? 1 : 0;

        echo "
        <tr>
        <td>" . $sn . "</td>
        <td>" . $rows['enrollmentNo'] . "</td>
        <td>" . $rows['firstName'] . "</td>
        <td>" . $rows['lastName'] . "</td>
        <td style='background-color:" . $colour . "'>" . $status . "</td>
        <td>" . $rows['dateTimeTaken'] . "</td>
        <td><a href='editAttendance.php?id=" . $rows['Id'] . "' target='_blank'>Edit</a></td> <!-- Edit link with target='_blank' -->
      </tr>";
      }
    // Calculate attendance percentage outside the loop
    $attendancePercentage = ($presentDays / $totalDays) * 100;

    // Display a row with the combined attendance percentage
    echo "
    <tr>
      <td colspan='3'></td>
      <td>Combined Attendance Percentage</td>
      <td></td>
      <td>" . number_format($attendancePercentage, 2) . "%</td>
      <td>";

    // Add the conditional statement without opening a new PHP block
    if ($attendancePercentage <= 75) {
        echo "<button class='btn btn-primary' onclick='lowAttendance()'>Send Reminder</button>";
    }

    echo "
      </td> <!-- Placeholder for the extra column in the last row -->
    </tr>";
    } else {
      echo "<div class='alert alert-danger' role='alert'>No Record Found!</div>";
    }
  }
  ?>
</tbody>

                  </table>
                </div>
              </div>
            </div>
            </div>
          </div>

          <!-- Pie Chart -->
            <div class="row mb-4 mr-3 ml-1">
                <div class="col-lg-6">
                    <div class="card mb-4" style="height: 590px; width: 450px;">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">ATTENDANCE PERCENTAGE CHART</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="attendancePieChart" width="300" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Bar Graph for Date-wise Attendance -->
                <div class="col-lg-6">
                    <div class="card mb-4" style="height: 590px; width: 450px;">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">DATE-WISE ATTENDANCE</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="attendanceBarChart" width="300" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <!-- End Bar Graph for Date-wise Attendance -->
            </div>
            <!-- End Pie Chart -->

            <!-- Course List -->
            <div class="row mb-4" >
                <div class="col-lg-12">
                    <div class="card mb-4" style="height: 590px; width: 450px;">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">ENROLLED COURSE LIST</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Course ID</th>
                                        <th>Course Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Query to fetch the course list for the selected student
                                    $courseQuery = "SELECT tblcourse.courseId, tblcourse.courseName FROM tblstudents INNER JOIN tblcourse ON tblstudents.courseId = tblcourse.courseId WHERE tblstudents.enrollmentNo = '$enrollmentNo'";
                                    $courseResult = $conn->query($courseQuery);

                                    if ($courseResult->num_rows > 0) {
                                        while ($courseRow = $courseResult->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $courseRow['courseId'] . "</td>";
                                            echo "<td>" . $courseRow['courseName'] . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='2'>No courses found for this student.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Course List -->


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

  <!-- Script for Pie Chart -->
  <script>
    var attendancePercentage = <?php echo isset($attendancePercentage) ? json_encode($attendancePercentage) : 0; ?>;
    var ctx = document.getElementById('attendancePieChart').getContext('2d');
    var myPieChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ['Present', 'Absent'],
        datasets: [{
          data: [attendancePercentage, 100 - attendancePercentage],
          backgroundColor: ['#00FF00', '#FF0000']
        }]
      },
      options: {
        title: {
          display: true,
          text: 'Attendance Percentage'
        }
      }
    });
  </script>
  <!-- End Script for Pie Chart -->

  <!-- Script for Bar Graph -->
  <script>
    var ctx = document.getElementById('attendanceBarChart').getContext('2d');
    var myBarChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Date 1', 'Date 2', 'Date 3'], // Replace with your actual dates
        datasets: [{
          label: 'Attendance',
          data: [50, 75, 90], // Replace with your actual attendance data
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)'
          ],
          borderWidth: 1
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
  </script>
  <!-- End Script for Bar Graph -->
</body>

</html>
