<?php
include("../inc/conf.php");

if (($_POST && $_POST['action'] == 'Giriş Yap')){


    $email = form_security_control($_POST['email']);
    $password = form_security_control($_POST['password']);

    if (!($email && $password)) {
        header("Location: "._BASE_."/sign-in/index.php?error=Email veya Parola Boş Bırakılamaz!");
        exit;
    }

    $result = $mysqli->query("SELECT * FROM " . _DATABASE_ . ".users WHERE email='".$email."' AND password='".sha1($password)."';");

    if ($result->num_rows == 1) {
       #Bilgiler Doğru , Giriş Yapıldı!

        $user = $result->fetch_assoc();
        session_start();
        $_SESSION['email'] = $user['email'];
        //$_SESSION['name'] = $user['password'];
        $_SESSION['id'] = $user['id'];
        setcookie('PHPSESSID', session_id(), ['httponly' => true]);
        header("Location: "._BASE_."/dashboard/index.php");
        exit();
    } else {
        header("Location: "._BASE_."/sign-in/index.php?error=Kullanıcı Bulunamadı!<br>Lütfen Email Adresinizi ve Parolanızı Kontrol Ediniz!");
        exit();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.101.0">
    <title>Smart Home - Control UI</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">

    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
</head>
<body class="text-center">

<main class="form-signin w-100 m-auto">
    <form name="loginForm" method="post" action="<?=_BASE_?>/sign-in/index.php">
        <img class="mb-4" src="../assets/brand/sign-in-logo.png" alt="" width="150" height="150">
        <h1 class="h3 mb-3 fw-normal">Giriş Yap</h1>

        <?php if (isset($_GET['error'])) {?>
        <div class="alert alert-danger" role="alert">
            <?=$_GET['error'];?>
        </div>
        <?php } ?>
        <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email"/>
            <label for="floatingInput">Email</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password"
                   autocomplete="off">
            <label for="floatingPassword">Parola</label>
        </div>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Beni Hatırla
            </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit" name="action" value="Giriş Yap">Giriş Yap</button>
        <p class="mt-5 mb-3 text-muted"><?= _PAKET_VERSION_; ?>&copy;<?= date("Y"); ?></p>
    </form>
</main>
</body>
</html>
