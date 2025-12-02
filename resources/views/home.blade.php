{{-- include neerzetten hier --}}

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>NM Clicker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Tailwind & JS -->
    
    <!-- animatie voor aaien/flip/lopen -> niet aanraken -->
    <style>
        html, body {
            height: 100%;
        }
        #clicker {
            transition: transform 120ms;
            will-change: transform;
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
        }

        #clicker.pet {
            animation: pet 640ms cubic-bezier(.2,.9,.3,1);
        }

        @keyframes pet {
            /* include the horizontal centering translate so transforms don't jump */
            0% { transform: translateX(-50%) translateY(0) rotate(0) scale(1); }
            20% { transform: translateX(-50%) translateY(-6px) rotate(-6deg) scale(1.03); }
            50% { transform: translateX(-50%) translateY(0) rotate(6deg) scale(1.02); }
            80% { transform: translateX(-50%) translateY(-3px) rotate(-3deg) scale(1.01); }
            100% { transform: translateX(-50%) translateY(0) rotate(0) scale(1); }
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
            0%   { transform: translateX(-450px) scaleX(1); }
            49%  { transform: translateX(450px) scaleX(1); }
            50%  { transform: translateX(450px) scaleX(-1); }
            100% { transform: translateX(-450px) scaleX(-1); }
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
    </style>
</head>

<!-- background -->
<body class="min-h-screen flex flex-col items-center justify-center bg-fixed"
      style="background-image: url('https://static.vecteezy.com/system/resources/thumbnails/003/467/246/small_2x/nature-landscape-background-cute-simple-cartoon-style-free-vector.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">

    <!-- Coins + vos foto -->
    <div class="text-center p-6 bg-white/60 backdrop-blur-sm rounded-xl shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 mb-3">Coins: <span id="score">0</span></h2>
           <div class="walker walk">
               <img src="/images/cheerful-fox.png"
                    id="clicker"
                    alt="clickable animal">
           </div>
    </div>


    <script>
        (function () {
            let score = 0;
            const scoreDisplay = document.getElementById('score');
            const clickerAnimal = document.getElementById('clicker');

            if (!scoreDisplay || !clickerAnimal) return;

            // walking stage wrapper (parent of the image)
            const walker = clickerAnimal.parentElement;

            // start walking by default
            if (walker) walker.classList.add('walk');

            clickerAnimal.addEventListener('click', () => {
                score++;
                scoreDisplay.textContent = score;

                // pause walking while pet animation runs
                if (walker) walker.style.animationPlayState = 'paused';

                // restart pet animation
                clickerAnimal.classList.remove('pet');
                void clickerAnimal.offsetWidth;
                clickerAnimal.classList.add('pet');
            });

            // when pet animation finishes, remove class and resume walking
            clickerAnimal.addEventListener('animationend', (ev) => {
                if (ev.animationName === 'pet') {
                    clickerAnimal.classList.remove('pet');
                    if (walker) walker.style.animationPlayState = 'running';
                }
            });
        })();
    </script>

</body>
</html>

