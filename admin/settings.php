<?php
session_start();
require_once "../inc/conn.php";

// middleware
if (empty($_SESSION['Email'])) {
    header("location:../login.php");
}

$querySetting = mysqli_query($conn, "SELECT * FROM settings LIMIT 1");
$rowEdt = mysqli_fetch_assoc($querySetting);

// Jika button simpan di klik
if (isset($_POST['save'])) {
    // $namaWebsite = $_POST['nama_website'];
    // $alamatWebsite = $_POST['alamat_website'];
    // $email = $_POST['email'];
    // $telpon = $_POST['telpon'];
    // $alamat = $_POST['alamat'];
    // $logo = $_FILES['logo'];

    // jika sudah mempunyai data, maka UPDATE. Selain itu INSERT
    // CARA 1 : Tampilkan / pilih dari table setting dimana namaWebsite = 'nilai dari nama website'
    // CARA 2 : Tampilkan data terbaru dari table user
    $querySetting = mysqli_query($conn, "SELECT * FROM setting WHERE id = 1 ");
    if (mysqli_num_rows($querySetting) > 0) {
        // update
        $fillQupdate = '';
        if ($logo['error'] == 0) {
            $fileName = uniqid() . "_" . basename($logo['name']);
            $filePath = "../assets/uploads/" . $fileName;
            if (move_uploaded_file($logo['tmp_name'], $filePath)) {
                $rowLogo = $rowEdt['logo'];
                if ($rowLogo && file_exists("../assets/uploads/" . $rowLogo)) {
                    unlink("../assets/uploads/" . $rowLogo);
                } else {
                    echo "GAGAL TOTAL";
                }
            }
        }
        $fillQupdate = "logo='$fileName'";
        $update = mysqli_query($conn, "UPDATE setting SET nama_website='$namaWebsite', alamat_website='$alamatWebsite', email='$email', telpon='$telpon', alamat='$alamat' WHERE id = 1");
        header("location:setting.php?tambah=berhasil");
    } else {

        // insert
        if ($logo['error'] == 0) {
            $fileName = uniqid() . "_" . basename($logo['name']);
            $filePath = "../assets/uploads/" . $fileName;

            if (move_uploaded_file($logo['tmp_name'], $filePath)) {
                $rowLogo = $rowEdt['logo'];
                if ($rowLogo && file_exists("../assets/uploads/" . $rowLogo)) {
                    unlink("../assets/uploads/" . $rowLogo);
                } else {
                    echo "GAGAL TOTAL";
                }
                $update = mysqli_query($conn, "UPDATE setting SET nama_website='$namaWebsite', alamat_website='$alamatWebsite', email='$email', telpon='$telpon', alamat='$alamat', logo='$fileName' WHERE id = 1");
                header("location:setting.php?ubah=berhasil");

                move_uploaded_file($logo['tmp_name'], $filePath);
                $insert = mysqli_query($conn, "INSERT INTO setting (nama_website, alamat_website, email, telpon, alamat, logo) VALUES ('$namaWebsite', '$alamatWebsite', '$email', '$telpon', '$alamat', '$fileName')");
            }
        }
    }
    if (isset($_GET['idDel'])) {
        $id = $_GET['idDel'];

        $delete = mysqli_query($conn, "DELETE FROM setting WHERE id = $id");

        if ($rowEdt['logo']) {
            unlink("../assets/uploads/" . $rowEdt['logo']);
            $delete = mysqli_query($conn, "DELETE FROM setting WHERE id=$id");
            if ($delete) {
                header("location:setting.php");
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Components / Accordion - NiceAdmin Bootstrap Template</title>
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
                            <h5 class="card-title">Setting</h5>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="">Website name</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nama_website"
                                            placeholder="Input your Website Name" required
                                            value="<?= isset($_GET['tambah']) && $_GET['tambah'] == "berhasil" || isset($_GET['sidebar']) && $_GET['sidebar'] == "setting" ? $rowEdt['nama_website'] : (isset($_GET['ubah']) && $_GET['ubah'] == "berhasil" ? $rowEdt['nama_website'] : '') ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="">URL Web</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="alamat_website"
                                            placeholder="Input your Website Address" required
                                            value="<?= isset($_GET['tambah']) && $_GET['tambah'] == "berhasil" || isset($_GET['sidebar']) && $_GET['sidebar'] == "setting" ? $rowEdt['alamat_website'] : (isset($_GET['ubah']) && $_GET['ubah'] == "berhasil" ? $rowEdt['alamat_website'] : '') ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="">Email</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name="email"
                                            placeholder="youremail@gmail.com" required
                                            value="<?= isset($_GET['tambah']) && $_GET['tambah'] == "berhasil" || isset($_GET['sidebar']) && $_GET['sidebar'] == "setting" ? $rowEdt['email'] : (isset($_GET['ubah']) && $_GET['ubah'] == "berhasil" ? $rowEdt['email'] : '') ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="">Phone Number</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" name="telpon"
                                            placeholder="Input your Phone Number" required
                                            value="<?= isset($_GET['tambah']) && $_GET['tambah'] == "berhasil" || isset($_GET['sidebar']) && $_GET['sidebar'] == "setting" ? $rowEdt['telpon'] : (isset($_GET['ubah']) && $_GET['ubah'] == "berhasil" ? $rowEdt['telpon'] : '') ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="">Address</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <textarea name="alamat" class="form-control" placeholder="Input your Address"
                                            required
                                            value="<?= isset($_GET['tambah']) && $_GET['tambah'] == "berhasil" || isset($_GET['sidebar']) && $_GET['sidebar'] == "setting" ? $rowEdt['alamat'] : (isset($_GET['ubah']) && $_GET['ubah'] == "berhasil" ? $rowEdt['alamat'] : '') ?>"></textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-2">
                                        <label for="">Logo</label>
                                    </div>
                                    <div class="col-sm-10"><input type="file" name="logo" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-2 offset-md-2">
                                        <button class="btn btn-primary" name="save" type="submit">Save</button>
                                        <?php
                                        if (isset($_GET['tambah']) && $_GET['tambah'] == "berhasil" || isset($_GET['ubah']) && $_GET['ubah'] == "berhasil") {
                                        ?> <a href="setting.php?idDel=<?= $rowEdt['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger">Delete</a>
                                        <?php
                                        }
                                        ?>
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