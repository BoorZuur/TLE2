<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>NM Klikker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Tailwind & JS -->

    {{--    dit in een include zetten gaat breken--}}
    <script>
        window.addEventListener('DOMContentLoaded', async () => {
            let coins = 0;
            let hunger = 0;
            let energy = 1000;
            const coinsDisplay = document.getElementById('coins');
            const hungerDisplay = document.getElementById('hunger');
            const energyDisplay = document.getElementById('energy');
            const clickerAnimal = document.getElementById('clicker');
            const feedButton = document.getElementById('feedButton');
            const sleepButton = document.getElementById('sleepButton');

            if (!coinsDisplay || !clickerAnimal || !hungerDisplay || !energyDisplay) return;

            // Function to show temporary message
            function showMessage(text) {
                const messageDiv = document.createElement('div');
                messageDiv.textContent = text;
                messageDiv.className = 'fixed top-20 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-opacity duration-300';
                document.body.appendChild(messageDiv);

                setTimeout(() => {
                    messageDiv.style.opacity = '0';
                    setTimeout(() => messageDiv.remove(), 300);
                }, 2000);
            }

            // Fetch saved coins from server
            const res = await fetch("{{ route('coins.get') }}");
            const energyRes = await fetch("{{ route('energy.get') }}");
            const data = await res.json();
            const energyData = await energyRes.json();
            coins = data.coins;
            energy = energyData.energy;
            coinsDisplay.textContent = coins;
            hungerDisplay.textContent = hunger;
            energyDisplay.textContent = energy;


            //walker animation
            const walker = clickerAnimal.parentElement;
            if (walker) walker.classList.add('walk');

            //feedbutton logica
            feedButton.addEventListener('click', async () => {
                const res = await fetch("{{ route('animal.feed', $animal->id) }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                });

                const data = await res.json();

                if (data.error === 'cooldown') {
                    let remaining = Math.floor(data.remaining)
                    showMessage(`Je kan je dier weer voeren over ${remaining} seconde`);
                    return;
                }

                hunger = data.hunger;
                hungerDisplay.textContent = hunger;

                if (data.coins !== undefined) {
                    coins = data.coins;
                    coinsDisplay.textContent = coins;
                }

                lastServerSync = Date.now();
                await loadHunger();
            });

            let lastServerSync = Date.now();

            //fetch hunger from server and update display
            async function loadHunger() {
                const res = await fetch("{{ route('animal.hunger.get', $animal->id) }}");
                const data = await res.json();
                hunger = data.hunger;
                hungerDisplay.textContent = hunger;
                lastServerSync = Date.now();

                if (data.coins !== undefined) {
                    coins = data.coins;
                    coinsDisplay.textContent = coins
                }
            }

            // update hunger variable every second -> LOCAL hunger value
            setInterval(() => {
                const secondsSinceSync = Math.ceil((Date.now() - lastServerSync) / 1000);
                const decrease = Math.floor(secondsSinceSync / 20); // <- local versie, in animalcontroller gebeurt het serverside
                const currentHunger = Math.max(0, hunger - decrease);
                hungerDisplay.textContent = currentHunger;
                updateWalkerAnimation();
            }, 1000);

            // Sync with server every 30 seconds -> REAL/SERVER Hunger value
            setInterval(loadHunger, 30000);
            loadHunger();


            clickerAnimal.addEventListener('click', async () => {
                if (energy <= 0 || clickerAnimal.dataset.sleeping === 'true') return;

                coins++;
                energy = Math.max(0, energy - 1);
                coinsDisplay.textContent = coins;
                energyDisplay.textContent = energy;
                if (walker) walker.style.animationPlayState = 'paused';
                clickerAnimal.classList.remove('pet');
                requestAnimationFrame(() => {
                    clickerAnimal.classList.add('pet');
                });

                // Save coins to server
                await fetch("{{ route('coins.add') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({amount: 1})
                });

                // Save energy to server
                await fetch("{{ route('energy.add') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({amount: -1})
                });
                updateWalkerAnimation();
            }, {passive: false});

            clickerAnimal.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    clickerAnimal.click();
                }
            });

            feedButton.addEventListener('keydown', async (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    feedButton.click();
                }
            });

            sleepButton.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    sleepButton.click();
                }
            });

            let energyInterval = null;

            sleepButton.addEventListener('click', async () => {
                const isSleeping = clickerAnimal.dataset.sleeping === 'true';
                const walker = clickerAnimal.parentElement;
                const overlay = document.getElementById('sleepOverlay');
                const statsText = document.getElementById('statsText');
                const feedBtn = document.getElementById('feedButton');
                const sleepBtn = document.getElementById('sleepButton');
                const errorMsg = document.getElementById('errorMessage');

                if (isSleeping) {
                    // Wake up
                    clickerAnimal.src = '/images/fox-standing.png';
                    clickerAnimal.dataset.sleeping = 'false';
                    if (walker) walker.style.animationPlayState = 'running';
                    if (overlay) {
                        overlay.style.opacity = '0';
                        overlay.style.pointerEvents = 'none';
                    }
                    statsText.classList.remove('sleep-mode-text');
                    feedBtn.classList.remove('sleep-mode-button');
                    sleepBtn.classList.remove('sleep-mode-button');
                    errorMsg.classList.remove('sleep-mode-text');

                    // Clear energy gain interval
                    if (energyInterval) {
                        clearInterval(energyInterval);
                        energyInterval = null;
                    }
                } else {
                    // Sleep
                    clickerAnimal.src = '/images/fox-sleeping.png';
                    clickerAnimal.dataset.sleeping = 'true';
                    if (walker) walker.style.animationPlayState = 'paused';
                    if (overlay) {
                        overlay.style.opacity = '1';
                        overlay.style.pointerEvents = 'auto';
                    }
                    statsText.classList.add('sleep-mode-text');
                    feedBtn.classList.add('sleep-mode-button');
                    sleepBtn.classList.add('sleep-mode-button');
                    errorMsg.classList.add('sleep-mode-text');

                    // Clear any existing interval before creating a new one
                    if (energyInterval) {
                        clearInterval(energyInterval);
                    }

                    // Start energy gain
                    const gained = 1;
                    energyInterval = setInterval(async () => {
                        // Check if still sleeping
                        if (clickerAnimal.dataset.sleeping !== 'true') {
                            clearInterval(energyInterval);
                            energyInterval = null;
                            return;
                        }
                        if (energy < 1000) {
                            energy = Math.min(1000, energy + gained);
                            energyDisplay.textContent = energy;

                            await fetch("{{ route('energy.add') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({amount: gained})
                            });
                            updateWalkerAnimation();
                        }
                    }, 1000);
                }
            }, {passive: false});

            // When pet animation finishes, resume walking
            clickerAnimal.addEventListener('animationend', (ev) => {
                if (ev.animationName === 'pet') {
                    clickerAnimal.classList.remove('pet');
                    if (walker && clickerAnimal.dataset.sleeping !== 'true' && energy > 0) {
                        walker.style.animationPlayState = 'running';
                    }
                }
            }, {passive: true});

            function updateWalkerAnimation() {
                const errorMessage = document.getElementById('errorMessage');
                const isSleeping = clickerAnimal.dataset.sleeping === 'true';
                const isOutOfEnergy = energy <= 0;

                if (isSleeping || isOutOfEnergy) {
                    if (walker) walker.style.animationPlayState = 'paused';
                    feedButton.style.opacity = '0.25';
                    feedButton.style.pointerEvents = 'none';

                    if (errorMessage && isOutOfEnergy) {
                        errorMessage.textContent = "Je hebt geen energie meer, laat je dier slapen!";
                    }
                } else {
                    if (walker) walker.style.animationPlayState = 'running';
                    feedButton.style.opacity = '1';
                    feedButton.style.pointerEvents = 'auto';

                    if (errorMessage) {
                        errorMessage.textContent = "";
                    }
                }
            }
        });
    </script>


    <!-- animatie voor aaien/flip/lopen -> niet aanraken -->
    <style>
        html, body {
            height: 100%;
            overflow-y: auto;
        }

        #clicker {
            transition: transform 120ms;
            will-change: transform;
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
            image-rendering: crisp-edges;
        }

        #clicker.pet {
            animation: pet 640ms cubic-bezier(.2, .9, .3, 1) forwards;
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

        /* Flip L/R Animation - Fixed and Responsive */
        .walker {
            position: relative;
            width: min(90vw, 540px);
            height: auto;
            aspect-ratio: 540 / 580;
            margin: 0 auto;
            overflow: visible;
            will-change: transform;
            transform: translateZ(0);
        }

        .walker.walk {
            animation: walk 20s linear infinite;
        }

        @keyframes walk {
            0% {
                transform: translateX(-30vw) scaleX(1);
            }
            49% {
                transform: translateX(30vw) scaleX(1);
            }
            50% {
                transform: translateX(30vw) scaleX(-1);
            }
            100% {
                transform: translateX(-30vw) scaleX(-1);
            }
        }

        /* anchor naar beneden */
        .walker img#clicker {
            position: absolute;
            bottom: 6px;
            left: 50%;
            transform: translateX(-50%);
            transform-origin: center bottom;
            width: min(70vw, 300px);
            height: auto;
            will-change: transform;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }

        .sleep-mode-text {
            color: white !important;
        }

        .sleep-mode-button {
            filter: invert(100%) brightness(200%);
        }

        /* Button hover scale effects */
        #feedButton, #sleepButton {
            transition: transform 200ms ease-in-out;
        }

        #feedButton:hover, #sleepButton:hover {
            transform: scale(1.2);
        }

        /* Keyboard focus styles */
        #feedButton:focus-visible, #sleepButton:focus-visible {
            outline: 3px solid #FFD700;
            outline-offset: 4px;
            transform: scale(1.2);
        }

        #clicker:focus-visible {
            outline: 3px solid #FFD700;
            outline-offset: 4px;
            border-radius: 8px;
        }

        #clicker:hover {
            transform: translateX(-50%) scale(1.05);
        }

        /* mobile */
        @media (hover: none) and (pointer: coarse) {
            #feedButton, #sleepButton {
                min-width: 44px;
                min-height: 44px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            @keyframes walk {
                0% {
                    transform: translateX(-30vw) scaleX(1);
                }
                49% {
                    transform: translateX(30vw) scaleX(1);
                }
                50% {
                    transform: translateX(30vw) scaleX(-1);
                }
                100% {
                    transform: translateX(-30vw) scaleX(-1);
                }
            }
        }

        /* Responsive design breakpoints */
        @media (max-width: 640px) {
            body {
                overflow-y: auto;
            }
        }

        @media (min-height: 800px) and (max-width: 640px) {
            body {
                overflow-y: hidden;
            }
        }
    </style>
