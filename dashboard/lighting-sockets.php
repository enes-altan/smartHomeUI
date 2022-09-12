<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include("../inc/conf.php");
session_start();

//echo "1:".$saloon_led_checkhed."-".$saloon_socket_checkhed."<br>";
//echo "2:".$kitchen_led_checkhed."-".$kitchen_socket_checkhed."<br>";
//echo "3:".$kidsroom_led_checkhed."-".$kidsroom_socket_checkhed."<br>";
//echo "4:".$livingroom_led_checkhed."-".$livingroom_socket_checkhed."<br>";

if (isset($_SESSION['id']) && isset($_SESSION['email'])) {

    $result = $mysqli->query("SELECT * FROM " . _DATABASE_ . ".users WHERE email='" . $_SESSION['email'] . "' AND id='" . $_SESSION['id'] . "';");
    $user = $result->fetch_assoc();

    $result_saloon = $mysqli->query("SELECT * FROM " . _DATABASE_ . ".leds_and_sockets WHERE room='1';");
    $saloon_led_socket = $result_saloon->fetch_assoc();

    $result_kitchen = $mysqli->query("SELECT * FROM " . _DATABASE_ . ".leds_and_sockets WHERE room='2';");
    $kitchen_led_socket = $result_kitchen->fetch_assoc();

    $result_kidsroom = $mysqli->query("SELECT * FROM " . _DATABASE_ . ".leds_and_sockets WHERE room='3';");
    $kidsroom_led_socket = $result_kidsroom->fetch_assoc();

    $result_livingroom = $mysqli->query("SELECT * FROM " . _DATABASE_ . ".leds_and_sockets WHERE room='4';");
    $livingroom_led_socket = $result_livingroom->fetch_assoc();

    $saloon_led_checkhed = $saloon_led_socket['led_status'] == "ON" ? "checked" : "";
    $saloon_socket_checkhed = $saloon_led_socket['socket_status'] == "ON" ? "checked" : "";

    $kitchen_led_checkhed = $kitchen_led_socket['led_status'] == "ON" ? "checked" : "";
    $kitchen_socket_checkhed = $kitchen_led_socket['socket_status'] == "ON" ? "checked" : "";

    $kidsroom_led_checkhed = $kidsroom_led_socket['led_status'] == "ON" ? "checked" : "";
    $kidsroom_socket_checkhed = $kidsroom_led_socket['socket_status'] == "ON" ? "checked" : "";

    $livingroom_led_checkhed = $livingroom_led_socket['led_status'] == "ON" ? "checked" : "";
    $livingroom_socket_checkhed = $livingroom_led_socket['socket_status'] == "ON" ? "checked" : "";

    if (($_POST && $_POST['action'] == 'Kaydet')) {

        $date = date("Y-m-d H.i.s");

        $saloon_light = $_POST['saloon_light'] == "on" ? "ON" : "OFF";
        $saloon_socket = $_POST['saloon_socket'] == "on" ? "ON" : "OFF";

        $mysqli->query("UPDATE " . _DATABASE_ . ".leds_and_sockets SET 
        led_status = '$saloon_light',
        led_updated_date = '$date',
        socket_status = '$saloon_socket',
        socket_updated_date = '$date' 
        WHERE room='1';");

        $kitchen_light = $_POST['kitchen_light'] == "on" ? "ON" : "OFF";
        $kitchen_socket = $_POST['kitchen_socket'] == "on" ? "ON" : "OFF";

        $mysqli->query("UPDATE " . _DATABASE_ . ".leds_and_sockets SET 
        led_status = '$kitchen_light',
        led_updated_date = '$date',
        socket_status = '$kitchen_socket',
        socket_updated_date = '$date' 
        WHERE room='2';");

        $kidsroom_light = $_POST['kidsroom_light'] == "on" ? "ON" : "OFF";
        $kidsroom_socket = $_POST['kidsroom_socket'] == "on" ? "ON" : "OFF";

        $mysqli->query("UPDATE " . _DATABASE_ . ".leds_and_sockets SET 
        led_status = '$kidsroom_light',
        led_updated_date = '$date',
        socket_status = '$kidsroom_socket',
        socket_updated_date = '$date' 
        WHERE room='3';");

        $livingroom_light = $_POST['livingroom_light'] == "on" ? "ON" : "OFF";
        $livingroom_socket = $_POST['livingroom_socket'] == "on" ? "ON" : "OFF";

        $mysqli->query("UPDATE " . _DATABASE_ . ".leds_and_sockets SET 
        led_status = '$livingroom_light',
        led_updated_date = '$date',
        socket_status = '$livingroom_socket',
        socket_updated_date = '$date' 
        WHERE room='4';");

        if (!$mysqli -> error){
            echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Başarılı Bir Şekilde Kaydedildi!');
                    window.location.href='"._BASE_."/dashboard/lighting-sockets.php';
                </script>");
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
        <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="dashboard.css" rel="stylesheet">
        <style>
            .switch {
                margin: 50px auto;
                position: relative;
            }

            .switch label {
                width: 100%;
                height: 100%;
                position: relative;
                display: block;
            }

            .switch input {
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                opacity: 0;
                z-index: 100;
                position: absolute;
                width: 100%;
                height: 100%;
                cursor: pointer;
            }


            .switch.demo3 {
                width: 180px;
                height: 50px;
            }

            .switch.demo3 label {
                display: block;
                width: 100%;
                height: 100%;
                background: #a5a39d;

                box-shadow: inset 0 3px 8px 1px rgba(0, 0, 0, 0.2),
                0 1px 0 rgba(255, 255, 255, 0.5);
            }

            .switch.demo3 label:after {
                content: "";
                position: absolute;
                z-index: -1;
                top: -8px;
                right: -8px;
                bottom: -8px;
                left: -8px;
                border-radius: inherit;
                background: #ababab;
                background: -moz-linear-gradient(#f2f2f2, #ababab);
                background: -ms-linear-gradient(#f2f2f2, #ababab);
                background: -o-linear-gradient(#f2f2f2, #ababab);
                background: -webkit-gradient(linear, 0 0, 0 100%, from(#f2f2f2), to(#ababab));
                background: -webkit-linear-gradient(#f2f2f2, #ababab);
                background: linear-gradient(#f2f2f2, #ababab);
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3),
                0 1px 1px rgba(0, 0, 0, 0.25);
            }

            .switch.demo3 label i {
                display: block;
                height: 100%;
                width: 60%;
                border-radius: inherit;
                background: silver;
                position: absolute;
                z-index: 2;
                right: 40%;
                top: 0;
                background: #b2ac9e;
                background: -moz-linear-gradient(#f7f2f6, #b2ac9e);
                background: -ms-linear-gradient(#f7f2f6, #b2ac9e);
                background: -o-linear-gradient(#f7f2f6, #b2ac9e);
                background: -webkit-gradient(linear, 0 0, 0 100%, from(#f7f2f6), to(#b2ac9e));
                background: -webkit-linear-gradient(#f7f2f6, #b2ac9e);
                background: linear-gradient(#f7f2f6, #b2ac9e);
                box-shadow: inset 0 1px 0 white,
                0 0 8px rgba(0, 0, 0, 0.3),
                0 5px 5px rgba(0, 0, 0, 0.2);
            }

            .switch.demo3 label i:after {
                content: "";
                position: absolute;
                left: 15%;
                top: 25%;
                width: 70%;
                height: 50%;
                background: #d2cbc3;
                background: -moz-linear-gradient(#cbc7bc, #d2cbc3);
                background: -ms-linear-gradient(#cbc7bc, #d2cbc3);
                background: -o-linear-gradient(#cbc7bc, #d2cbc3);
                background: -webkit-gradient(linear, 0 0, 0 100%, from(#cbc7bc), to(#d2cbc3));
                background: -webkit-linear-gradient(#cbc7bc, #d2cbc3);
                background: linear-gradient(#cbc7bc, #d2cbc3);
                border-radius: inherit;
            }

            .switch.demo3 label i:before {
                content: "off";
                text-transform: uppercase;
                font-style: normal;
                font-weight: bold;
                color: rgba(0, 0, 0, 0.4);
                text-shadow: 0 1px 0 #bcb8ae, 0 -1px 0 #97958e;
                font-family: Helvetica, Arial, sans-serif;
                font-size: 24px;
                position: absolute;
                top: 50%;
                margin-top: -12px;
                right: -50%;
            }

            .switch.demo3 input:checked ~ label {
                background: #9abb82;
            }

            .switch.demo3 input:checked ~ label i {
                right: -1%;
            }

            .switch.demo3 input:checked ~ label i:before {
                content: "on";
                right: 115%;
                color: #82a06a;
                text-shadow: 0 1px 0 #afcb9b,
                0 -1px 0 #6b8659;
            }
        </style>
    </head>
    <body>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6"
           href="#"><?= $user['name'] . " " . $user['surname']; ?></a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="<?= _BASE_ ?>/sign-out/index.php">Çıkış Yap</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3 sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="<?= _BASE_ ?>/dashboard/index.php">
                                <span data-feather="thermometer" class="align-text-bottom"></span>
                                <font size="3;">Sıcaklık ve Nem</font>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= _BASE_ ?>/dashboard/gas-fired-combi-boiler.php">
                                <img src="../assets/brand/gas-boiler.png" height="17px" alt="humidity"/>
                                <font size="3;">Kombi Değerleri</font>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="<?= _BASE_ ?>/dashboard/lighting-sockets.php">
                                <img src="../assets/brand/bulb.png" height="17px" alt="humidity"/>
                                <font size="3;">Işıklar</font>
                            </a>
                        </li>
                        <!--
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="users" class="align-text-bottom"></span>
                                Customers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="bar-chart-2" class="align-text-bottom"></span>
                                Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="layers" class="align-text-bottom"></span>
                                Integrations
                            </a>
                        </li>
                        -->
                    </ul>
                    <!--
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                        <span>Saved reports</span>
                        <a class="link-secondary" href="#" aria-label="Add a new report">
                            <span data-feather="plus-circle" class="align-text-bottom"></span>
                        </a>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text" class="align-text-bottom"></span>
                                Current month
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text" class="align-text-bottom"></span>
                                Last quarter
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text" class="align-text-bottom"></span>
                                Social engagement
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text" class="align-text-bottom"></span>
                                Year-end sale
                            </a>
                        </li>
                    </ul>
                    -->
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Odaların Işık Ve Priz Durumları</h1>
                </div>
                <form name="form" action="<?= _BASE_ ?>/dashboard/lighting-sockets.php" method="post">
                    <div class="container">
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <div class="card p-5 bg-warning bg-opacity-10 text-dark">
                                    <div>
                                        <h3 align="center" class="flex-grow-1">Mutfak</h3>
                                    </div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm">
                                                <h4 align="center" class="flex-grow-1">Işık</h4>
                                                <div class="switch demo3">
                                                    <input type="checkbox"
                                                           name="kitchen_light" <?= $kitchen_led_checkhed ?>/>
                                                    <label><i></i></label>
                                                </div>
                                                <h4 align="center"><?= date('H:i:s', strtotime($kitchen_led_socket['led_updated_date'])); ?></h4>
                                            </div>
                                            <div class="col-sm">
                                                <h4 align="center" class="flex-grow-1">Priz</h4>
                                                <div class="switch demo3">
                                                    <input type="checkbox"
                                                           name="kitchen_socket" <?= $kitchen_socket_checkhed ?> />
                                                    <label><i></i></label>
                                                </div>
                                                <h4 align="center"><?= date('H:i:s', strtotime($kitchen_led_socket['socket_updated_date'])); ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card p-5 bg-warning bg-opacity-10 text-dark">
                                    <div>
                                        <h3 align="center" class="flex-grow-1">Salon</h3>
                                    </div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm">
                                                <h4 align="center" class="flex-grow-1">Işık</h4>
                                                <div class="switch demo3">
                                                    <input type="checkbox"
                                                           name="saloon_light" <?= $saloon_led_checkhed ?>/>
                                                    <label><i></i></label>
                                                </div>
                                                <h4 align="center"><?= date('H:i:s', strtotime($saloon_led_socket['led_updated_date'])); ?></h4>
                                            </div>
                                            <div class="col-sm">
                                                <h4 align="center" class="flex-grow-1">Priz</h4>
                                                <div class="switch demo3">
                                                    <input type="checkbox"
                                                           name="saloon_socket" <?= $saloon_socket_checkhed ?>/>
                                                    <label><i></i></label>
                                                </div>
                                                <h4 align="center"><?= date('H:i:s', strtotime($saloon_led_socket['socket_updated_date'])); ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card p-5 bg-warning bg-opacity-10 text-dark">
                                    <div>
                                        <h3 align="center" class="flex-grow-1">Çocuk Odası</h3>
                                    </div>
                                    <div class="container ">
                                        <div class="row">
                                            <div class="col-sm">
                                                <h4 align="center" class="flex-grow-1">Işık</h4>
                                                <div class="switch demo3">
                                                    <input type="checkbox"
                                                           name="kidsroom_light" <?= $kidsroom_led_checkhed ?>/>
                                                    <label><i></i></label>
                                                </div>
                                                <h4 align="center"><?= date('H:i:s', strtotime($kitchen_led_socket['led_updated_date'])); ?></h4>
                                            </div>
                                            <div class="col-sm">
                                                <h4 align="center" class="flex-grow-1">Priz</h4>
                                                <div class="switch demo3">
                                                    <input type="checkbox"
                                                           name="kidsroom_socket" <?= $kidsroom_socket_checkhed ?>/>
                                                    <label><i></i></label>
                                                </div>
                                                <h4 align="center"><?= date('H:i:s', strtotime($kitchen_led_socket['socket_updated_date'])); ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card p-5 bg-warning bg-opacity-10 text-dark">
                                    <div>
                                        <h3 align="center" class="flex-grow-1">Oturma Odası</h3>
                                    </div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm">
                                                <h4 align="center" class="flex-grow-1">Işık</h4>
                                                <div class="switch demo3">
                                                    <input type="checkbox"
                                                           name="livingroom_light" <?= $livingroom_led_checkhed ?> />
                                                    <label><i></i></label>
                                                </div>
                                                <h4 align="center"><?= date('H:i:s', strtotime($livingroom_led_socket['led_updated_date'])); ?></h4>
                                            </div>
                                            <div class="col-sm">
                                                <h4 align="center" class="flex-grow-1">Priz</h4>
                                                <div class="switch demo3">
                                                    <input type="checkbox"
                                                           name="livingroom_socket" <?= $livingroom_socket_checkhed ?>/>
                                                    <label><i></i></label>
                                                </div>
                                                <h4 align="center"><?= date('H:i:s', strtotime($livingroom_led_socket['socket_updated_date'])); ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container mt-4">
                        <div class="row">
                            <div class="col-sm">

                            </div>
                            <div class="col-sm">
                                <button class="w-100 btn btn-lg btn-secondary " type="submit" name="action"
                                        value="Kaydet">Kaydet
                            </div>
                            <div class="col-sm">

                            </div>
                        </div>
                    </div>
                    </button>
                </form>
            </main>
        </div>
    </div>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="../assets/dist/js/feather.min.js"
            integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE"
            crossorigin="anonymous"></script>
    <script src="../assets/dist/js/Chart.min.js"
            integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha"
            crossorigin="anonymous"></script>
    <script src="dashboard.js?v=01"></script>
    </body>
    </html>
    <?php
} else {
    header("Location: " . _BASE_ . "/sign-in/index.php?error=Lütfen Giriş Yapınız!");
}
?>
