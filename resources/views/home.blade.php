<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>NM Klikker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Tailwind & JS -->

    <script>
        window.addEventListener('DOMContentLoaded', async () => {
            let coins = 0;
            let hunger = 100;
            const coinsDisplay = document.getElementById('coins');
            const hungerDisplay = document.getElementById('hunger');
            const clickerAnimal = document.getElementById('clicker');
            const feedButton = document.getElementById('feedButton')

            if (!coinsDisplay || !clickerAnimal || !hungerDisplay) return;

            // Fetch saved coins from server
            const res = await fetch("{{ route('coins.get') }}");
            const data = await res.json();
            coins = data.coins;
            coinsDisplay.textContent = coins;
            hungerDisplay.textContent = hunger;

            const walker = clickerAnimal.parentElement;
            if (walker) walker.classList.add('walk');

            //hunger goes down by one
            setInterval(() => {
                hunger = Math.max(0, hunger - 1);
                hungerDisplay.textContent = hunger;
            }, 1000);

            clickerAnimal.addEventListener('click', async () => {
                coins++;
                coinsDisplay.textContent = coins;

                // Pause walking while pet animation runs
                if (walker) walker.style.animationPlayState = 'paused';

                // Restart pet animation
                clickerAnimal.classList.remove('pet');
                void clickerAnimal.offsetWidth; // force reflow
                clickerAnimal.classList.add('pet');

                // Save coins to server
                await fetch("{{ route('coins.add') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({amount: 1})
                });
            });

            feedButton.addEventListener('click', async () => {
                hunger = Math.min(100, hunger + 20);
                hungerDisplay.textContent = hunger;
            });

            // When pet animation finishes, resume walking
            clickerAnimal.addEventListener('animationend', (ev) => {
                if (ev.animationName === 'pet') {
                    clickerAnimal.classList.remove('pet');
                    if (walker) walker.style.animationPlayState = 'running';
                }
            });
        });
    </script>


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
    </style>
</head>

<x-app-layout></x-app-layout>
<!-- background -->

<body class="min-h-screen flex flex-col items-center justify-center bg-fixed"
      style="background-image: url('https://static.vecteezy.com/system/resources/thumbnails/003/467/246/small_2x/nature-landscape-background-cute-simple-cartoon-style-free-vector.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">


<!-- Coins + vos foto -->
<div class="flex flex-row items-center justify-center gap-6 mb-4 w-full">
    <div>
        <h2 class="text-xl font-semibold text-gray-800 m-0">Honger: <span id="hunger">0</span></h2>
        <h2 class="text-xl font-semibold text-gray-800 m-0">Muntjes: <span id="coins">0</span></h2>
    </div>
    <div>
        <img class="w-10 h-10 cursor-pointer flex-shrink-0" src="/images/food.png" id="feedButton" alt="icon of food">
    </div>
</div>
<div class="walker walk">
    <img src="/images/cheerful-fox.png"
         id="clicker"
         alt="clickable animal">
</div>
</body>
</html>

