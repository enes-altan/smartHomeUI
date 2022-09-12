<?php
include("../inc/conf.php");
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['email'])) {

    $result = $mysqli->query("SELECT * FROM " . _DATABASE_ . ".users WHERE email='" . $_SESSION['email'] . "' AND id='" . $_SESSION['id'] . "';");
    $user = $result->fetch_assoc();
    $saat = date("H.i");

    $hall_result = $mysqli->query("SELECT * FROM " . _DATABASE_ . ".dht11 WHERE room='1' ORDER BY date DESC LIMIT 1;"); #salon
    $hall = $hall_result->fetch_assoc();

    $kitchen_result = $mysqli->query("SELECT * FROM " . _DATABASE_ . ".dht11 WHERE room='2' ORDER BY date DESC LIMIT 1;"); #mutfak
    $kitchen = $kitchen_result->fetch_assoc();

    $kidsroom_result = $mysqli->query("SELECT * FROM " . _DATABASE_ . ".dht11 WHERE room='3' ORDER BY date DESC LIMIT 1;"); #çocuk odası
    $kidsroom = $kidsroom_result->fetch_assoc();

    $livingroom_result = $mysqli->query("SELECT * FROM " . _DATABASE_ . ".dht11 WHERE room='4' ORDER BY date DESC LIMIT 1;"); #oturma odası
    $livingroom = $livingroom_result->fetch_assoc();

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
            @import url('https://fonts.googleapis.com/css2?family=Marcellus&display=swap');

            .card {
                background-color: #ffffff;
                border-radius: 50px;
                color: #6f707d;
                font-family: 'Marcellus', serif;
            }

            #heading {
                font-size: 55px;
                color: #2b304d;
            }

            .temp {
                place-items: center;
            }

            .temp-details > p > span, .grey {
                color: #a3acc1;
                font-size: 12px;
            }

            *:focus {
                outline: none;
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
                            <a class="nav-link active" aria-current="page" href="<?= _BASE_ ?>/dashboard/index.php">
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
                            <a class="nav-link" href="<?= _BASE_ ?>/dashboard/lighting-sockets.php">
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
                    <h1 class="h2">Odaların Sıcaklık ve Nem Bilgileri</h1>
                    <!--
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                            <span data-feather="calendar" class="align-text-bottom"></span>
                            This week
                        </button>
                    </div>
                    -->
                </div>
                <div class="container">
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <div class="card p-5">

                                <div class="d-flex">
                                    <h6 class="flex-grow-1">Salon</h6>
                                    <h6><?=date('H:i:s',strtotime($hall['date']));?></h6>
                                </div>

                                <div class="d-flex flex-column temp mt-5 mb-3">
                                    <h1 class="mb-0 font-weight-bold" id="heading"><?=$hall['temperature'];?> &deg; C </h1>
                                </div>

                                <div class="d-flex">
                                    <div class="temp-details flex-grow-1">
                                        <!--<p class="my-1">
                                            <img src="../assets/brand/wind.png" height="17px">
                                            <span> 40 km/h  </span>
                                        </p> -->

                                        <p class="my-1">
                                            <img src="../assets/brand/moisture.jpg" height="17px" alt="humidity"/>
                                            <span> <?=$hall['humidity'];?>% </span>
                                        </p>

                                        <!--<p class="my-1">
                                            <img src="../assets/brand/temperature.png" height="17px"/>
                                            <span> 0.2h </span>
                                        </p> -->
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card p-5">

                                <div class="d-flex">
                                    <h6 class="flex-grow-1">Mutfak</h6>
                                    <h6><?=date('H:i:s',strtotime($kitchen['date']));?></h6>
                                </div>

                                <div class="d-flex flex-column temp mt-5 mb-3">
                                    <h1 class="mb-0 font-weight-bold" id="heading"><?=$kitchen['temperature'];?> &deg; C </h1>
                                </div>

                                <div class="d-flex">
                                    <div class="temp-details flex-grow-1">
                                        <!--<p class="my-1">
                                            <img src="../assets/brand/wind.png" height="17px">
                                            <span> 40 km/h  </span>
                                        </p> -->

                                        <p class="my-1">
                                            <img src="../assets/brand/moisture.jpg" height="17px" alt="humidity"/>
                                            <span> <?=$kitchen['humidity'];?>% </span>
                                        </p>

                                        <!--<p class="my-1">
                                            <img src="../assets/brand/temperature.png" height="17px"/>
                                            <span> 0.2h </span>
                                        </p> -->
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card p-5">

                                <div class="d-flex">
                                    <h6 class="flex-grow-1">Oturma Odası</h6>
                                    <h6><?=date('H:i:s',strtotime($livingroom['date']));?></h6>
                                </div>

                                <div class="d-flex flex-column temp mt-5 mb-3">
                                    <h1 class="mb-0 font-weight-bold" id="heading"><?=$livingroom['temperature'];?> &deg; C </h1>
                                </div>

                                <div class="d-flex">
                                    <div class="temp-details flex-grow-1">
                                        <!--<p class="my-1">
                                            <img src="../assets/brand/wind.png" height="17px">
                                            <span> 40 km/h  </span>
                                        </p> -->

                                        <p class="my-1">
                                            <img src="../assets/brand/moisture.jpg" height="17px" alt="humidity"/>
                                            <span> <?=$livingroom['humidity'];?>% </span>
                                        </p>

                                        <!--<p class="my-1">
                                            <img src="../assets/brand/temperature.png" height="17px"/>
                                            <span> 0.2h </span>
                                        </p> -->
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card p-5">

                                <div class="d-flex">
                                    <h6 class="flex-grow-1">Çocuk Odası</h6>
                                    <h6><?=date('H:i:s',strtotime($kidsroom['date']));?></h6>
                                </div>

                                <div class="d-flex flex-column temp mt-5 mb-3">
                                    <h1 class="mb-0 font-weight-bold" id="heading"><?=$kidsroom['temperature'];?> &deg; C </h1>
                                </div>

                                <div class="d-flex">
                                    <div class="temp-details flex-grow-1">
                                        <!--<p class="my-1">
                                            <img src="../assets/brand/wind.png" height="17px">
                                            <span> 40 km/h  </span>
                                        </p> -->

                                        <p class="my-1">
                                            <img src="../assets/brand/moisture.jpg" height="17px" alt="humidity"/>
                                            <span> <?=$kidsroom['humidity'];?>% </span>
                                        </p>

                                        <!--<p class="my-1">
                                            <img src="../assets/brand/temperature.png" height="17px"/>
                                            <span> 0.2h </span>
                                        </p> -->
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
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
