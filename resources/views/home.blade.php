<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>NM Klikker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Tailwind & JS -->


    <!-- animatie voor aaien/flip/lopen -> niet aanraken -->
    <style>
        html, body {
            height: 100%;
            overflow-y: hidden;
        }

        #clicker {
            transition: transform 120ms;
            will-change: transform;
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
        }

        #clicker.pet {
            animation: pet 640ms cubic-bezier(.2, .9, .3, 1);
        }

        @keyframes pet {
            /* include the horizontal centering translate so transforms don't jump */
            0% {
                transform: translateX(-50%) translateY(0) rotate(0) scale(1);
            }
            20% {
                transform: translateX(-50%) translateY(-6px) rotate(-6deg) scale(1.03);
            }
            50% {
                transform: translateX(-50%) translateY(0) rotate(6deg) scale(1.02);
            }
            80% {
                transform: translateX(-50%) translateY(-3px) rotate(-3deg) scale(1.01);
            }
            100% {
                transform: translateX(-50%) translateY(0) rotate(0) scale(1);
            }
        }

        /* Flip L/R Animation*/
        .walker {
            position: relative;
            width: 540px;
            height: 580px;
            margin: 0 auto;
            overflow: visible;
        }

        .walker.walk {
            animation: walk 20s linear infinite;
        }

        @keyframes walk {
            0% {
                transform: translateX(-450px) scaleX(1);
            }
            49% {
                transform: translateX(450px) scaleX(1);
            }
            50% {
                transform: translateX(450px) scaleX(-1);
            }
            100% {
                transform: translateX(-450px) scaleX(-1);
            }
        }

        /* anchor naar beneden */
        .walker img#clicker {
            position: absolute;
            bottom: 6px;
            left: 50%;
            transform: translateX(-50%);
            transform-origin: center bottom;
            width: 300px;
            height: auto;
        }

        .sleep-mode-text {
            color: white !important;
        }

        .sleep-mode-button {
            filter: invert(100%) brightness(200%);
        }
    </style>
</head>

<x-app-layout></x-app-layout>
<!-- background -->

<body class="min-h-screen flex flex-col items-center justify-center bg-fixed"
      style="background-image: url('https://static.vecteezy.com/system/resources/thumbnails/003/467/246/small_2x/nature-landscape-background-cute-simple-cartoon-style-free-vector.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">

<div id="sleepOverlay"
     class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-500 z-10"></div>


<!-- Coins + animal foto -->
<div id="statsContainer" class="relative z-20 flex flex-row items-center justify-center gap-6 mb-4 w-full">
    <div id="statsText">
        <h2 class="text-xl font-semibold m-0">Honger: <span id="hunger">0</span></h2>
        <h2 class="text-xl font-semibold m-0">Energie: <span id="energy">0</span></h2>
        <h2 class="text-xl font-semibold m-0">Muntjes: <span id="coins">0</span></h2>
    </div>
    <div>
        <img class="w-10 h-10 cursor-pointer flex-shrink-0" src="/images/food.png" id="feedButton" alt="icon of food">
    </div>
    <div>
        <img class="w-10 h-10 cursor-pointer flex-shrink-0" src="/images/sleep-icon.png"
             id="sleepButton"
             alt="icon for sleeping">
    </div>
</div>
<div id="errorMessage" class="relative z-20 text-red-600 font-semibold text-lg text-center m-0"
     style="min-height: 1.5em;"></div>

<div class="walker walk">
    <img src="/images/fox-standing.png"
         id="clicker"
         alt="clickable animal">
</div>
</body>
</html>

