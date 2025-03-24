<?php
session_start();
require_once '../inc/conn.php';

if (isset($_POST['save'])) {
  $name = $_POST['name'];
  $sumary_desc = $_POST['sumary_desc'];
  $address_sumary = $_POST['address_sumary'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];

  $insert = mysqli_query($conn, "INSERT INTO summary (name, sumary_desc, address_sumary, phone, email) VALUES ('$name', '$sumary_desc', '$address_sumary', '$phone', '$email')");
  if ($insert) {
    header("location:summary.php");
  } else {
    header("location:add-summary.php");
  }
}


if (isset($_GET['idEdit'])) {
  $id = $_GET['idEdit'];

  $showSummary = mysqli_query($conn, "SELECT * FROM summary WHERE id = '$id'");
  $row = mysqli_fetch_assoc($showSummary);
}

if (isset($_POST['edit'])) {
  $name = $_POST['name'];
  $sumary_desc = $_POST['sumary_desc'];
  $address_sumary = $_POST['address_sumary'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];

  $insert = mysqli_query($conn, "UPDATE summary SET
    name = '$name',
    sumary_desc = '$sumary_desc',
    address_sumary = '$address_sumary',
    phone = '$phone',
    email = '$email'
    WHERE id = '$id'");
  header("location:summary.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Summary</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">



</head>

<body>

  <!-- ======= Header ======= -->
  <?php
  include '../inc/navbar.php';
  ?>
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <?php
  include '../inc/sidebar.php';
  ?>
  <!-- End Sidebar-->

  <main id="main" class="main">

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><?= isset($_GET['idEdit']) ? 'EDIT RESUME' : 'ADD' ?></h5>
              <form action="" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                  <div class="col-sm-2">
                    <label for="">Name</label>
                  </div>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" value="<?= isset($_GET['idEdit']) ? $row['name'] : '' ?>"
                      required>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-sm-2">
                    <label for="">Summary Desc</label>
                  </div>
                  <div class="col-sm-10">
                    <textarea class="form-control" name="sumary_desc" value="<?= isset($_GET['idEdit']) ? $row['sumary_desc'] : '' ?>"></textarea>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-sm-2">
                    <label for="">Address Summary</label>
                  </div>
                  <div class="col-sm-10">
                    <textarea class="form-control" name="address_sumary" value="<?= isset($_GET['idEdit']) ? $row['address_sumary'] : '' ?>"></textarea>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-sm-2">
                    <label for="">Phone Number</label>
                  </div>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="phone" value="<?= isset($_GET['idEdit']) ? $row['phone'] : '' ?>"
                      required>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-sm-2">
                    <label for="">Email</label>
                  </div>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" value="<?= isset($_GET['idEdit']) ? $row['email'] : '' ?>"
                      required>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-3 offset-md-2">
                    <?php if (isset($_GET['idEdit'])) { ?>
                      <button class="btn btn-primary" name="edit" type="submit">Edit</button>
                    <?php } else { ?>
                      <button class="btn btn-primary" name="save" type="submit">Save</button>
                    <?php } ?>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </section>
  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php
  include '../inc/footer.php';
  ?>
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/vendor/quill/quill.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>