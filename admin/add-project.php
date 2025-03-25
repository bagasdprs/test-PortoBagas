<?php
session_start();
require_once '../inc/conn.php';

if (isset($_POST['save'])) {
    $name_project = $_POST['name_project'];
    $subtitle = $_POST['subtitle'];
    $content = $_POST['content'];
    $client_name = $_POST['client_name'];
    $url_project = $_POST['url_project'];
    $project_date = $_POST['project_date'];

    $photo = $_FILES['photo'];
    if ($photo['error'] == 0) {
        $fileName = uniqid() . "_" . basename($photo['name']);
        $filePath = "../assets/uploads/" . $fileName;
        move_uploaded_file($photo['tmp_name'], $filePath);
        $insert = mysqli_query($conn, "INSERT INTO projects (name_project, photo, subtitle, content, client_name, url_project, project_date) 
        VALUES ('$name_project', '$fileName', '$subtitle', '$content', '$client_name', '$url_project', '$project_date')");
        if ($insert) {
            header("location:project.php");
        } else {
            header("location:add-project.php");
        }
    }
}

if (isset($_GET['idEdit'])) {
    $id = $_GET['idEdit'];
    $showProject = mysqli_query($conn, "SELECT * FROM projects WHERE id = '$id'");
    $row = mysqli_fetch_assoc($showProject);
}

if (isset($_POST['edit'])) {
    $name_project = $_POST['name_project'];
    $subtitle = $_POST['subtitle'];
    $content = $_POST['content'];
    $client_name = $_POST['client_name'];
    $url_project = $_POST['url_project'];
    $project_date = $_POST['project_date'];

    if (file_exists("../assets/uploads/" . $row['photo_profile'])) {
        unlink("../assets/uploads/" . $row['photo_profile']);
    }

    if ($_FILES['photo']['name'] != '') {
        $photo = $_FILES['photo'];
        $fileName = uniqid() . "_" . basename($photo['name']);
        $filePath = "../assets/uploads/" . $fileName;
        move_uploaded_file($photo['tmp_name'], $filePath);
    }

    $q_update = mysqli_query($conn, "UPDATE projects SET 
        name_project = '$name_project', 
        photo = '$fileName',
        subtitle = '$subtitle', 
        content = '$content', 
        client_name = '$client_name', 
        url_project = '$url_project', 
        project_date = '$project_date' 
        WHERE id = '$id'");
    if ($q_update) {
        header("location:project.php");
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
                                            <label for="">Project Name</label>
                                        </div>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="name_project" value="<?= isset($_GET['idEdit']) ? $row['name_project'] : '' ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-2">
                                            <label for="">Photo</label>
                                        </div>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control" name="photo" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-2">
                                            <label for="">Subtitle</label>
                                        </div>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="subtitle" value="<?= isset($_GET['idEdit']) ? $row['subtitle'] : '' ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-2">
                                            <label for="">Content</label>
                                        </div>
                                        <div class="col-sm-10">
                                            <textarea name="content" id="" class="form-control" value="<?= isset($_GET['idEdit']) ? $row['content'] : '' ?>"
                                                required></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-2">
                                            <label for="">Client Name</label>
                                        </div>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="client_name" value="<?= isset($_GET['idEdit']) ? $row['client_name'] : '' ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-2">
                                            <label for="">URL Project</label>
                                        </div>
                                        <div class="col-sm-10">
                                            <input type="url" class="form-control" name="url_project" value="<?= isset($_GET['idEdit']) ? $row['url_project'] : '' ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-2">
                                            <label for="">Project Date</label>
                                        </div>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" name="project_date" value="<?= isset($_GET['idEdit']) ? $row['project_date'] : '' ?>"
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