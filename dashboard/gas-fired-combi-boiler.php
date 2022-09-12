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
            * {
                border: 0;
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }
            
            .temp {
                --angle: 0deg;
                background-color: var(--l3);
                border-radius: 3em;
                box-shadow: 0 0.25em 0.5em hsla(0,0%,0%,0.1);
                display: flex;
                flex-direction: column;
                justify-content: center;
                margin: 1.5em 0;
                padding: 2em;
                width: 16em;
                height: 28.4em;
            }
            .temp__dial,
            .temp__dial-core,
            .temp__dial-shades,
            .temp__shade-cold,
            .temp__shade-hot,
            .temp__drag,
            .temp__drag:before {
                border-radius: 50%;
            }
            .temp__dial {
                box-shadow:
                        0.5em 0.5em 1em var(--l6),
                        -0.5em -0.5em 1em var(--l1);
                margin-bottom: 2.5em;
                position: relative;
                width: 12em;
                height: 12em;
            }
            .temp__dial-core,
            .temp__dial-shades,
            .temp__shade-cold,
            .temp__shade-hot,
            .temp__value,
            .temp__drag,
            .temp__drag:before {
                position: absolute;
            }
            .temp__dial-core,
            .temp__dial-shades,
            .temp__value,
            .temp__drag:before {
                top: 50%;
                left: 50%;
            }
            .temp__dial-core,
            .temp__dial-shades,
            .temp__value {
                transform: translate(-50%,-50%);
            }
            .temp__dial-core,
            .temp__dial-shades,
            .temp__value {
                transition: all 0.2s ease-in-out;
            }
            .temp__dial-core,
            .temp__dial-shades {
                transition-delay: 0.1s;
                width: 8.5rem;
                height: 8.5rem;
            }
            .temp__dial-core {
                box-shadow: 0 0.2rem 0.5rem 0.1rem inset;
                color: hsla(0,0%,0%,0.1);
            }
            .temp__dial-shades,
            .temp__drag:before {
                opacity: 0;
            }
            .temp__shade-cold,
            .temp__shade-hot,
            .temp__drag {
                width: 100%;
                height: 100%;
            }
            .temp__shade-cold {
                background-image: radial-gradient(100% 100% at 50% 100%,hsl(193,90%,55%),hsl(268,90%,55%));
            }
            .temp__shade-hot {
                background-image: radial-gradient(100% 100% at 50% 100%,hsl(63,90%,55%),hsl(13,90%,45%));
            }
            .temp__drag {
                cursor: grab;
                z-index: 1;
            }
            .temp__drag:active,
            .temp__drag--active {
                cursor: grabbing;
            }
            .temp__drag:active ~ .temp__dial-core,
            .temp__drag--active ~ .temp__dial-core,
            .temp__drag:active ~ .temp__dial-shades,
            .temp__drag--active ~ .temp__dial-shades {
                transition-delay: 0s;
                width: 6em;
                height: 6em;
            }
            .temp__drag:active ~ .temp__dial-core,
            .temp__drag--active ~ .temp__dial-core {
                color: hsla(0,0%,0%,0.3);
            }
            .temp__drag:before {
                background: linear-gradient(145deg,var(--l5),var(--l1));
                content: "";
                display: block;
                top: 50%;
                left: 50%;
                width: 2em;
                height: 2em;
                transform: translate(-50%,-50%) translateY(4.5em) rotate(calc(-1 * var(--angle)));
                transition: opacity 0.2s ease-in-out;
            }
            .temp__drag:active:before,
            .temp__drag--active:before,
            .temp__drag:active ~ .temp__dial-shades,
            .temp__drag--active ~ .temp__dial-shades {
                opacity: 1;
            }
            .temp__drag:active:before,
            .temp__drag--active:before {
                transition-delay: 0.1s;
            }
            .temp__drag:active ~ .temp__value,
            .temp__drag--active ~ .temp__value {
                color: hsl(223,10%,100%);
            }
            .temp__value {
                font-size: 2.5em;
                font-weight: bold;
                text-align: right;
                width: 3ch;
            }
            .temp__digit {
                display: inline-block;
            }
            .temp__digit--inc {
                animation: digitA 0.15s linear, digitB 0.15s 0.15s linear;
            }
            .temp__digit--dec {
                animation: digitB 0.15s linear reverse, digitA 0.15s 0.15s linear reverse;
            }
            .temp__heading {
                font-size: 0.5em;
                letter-spacing: 0.2em;
                text-transform: uppercase;
            }
            .temp__outdoors {
                background-color: var(--l4);
                border-radius: 0.75em;
                box-shadow:
                        0 0.1em 0.1em var(--l5) inset,
                        0 -0.1em 0.1em var(--l2) inset;
                display: flex;
                justify-content: space-between;
                padding: 0.75em 1.75em;
                text-align: center;
            }
            .temp__o-value {
                font-size: 1.5em;
            }

            /* Dark theme */
            @media (prefers-color-scheme: dark) {
                :root {
                    --l1: hsl(223,10%,50%);
                    --l2: hsl(223,10%,45%);
                    --l3: hsl(223,10%,40%);
                    --l4: hsl(223,10%,35%);
                    --l5: hsl(223,10%,30%);
                    --l6: hsl(223,10%,25%);
                    --text: hsl(223,10%,80%);
                }
            }

            /* Animations */
            @keyframes digitA {
                from {
                    opacity: 1;
                    transform: translateY(0);
                }
                to {
                    opacity: 0;
                    transform: translateY(-25%);
                }
            }
            @keyframes digitB {
                from {
                    opacity: 0;
                    transform: translateY(25%);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
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
                            <a class="nav-link active" href="<?= _BASE_ ?>/dashboard/gas-fired-combi-boiler.php">
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
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Kombi</h1>
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
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4">
                            <div class="temp">
                                <div class="temp__dial">
                                    <div class="temp__drag"></div>
                                    <div class="temp__dial-shades">
                                        <div class="temp__shade-cold"></div>
                                        <div class="temp__shade-hot"></div>
                                    </div>
                                    <div class="temp__dial-core"></div>
                                    <div class="temp__value">
                                        <span class="temp__digit">6</span><span class="temp__digit">0</span>°
                                    </div>
                                </div>
                                <div class="temp__outdoors">
                                    <div class="temp__outdoors-col">
                                        <small class="temp__heading">Outside</small>
                                        <br>
                                        <span class="temp__o-value">0°</span>
                                    </div>
                                    <div class="temp__outdoors-col">
                                        <small class="temp__heading">Humidity</small>
                                        <br>
                                        <span class="temp__o-value">0%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">

                        </div>
                    </div>
                </div>
                <!--
                <h2>Section title</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Header</th>
                            <th scope="col">Header</th>
                            <th scope="col">Header</th>
                            <th scope="col">Header</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1,001</td>
                            <td>random</td>
                            <td>data</td>
                            <td>placeholder</td>
                            <td>text</td>
                        </tr>
                        <tr>
                            <td>1,002</td>
                            <td>placeholder</td>
                            <td>irrelevant</td>
                            <td>visual</td>
                            <td>layout</td>
                        </tr>
                        <tr>
                            <td>1,003</td>
                            <td>data</td>
                            <td>rich</td>
                            <td>dashboard</td>
                            <td>tabular</td>
                        </tr>
                        <tr>
                            <td>1,003</td>
                            <td>information</td>
                            <td>placeholder</td>
                            <td>illustrative</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>1,004</td>
                            <td>text</td>
                            <td>random</td>
                            <td>layout</td>
                            <td>dashboard</td>
                        </tr>
                        <tr>
                            <td>1,005</td>
                            <td>dashboard</td>
                            <td>irrelevant</td>
                            <td>text</td>
                            <td>placeholder</td>
                        </tr>
                        <tr>
                            <td>1,006</td>
                            <td>dashboard</td>
                            <td>illustrative</td>
                            <td>rich</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>1,007</td>
                            <td>placeholder</td>
                            <td>tabular</td>
                            <td>information</td>
                            <td>irrelevant</td>
                        </tr>
                        <tr>
                            <td>1,008</td>
                            <td>random</td>
                            <td>data</td>
                            <td>placeholder</td>
                            <td>text</td>
                        </tr>
                        <tr>
                            <td>1,009</td>
                            <td>placeholder</td>
                            <td>irrelevant</td>
                            <td>visual</td>
                            <td>layout</td>
                        </tr>
                        <tr>
                            <td>1,010</td>
                            <td>data</td>
                            <td>rich</td>
                            <td>dashboard</td>
                            <td>tabular</td>
                        </tr>
                        <tr>
                            <td>1,011</td>
                            <td>information</td>
                            <td>placeholder</td>
                            <td>illustrative</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>1,012</td>
                            <td>text</td>
                            <td>placeholder</td>
                            <td>layout</td>
                            <td>dashboard</td>
                        </tr>
                        <tr>
                            <td>1,013</td>
                            <td>dashboard</td>
                            <td>irrelevant</td>
                            <td>text</td>
                            <td>visual</td>
                        </tr>
                        <tr>
                            <td>1,014</td>
                            <td>dashboard</td>
                            <td>illustrative</td>
                            <td>rich</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>1,015</td>
                            <td>random</td>
                            <td>tabular</td>
                            <td>information</td>
                            <td>text</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                -->
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
    <script>
        document.addEventListener("DOMContentLoaded",function(){
            const thermostat = new NeuThermostat(".temp");
        });

        class NeuThermostat {
            constructor(el) {
                this.el = document.querySelector(el);
                this.temp = 60;
                this.tempMin = 60;
                this.tempMax = 90;
                this.angleMin = 15;
                this.angleMax = 345;
                this.outside = this.randInt(60,75);
                this.humidity = this.randInt(70,90);
                this.init();
            }
            init() {
                window.addEventListener("keydown",this.kbdEvent.bind(this));
                window.addEventListener("keyup",this.activeState.bind(this));

                // hard limits
                if (this.tempMin < 0)
                    this.tempMin = 0;

                if (this.tempMax > 99)
                    this.tempMax = 99;

                if (this.angleMin < 0)
                    this.angleMin = 0;

                if (this.angleMax > 360)
                    this.angleMax = 360;

                // init values
                this.tempAdjust(this.temp);
                this.outdoorsAdjust(this.outside,this.humidity);

                // init GreenSock Draggable
                Draggable.create(".temp__drag",{
                    type: "rotation",
                    bounds: {
                        minRotation: this.angleMin,
                        maxRotation: this.angleMax
                    },
                    onDrag: () => {
                        this.tempAdjust("drag");
                    }
                });
            }
            angleFromMatrix(transVal) {
                let matrixVal = transVal.split('(')[1].split(')')[0].split(','),
                    [cos1,sin] = matrixVal.slice(0,2),
                    angle = Math.round(Math.atan2(sin,cos1) * (180 / Math.PI)) * -1;

                // convert negative angles to positive
                if (angle < 0)
                    angle += 360;

                if (angle > 0)
                    angle = 360 - angle;

                return angle;
            }
            randInt(min,max) {
                return Math.round(Math.random() * (max - min)) + min;
            }
            kbdEvent(e) {
                let kc = e.keyCode;

                if (kc) {
                    // up or right
                    if (kc == 38 || kc == 39)
                        this.tempAdjust("u");

                    // left or down
                    else if (kc == 37 || kc == 40)
                        this.tempAdjust("d");
                }
            }
            activeState(shouldAdd = false) {
                if (this.el) {
                    let dragClass = "temp__drag",
                        activeState = `${dragClass}--active`,
                        tempDrag = this.el.querySelector(`.${dragClass}`);

                    if (tempDrag) {
                        if (shouldAdd === true)
                            tempDrag.classList.add(activeState);
                        else
                            tempDrag.classList.remove(activeState);
                    }
                }
            }
            removeClass(el,classname) {
                el.classList.remove(classname);
            }
            changeDigit(el,digit) {
                el.textContent = digit;
            }
            tempAdjust(inputVal = 0) {
                /*
                inputVal can be the temp as an integer, "u" for up,
                "d" for down, or "drag" for dragged value
                */
                if (this.el) {
                    let cs = window.getComputedStyle(this.el),
                        tempDigitEls = this.el.querySelectorAll(".temp__digit"),
                        tempDigits = tempDigitEls ? Array.from(tempDigitEls).reverse() : [],
                        tempDrag = this.el.querySelector(".temp__drag"),
                        cold = this.el.querySelector(".temp__shade-cold"),
                        hot = this.el.querySelector(".temp__shade-hot"),
                        prevTemp = Math.round(this.temp),
                        tempRange = this.tempMax - this.tempMin,
                        angleRange = this.angleMax - this.angleMin,
                        notDragged = inputVal != "drag";

                    // input is an integer
                    if (!isNaN(inputVal)) {
                        this.temp = inputVal;

                        // input is a given direction
                    } else if (inputVal == "u") {
                        if (this.temp < this.tempMax)
                            ++this.temp;

                        this.activeState(true);

                    } else if (inputVal == "d") {
                        if (this.temp > this.tempMin)
                            --this.temp;

                        this.activeState(true);

                        // Draggable was used
                    } else if (inputVal == "drag") {
                        if (tempDrag) {
                            let tempDragCS = window.getComputedStyle(tempDrag),
                                trans = tempDragCS.getPropertyValue("transform"),
                                dragAngle = this.angleFromMatrix(trans),
                                relAngle = dragAngle - this.angleMin,
                                angleFrac = relAngle / angleRange;

                            this.temp = angleFrac * tempRange + this.tempMin;
                        }
                    }

                    // keep the temperature within bounds
                    if (this.temp < this.tempMin)
                        this.temp = this.tempMin;
                    else if (this.temp > this.tempMax)
                        this.temp = this.tempMax;

                    // use whole number temperatures for keyboard control
                    if (notDragged)
                        this.temp = Math.round(this.temp);

                    let relTemp = this.temp - this.tempMin,
                        tempFrac = relTemp / tempRange,
                        angle = tempFrac * angleRange + this.angleMin;

                    // CSS variable
                    this.el.style.setProperty("--angle",`${angle}deg`);

                    // draggable area
                    if (tempDrag && notDragged)
                        tempDrag.style.transform = `rotate(${angle}deg)`;

                    // shades
                    if (cold)
                        cold.style.opacity = 1 - tempFrac;
                    if (hot)
                        hot.style.opacity = tempFrac;

                    // display value
                    if (tempDigits) {
                        let prevDigitArr = String(prevTemp).split("").reverse(),
                            tempRounded = Math.round(this.temp),
                            digitArr = String(tempRounded).split("").reverse(),
                            maxDigits = 2,
                            digitDiff = maxDigits - digitArr.length,
                            prevDigitDiff = maxDigits - prevDigitArr.length,
                            incClass = "temp__digit--inc",
                            decClass = "temp__digit--dec",
                            timeoutA = 150,
                            timeoutB = 300;

                        while (digitDiff--)
                            digitArr.push("");

                        while (prevDigitDiff--)
                            prevDigitArr.push("");

                        for (let d = 0; d < maxDigits; ++d) {
                            let digit = +digitArr[d],
                                prevDigit = +prevDigitArr[d],
                                tempDigit = tempDigits[d];

                            setTimeout(this.changeDigit.bind(null,tempDigit,digit),timeoutA);

                            // animate increment
                            if ((digit === 0 && prevDigit === 9) || (digit > prevDigit && this.temp > prevTemp)) {
                                this.removeClass(tempDigit,incClass);
                                void tempDigit.offsetWidth;
                                tempDigit.classList.add(incClass);
                                setTimeout(this.removeClass.bind(null,tempDigit,incClass),timeoutB);

                                // animate decrement
                            } else if ((digit === 9 && prevDigit === 0) || (digit < prevDigit && this.temp < prevTemp)) {
                                this.removeClass(tempDigit,decClass);
                                void tempDigit.offsetWidth;
                                tempDigit.classList.add(decClass);
                                setTimeout(this.removeClass.bind(null,tempDigit,decClass),timeoutB);
                            }
                        }
                    }
                }
            }
            outdoorsAdjust(inputOutside = 0,inputHumidity = 0) {
                let outdoorEls = this.el.querySelectorAll(".temp__o-value"),
                    outdoorVals = outdoorEls ? Array.from(outdoorEls) : [];

                this.outside = inputOutside;
                this.humidity = inputHumidity;

                if (outdoorVals) {
                    outdoorVals[0].textContent = `${this.outside}°`;
                    outdoorVals[1].textContent = `${this.humidity}%`;
                }
            }
        }
    </script>
    </body>
    </html>
    <?php
} else {
    header("Location: " . _BASE_ . "/sign-in/index.php?error=Lütfen Giriş Yapınız!");
}
?>
