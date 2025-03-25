<?php
session_start();
require_once "../inc/conn.php";

$experience = mysqli_query($conn, "SELECT * FROM professional_exp");
$rows = mysqli_fetch_all($experience, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($conn, "DELETE FROM professional_exp WHERE id = '$id'");
    if ($delete) {
        header('location:professional-exp.php?hapus=success');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Portfolio | Professional Experience</title>
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
                            <h5 class="card-title">Experience Data</h5>
                            <div class="table table-responsive">
                                <a href="add-professional-exp.php" class="btn btn-primary mb-2">Create</a>
                                <table class="table table-bordered text-center" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Job Title</th>
                                            <th>Company Name</th>
                                            <th>Type of Employee</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Job Description</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($rows as $row) {
                                        ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row['job_title'] ?></td>
                                                <td><?= $row['company_name'] ?></td>

                                                <td><?php
                                                    if ($row['employment_type'] == 'Fulltime') {
                                                        echo "<span class='badge bg-primary'>Fulltime</span>";
                                                    } elseif ($row['employment_type'] == 'Internship') {
                                                        echo "<span class='badge bg-warning'>Internship</span>";
                                                    } elseif ($row['employment_type'] == 'Part-time') {
                                                        echo "<span class='badge bg-info'>Part-time</span>";
                                                    } elseif ($row['employment_type'] == 'Contract') {
                                                        echo "<span class='badge bg-light'>Contract</span>";
                                                    } elseif ($row['employment_type'] == 'Freelance') {
                                                        echo "<span class='badge bg-secondary'>Freelance</span>";
                                                    } else {
                                                        echo "<span class='badge bg-warning'>''</span>";
                                                    } ?>
                                                    <!-- <span class='badge bg-primary'>Fulltime</span> -->
                                                    <!-- // switch ($row['employment_type']) {
                                                // case '1':
                                                // $label = "<span class='badge bg-primary'>Fulltime</span>";
                                                // break;
                                                // case '2':
                                                // $label = "<span class='badge bg-warning'>Internship</span>";
                                                // break;
                                                // case '3':
                                                // $label = "<span class='badge bg-info'>Part-time</span>";
                                                // break;
                                                // case '4':
                                                // $label = "<span class='badge bg-light'>Contract</span>";
                                                // break;
                                                // case '5':
                                                // $label = "<span class='badge bg-secondary'>Freelance</span>";
                                                // break;
                                                // default:
                                                // $label = "<span class='badge bg-danger'>Nothing</span>";
                                                // break;
                                                // } -->
                                                </td>
                                                <td><?= $row['start_date'] ?></td>
                                                <td><?= $row['end_date'] ?></td>
                                                <td><?= $row['job_desc'] ?></td>
                                                <td>
                                                    <a href="add-professional-exp.php?idEdit=<?= $row['id'] ?>" class="btn btn-success btn-sm">Edit</a>
                                                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are u sure delete this one?')" class="btn btn-danger btn-sm">Delete</a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
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