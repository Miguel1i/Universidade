
<footer class="footer">
    <div class="waves">
        <div class="wave" id="wave1"></div>
        <div class="wave" id="wave2"></div>
        <div class="wave" id="wave3"></div>
        <div class="wave" id="wave4"></div>
    </div>
    <ul class="social-icon">
        <li class="social-icon__item"><a class="social-icon__link" href="#">
                <ion-icon name="logo-facebook"></ion-icon>
            </a></li>
        <li class="social-icon__item"><a class="social-icon__link" href="#">
                <ion-icon name="logo-twitter"></ion-icon>
            </a></li>
        <li class="social-icon__item"><a class="social-icon__link" href="#">
                <ion-icon name="logo-linkedin"></ion-icon>
            </a></li>
        <li class="social-icon__item"><a class="social-icon__link" href="#">
                <ion-icon name="logo-instagram"></ion-icon>
            </a></li>
    </ul>
    <p>&copy;2024 MediVitta | All Rights Reserved</p>
</footer>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap");

    * {
        margin: 0;
        padding: 0;
    }
    .footer {
        position: relative;
        bottom: 0;
        height: 4rem;
        width: 100%;
        background: #35A1A8;
        min-height: 70px;
        padding: 10px 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        margin-top: 10%;
    }


    .social-icon {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 5px 0;
        flex-wrap: wrap;
    }

    .social-icon__item{
        list-style: none;
    }

    .social-icon__link {
        font-size: 1.5rem;
        color: #fff;
        margin: 0 5px;
        display: inline-block;
        transition: 0.5s;
    }
    .social-icon__link:hover {
        transform: translateY(-5px);
    }


    .footer p {
        color: #fff;
        margin: 5px 0 5px 0;
        font-size: 0.9rem;
        font-weight: 300;
    }

    .wave {
        position: absolute;
        top: -50px;
        left: 0;
        width: 100%;
        height: 50px;
        background: url("/images/wave.png");
        background-size: 1000px 50px;
    }

    .wave#wave1 {
        z-index: 1000;
        opacity: 1;
        bottom: 0;
        animation: animateWaves 4s linear infinite;
    }

    .wave#wave2 {
        z-index: 999;
        opacity: 0.5;
        bottom: 10px;
        animation: animate 4s linear infinite !important;
    }

    .wave#wave3 {
        z-index: 1000;
        opacity: 0.2;
        bottom: 15px;
        animation: animateWaves 3s linear infinite;
    }

    .wave#wave4 {
        z-index: 999;
        opacity: 0.7;
        bottom: 20px;
        animation: animate 3s linear infinite;
    }

    @keyframes animateWaves {
        0% {
            background-position-x: 1000px;
        }
        100% {
            background-positon-x: 0px;
        }
    }

    @keyframes animate {
        0% {
            background-position-x: -1000px;
        }
        100% {
            background-positon-x: 0px;
        }
    }
</style>
