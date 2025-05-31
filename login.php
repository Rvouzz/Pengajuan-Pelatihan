<?php
include 'koneksi.php';
session_start();

// Cek auto-login via cookie
if (isset($_COOKIE['nik']) && isset($_COOKIE['password'])) {
    $nik = mysqli_real_escape_string($koneksi, $_COOKIE['nik']);
    $cookie_password = $_COOKIE['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM mst_users WHERE nik = '$nik' LIMIT 1");

    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);

        // Verifikasi password hash sha512
        if (hash('sha512', $row['password']) === $cookie_password) {
            $_SESSION['nik'] = $row['nik'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['level'] = $row['level'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['email'] = $row['email'];

            switch ($row['level']) {
                case 'dosen':
                    header("Location: Dosen/dashboard_dosen.php");
                    exit();
                case 'kpj':
                    header("Location: Kpj/dashboard_kpj.php");
                    exit();
                case 'kunit':
                    header("Location: K.unit/dashboard_k.unit.php");
                    exit();
                case 'staff':
                    header("Location: Staffadmin/dashboard.php");
                    exit();
                default:
                    echo "Role tidak valid.";
                    exit();
            }
        }
    }
}

// Jika session sudah login
if (isset($_SESSION['nik']) && isset($_SESSION['level'])) {
    switch ($_SESSION['level']) {
        case 'dosen':
            header("Location: Dosen/dashboard_dosen.php");
            exit();
        case 'kpj':
            header("Location: Kpj/dashboard_kpj.php");
            exit();
        case 'kunit':
            header("Location: K.unit/dashboard_k.unit.php");
            exit();
        case 'staff':
            header("Location: Staffadmin/dashboard.php");
            exit();
        default:
            echo "Role tidak valid.";
            exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="./assets/img/icon.ico" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="./assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: { "families": ["Lato:300,400,700,900"] },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ['./assets/css/fonts.min.css']
            },
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/atlantis.css">
</head>

<body class="login">
    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn">
            <h3 class="text-center">Sign In</h3>

            <?php if (isset($_SESSION['login_error'])): ?>
                <div class="alert alert-danger text-center">
                    <?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="proses/proses_login.php">
                <div class="login-form">
                    <div class="form-group form-floating-label">
                        <input id="nik" name="nik" type="text" class="form-control input-border-bottom" required>
                        <label for="nik" class="placeholder">NIK</label>
                    </div>
                    <div class="form-group form-floating-label">
                        <input id="password" name="password" type="password" class="form-control input-border-bottom" required>
                        <label for="password" class="placeholder">Password</label>
                        <div class="show-password">
                            <i class="icon-eye"></i>
                        </div>
                    </div>
                    <div class="row form-sub m-0">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="rememberMe" id="rememberme">
                            <label class="custom-control-label" for="rememberme">Remember Me</label>
                        </div>
                        <a href="#" class="link float-right">Forget Password ?</a>
                    </div>
                    <div class="form-action mb-3">
                        <button type="submit" class="btn btn-primary btn-rounded btn-login">Sign In</button>
                    </div>
                    <div class="login-account">
                        <span class="msg">Don't have an account yet?</span>
                        <a href="#" class="link">Sign Up</a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sign Up container (kosong jika tidak dipakai) -->
        <div class="container container-signup animated fadeIn">
            <h3 class="text-center">Sign Up</h3>
            <div class="login-form">
                <div class="form-group form-floating-label">
                    <input id="fullname" name="fullname" type="text" class="form-control input-border-bottom" required>
                    <label for="fullname" class="placeholder">Fullname</label>
                </div>
                <div class="form-group form-floating-label">
                    <input id="email" name="email" type="email" class="form-control input-border-bottom" required>
                    <label for="email" class="placeholder">Email</label>
                </div>
                <div class="form-group form-floating-label">
                    <input id="passwordsignin" name="passwordsignin" type="password" class="form-control input-border-bottom" required>
                    <label for="passwordsignin" class="placeholder">Password</label>
                    <div class="show-password">
                        <i class="icon-eye"></i>
                    </div>
                </div>
                <div class="form-group form-floating-label">
                    <input id="confirmpassword" name="confirmpassword" type="password" class="form-control input-border-bottom" required>
                    <label for="confirmpassword" class="placeholder">Confirm Password</label>
                    <div class="show-password">
                        <i class="icon-eye"></i>
                    </div>
                </div>
                <div class="row form-sub m-0">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="agree" id="agree">
                        <label class="custom-control-label" for="agree">I Agree the terms and conditions.</label>
                    </div>
                </div>
                <div class="form-action">
                    <a href="#" id="show-signin" class="btn btn-danger btn-link btn-login mr-3">Cancel</a>
                    <a href="#" class="btn btn-primary btn-rounded btn-login">Sign Up</a>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Files -->
    <script src="./assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="./assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="./assets/js/core/popper.min.js"></script>
    <script src="./assets/js/core/bootstrap.min.js"></script>
    <script src="./assets/js/atlantis.min.js"></script>
</body>

</html>
