




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
<?php include 'includes/title.php';?>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
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
            <h1 class="h3 mb-0 text-gray-800">Add Students</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add Students</li>
            </ol>
          </div>

          <div class="row">
            <form class="" action="" enctype="multipart/form-data" method="post">
                <input type="file" name="excel" required value="">
                 <button type="submit" name="import">Import Excelsheet</button>

            </form>
            <?php
            if(isset($_POST["import"])){
                $fileName=$_FILES["excel"]["name"];
                $fileExtension=explode('.',$fileName);
                $fileExtension=strtolower(end($fileExtension));
                $newFileName=date("Y.m.d") . "-" .date("h.i.sa"). "." . $fileExtension;

                $targetDirectory="uploads/" . $newFileName;
                move_uploaded_file($_FILES["excel"]["tmp_name"],$targetDirectory);
                error_reporting(0);
                 ini_set('display_errors',0);
                 include 'excelReader/excel_reader2.php';
                 include 'excelReader/SpreadsheetReader.php';
                 $reader=new SpreadsheetReader($targetDirectory);
                 foreach($reader as $key =>$row){
                    $firstName=$row[0];
                    $lastName=$row[1];
                    $enrollmentNo=$row[2];
                    $courseId=$row[3];
                    
                    mysqli_query($conn,"INSERT INTO tblstudents VALUES('','$firstName',
                    '$lastName',
                    '$enrollmentNo',
                    '$courseId',
                    '')");
                 }
                 echo
                 "
                 <script>
                 alert('Successfully imported');
                 document.location.href='';
                 </script>
                 ";


            }
            ?>
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