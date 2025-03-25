<?php
session_start();
require_once '../inc/conn.php';

if (isset($_POST['save'])) {
    $fullname = $_POST['fullname'];
    $title = $_POST['title'];
    $birthday = $_POST['birthday'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $email = $_POST['email'];
    $about_self = $_POST['about_self'];
    $freelance = $_POST['freelance'];

    $photo_profile = $_FILES['photo_profile'];
    if ($photo_profile['error'] == 0) {
        $fileName = uniqid() . "_" . basename($photo_profile['name']);
        $filePath = "../assets/uploads/" . $fileName;
        move_uploaded_file($photo_profile['tmp_name'], $filePath);

        $insert = mysqli_query($conn, "INSERT INTO about (fullname, title, birthday, phone, city, email, about_self, freelance, photo_profile) VALUES ('$fullname', '$title', '$birthday', '$phone', '$city', '$email', '$about_self', '$freelance', '$fileName')");
        if ($insert) {
            header("location:about.php");
        } else {
            header("location:add-about.php");
        }
    }
}

if (isset($_GET['idEdit'])) {
    $id = $_GET['idEdit'];
    $showAbout = mysqli_query($conn, "SELECT * FROM about WHERE id = '$id'");
    $row = mysqli_fetch_assoc($showAbout);
}

if (isset($_POST['edit'])) {
    $fullname = $_POST['fullname'];
    $title = $_POST['title'];
    $birthday = $_POST['birthday'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $email = $_POST['email'];
    $about_self = $_POST['about_self'];
    $freelance = $_POST['freelance'];


    if (file_exists("../assets/uploads/" . $row['photo_profile'])) {
        unlink("../assets/uploads/" . $row['photo_profile']);
    }

    if ($_FILES['photo_profile']['name'] != '') {
        $photo_profile = $_FILES['photo_profile'];
        $fileName = uniqid() . "_" . basename($photo_profile['name']);
        $filePath = "../assets/uploads/" . $fileName;
        move_uploaded_file($photo_profile['tmp_name'], $filePath);
    }

    $q_update = mysqli_query($conn, "UPDATE about SET fullname='$fullname', title='$title', birthday='$birthday', phone='$phone', city='$city', email='$email', about_self='$about_self', freelance='$freelance', photo_profile='$fileName' WHERE id='$id'");

    if ($q_update) {
        header("location:about.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ADD | EDIT Resume</title>
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
                                        <input type="file" class="form-control" name="photo_profile">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="">Fullname</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="fullname" value="<?= isset($_GET['idEdit']) ? $row['fullname'] : '' ?>"
                                            required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="">Title</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="title" value="<?= isset($_GET['idEdit']) ? $row['title'] : '' ?>"
                                            required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="">Birthday</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" name="birthday" value="<?= isset($_GET['idEdit']) ? $row['birthday'] : '' ?>"
                                            required>
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
                                        <label for="">City</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="city" value="<?= isset($_GET['idEdit']) ? $row['city'] : '' ?>"
                                            required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="">Email</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="email" value="<?= isset($_GET['idEdit']) ? $row['email'] : '' ?>"
                                            required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="">About Self</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <textarea name="about_self" id="" class="form-control" value="<?= isset($_GET['idEdit']) ? $row['about_self'] : '' ?>"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="">Available</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select name="freelance" id="" class="form-control">
                                            <option value="<?= isset($_GET['idEdit']) ? $row['freelance'] : '' ?>">Choose Option</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>

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