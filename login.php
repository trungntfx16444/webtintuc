<?php
require_once 'admin/connect.php';
$username = "";
$password = "";
$errors = "";

session_start();

// lam tiep sesssion
if (isset($_SESSION['flagPermission']) && $_SESSION['flagPermission'] == true) {
    if ($_SESSION['timeout'] + 30 > time()) {
        header("location: admin/list.php");
    } else {
        session_unset();
    }
}


if (!empty($_POST)) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = sprintf("SELECT * FROM `accounts` WHERE `username` = '%s' AND `password` = '%s' ", $username, md5($password));
    $resultQuery =  $database->query($query);
    if (!empty($database->getSingleRecord($resultQuery))) {
        $_SESSION['flagPermission'] = true;
        $_SESSION['timeout'] = time();
        header("location: admin/list.php");
        exit();
    } else {
        $errors = '<div class="alert alert-danger">Thông tin đăng nhập chưa đúng</div>';
    }
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <?php require_once 'html/loginHead.php' ?>
</head>

<body class="stretched">

    <!-- Document Wrapper
	============================================= -->
    <div id="wrapper" class="clearfix">

        <!-- Content
		============================================= -->
        <section id="content" class="w-100">
            <div class="content-wrap py-0">

                <div class="section p-0 m-0 h-100 position-absolute"
                    style="background: url('images/login-bg.jpg') center center no-repeat; background-size: cover;">
                </div>

                <div class="section bg-transparent min-vh-100 p-0 m-0">
                    <div class="vertical-middle">
                        <div class="container-fluid py-5 mx-auto">
                            <div class="center">
                                <h2 class="text-white">Admin</h2>
                            </div>

                            <div class="card mx-auto rounded-0 border-0"
                                style="max-width: 400px; background-color: rgba(255,255,255,0.93);">
                                <div class="card-body" style="padding: 40px;">
                                    <form id="login-form" name="login-form" class="mb-0" action="" method="post">
                                        <h3 class="text-center">Đăng nhập trang quản trị</h3>
                                        <?php echo $errors ?>
                                        <div class="row">
                                            <div class="col-12 form-group">
                                                <label for="username">Username:</label>
                                                <input type="text" id="username" name="username"
                                                    value="<?php echo $username ?>" class="form-control not-dark"
                                                    required />
                                            </div>

                                            <div class="col-12 form-group">
                                                <label for="password">Password:</label>
                                                <input type="password" id="password" name="password"
                                                    value="<?php echo $password ?>" class="form-control not-dark"
                                                    required />
                                            </div>

                                            <div class="col-12 form-group">
                                                <button type="submit" class="button button-3d button-black m-0">Đăng
                                                    nhập</button>
                                                <a href="index.php" class="button button-3d m-0">Quay về</a>
                                            </div>
                                            <div class="alert alert-success">
                                                <p class="mb-0">Test username: admin01 | password: 1234</p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="text-center dark mt-3">
                                <p>Copyrights &copy; All Rights Reserved by ZendVN
                                    Inc.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section><!-- #content end -->

    </div><!-- #wrapper end -->
    <?php require_once "html/script.php" ?>
</body>

</html>