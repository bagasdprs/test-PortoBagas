<?php
session_start();
require_once '../inc/conn.php';

if (isset($_POST['save'])) {
    $job_title = $_POST['job_title'];
    $company_name = $_POST['company_name'];
    $employment_type = $_POST['employment_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $job_desc = $_POST['job_desc'];

    $insert = mysqli_query($conn, "INSERT INTO professional_exp (job_title, company_name, employment_type, start_date, end_date, job_desc) 
    VALUES ('$job_title', '$company_name', '$employment_type', '$start_date', '$end_date', '$job_desc')");
    if ($insert) {
        header("location:professional-exp.php");
    } else {
        header("location:add-professional-exp.php");
    }
}

if (isset($_GET['idEdit'])) {
    $id = $_GET['idEdit'];

    $showExperience = mysqli_query($conn, "SELECT * FROM professional_exp WHERE id = '$id'");
    $row = mysqli_fetch_assoc($showExperience);
}

if (isset($_POST['edit'])) {
    $job_title = $_POST['job_title'];
    $company_name = $_POST['company_name'];
    $employment_type = $_POST['employment_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $job_desc = $_POST['job_desc'];

    $q_update = mysqli_query($conn,  "UPDATE professional_exp SET job_title = '$job_title', company_name = '$company_name', employment_type = '$employment_type', start_date = '$start_date', end_date = '$end_date', job_desc = '$job_desc' WHERE id = '$id'");
    if ($q_update) {
        header("location:professional-exp.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Add Experience</title>
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
                                            <label for="">Job Title</label>
                                        </div>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="job_title" value="<?= isset($_GET['idEdit']) ? $row['job_title'] : '' ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-2">
                                            <label for="">Company Name</label>
                                        </div>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="company_name" value="<?= isset($_GET['idEdit']) ? $row['company_name'] : '' ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-2">
                                            <label for="">Type</label>
                                        </div>
                                        <div class="col-sm-10">
                                            <select name="employment_type" id="" class="form-control">
                                                <option value="0" selected>Choose category</option>
                                                <option value="1">Fulltime</option>
                                                <option value="2">Intership</option>
                                                <option value="3">Part-Time</option>
                                                <option value="4">Contract</option>
                                                <option value="5">Freelance</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-2">
                                            <label for="">Start of Date</label>
                                        </div>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" name="start_date" value="<?= isset($_GET['idEdit']) ? $row['start_date'] : '' ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-2">
                                            <label for="">End of Date</label>
                                        </div>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" name="end_date" value="<?= isset($_GET['idEdit']) ? $row['end_date'] : '' ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-2">
                                            <label for="">Job Description</label>
                                        </div>
                                        <div class="col-sm-10">
                                            <textarea name="job_desc" id="" class="form-control" value="<?= isset($_GET['idEdit']) ? $row['job_desc'] : '' ?>"></textarea>
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