<?php
session_start();
require_once '../inc/conn.php';

if (isset($_POST['save'])) {
    $services_name = $_POST['services_name'];
    $desc_serv = $_POST['desc_serv'];

    $photo = $_FILES['photo'];

    if ($photo['error'] == 0) {
        $fileName = uniqid() . "_" . basename($photo['name']);
        $filePath = "../assets/uploads/" . $fileName;
        move_uploaded_file($photo['tmp_name'], $filePath);

        $insert = mysqli_query($conn, "INSERT INTO services (photo, services_name, desc_serv) VALUES ('$fileName', '$services_name', '$desc_serv')");
        if ($insert) {
            header("location:services.php");
        } else {
            header("location:add-services.php");
        }
    }
}


if (isset($_GET['idEdit'])) {
    $id = $_GET['idEdit'];
    $showServices = mysqli_query($conn, "SELECT * FROM services WHERE id = '$id'");
    $row = mysqli_fetch_assoc($showServices);
}

if (isset($_POST['edit'])) {
    $services_name = $_POST['services_name'];
    $desc_serv = $_POST['desc_serv'];
    $photo = $_FILES['photo'];
    if (file_exists("../assets/uploads/" . $row['photo'])) {
        unlink("../assets/uploads/" . $row['photo']);
    }

    if ($photo['error'] == 0) {
        $fileName = uniqid() . "_" . basename($photo['name']);
        $filePath = "../assets/uploads/" . $fileName;
        move_uploaded_file($photo['tmp_name'], $filePath);
    }

    $q_update = mysqli_query($conn, "UPDATE services SET photo='$fileName', services_name='$services_name', desc_serv='$desc_serv' WHERE id='$id'");

    if ($q_update) {
        header("location:services.php");
    }
}

// if (isset($_POST['edit'])) {
//     $id = $_GET['edit'];
//     $services_name = $_POST['services_name'];
//     $desc_serv = $_POST['desc_serv'];
//     $photo = $_FILES['photo'];
// }



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Services Data</title>
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
                                        <label for="">Photo</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="photo">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="">Services Name</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="services_name" value="<?= isset($_GET['idEdit']) ? $row['services_name'] : '' ?>"
                                            required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="">Description</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <textarea name="desc_serv" id="" class="form-control" value="<?= isset($_GET['idEdit']) ? $row['desc_serv'] : '' ?>"></textarea>
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