</head>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl leading-tight">
            {{ __('NM Klikker') }}
        </h2>
    </x-slot>
</x-app-layout>
<!-- background -->

<body class="min-h-screen flex flex-col items-center justify-center bg-fixed"
      style="background-image: url('https://static.vecteezy.com/system/resources/thumbnails/003/467/246/small_2x/nature-landscape-background-cute-simple-cartoon-style-free-vector.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">

<div id="sleepOverlay"
     class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 z-5"></div>


<!-- Coins + animal foto -->
<div id="statsContainer"
     class="relative z-20 flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6 mb-2 sm:mb-4 w-full px-4">
    <div id="statsText" class="text-center sm:text-left">
        <h2 class="text-sm sm:text-lg md:text-xl font-semibold m-0">Honger: <span id="hunger">0</span></h2>
        <h2 class="text-sm sm:text-lg md:text-xl font-semibold m-0">Energie: <span id="energy">0</span></h2>
        <h2 class="text-sm sm:text-lg md:text-xl font-semibold m-0">Muntjes: <span id="coins">0</span></h2>
    </div>
    <div>
        <img class="w-8 h-8 sm:w-10 sm:h-10 cursor-pointer flex-shrink-0" src="/images/food.png" id="feedButton"
             alt="icon of food" tabindex="0" role="button" aria-label="Feed your pet">
    </div>
    <div>
        <img class="w-8 h-8 sm:w-10 sm:h-10 cursor-pointer flex-shrink-0" src="/images/sleep-icon.png"
             id="sleepButton"
             alt="icon for sleeping" tabindex="0" role="button" aria-label="Put your pet to sleep">
    </div>
</div>
<div id="errorMessage"
     class="relative z-20 text-red-600 font-semibold text-sm sm:text-base md:text-lg text-center m-0 px-4"
     style="min-height: 1.5em;"></div>

<div class="walker walk">
    <img src="/images/fox-standing.png"
         id="clicker"
         alt="clickable animal"
         tabindex="0"
         role="button"
         aria-label="Click to interact with your pet">
</div>
</body>
</html>

