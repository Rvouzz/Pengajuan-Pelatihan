<?php
include '../koneksi.php';
session_start();

$nik = $_POST['nik'];
$password = $_POST['password'];

// Cek koneksi
if (!$koneksi) {
    die("Gagal koneksi: " . mysqli_connect_error());
}

// Ambil user dari database
$sql = "SELECT * FROM mst_users WHERE nik = '$nik' LIMIT 1";
$result = mysqli_query($koneksi, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $hashedPassword = $row['password'];

    // Verifikasi password
    if (password_verify($password, $hashedPassword)) {
        // Set cookie jika Remember Me dicentang
        if (isset($_POST['rememberme'])) {
            setcookie('nik', $nik, time() + (86400 * 30), '/'); // 30 hari
            setcookie('password', hash('sha512', $password), time() + (86400 * 30), '/');
        }

        // Cek role user
        if ($row['role'] === 'User') {
            $_SESSION['login_error'] = "Permission denied. You do not have access.";
            header("Location: ../dashboard/login.php");
            exit();
        }

        // Login sukses
        $_SESSION['nik'] = $row['nik'];
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['level'] = $row['level'];
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['email'] = $row['email'];

        // Arahkan sesuai role
        switch ($row['level']) {
            case 'dosen':
                header("Location: ../Dosen/dashboard_dosen.php");
                break;
            case 'kpj':
                header("Location: ../Kpj/dashboard_kpj.php");
                break;
            case 'kunit':
                header("Location: ../K.unit/dashboard_k.unit.php");
                break;
            case 'staff':
                header("Location: ../Staffadmin/dashboard.php");
                break;
            default:
                $_SESSION['login_error'] = "Role tidak valid.";
                header("Location: ../dashboard/login.php");
                break;
        }
        exit();
    }
}

// Jika gagal login
$_SESSION['login_error'] = "NIK atau Password salah.";
header("Location: ../login.php");
exit();

?>
