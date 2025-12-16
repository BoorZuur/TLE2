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
            let cleanliness = 100;
            let happiness = 100;
            let energy = 1000;

            // Get the animal ID passed from the controller
            const animalId = {{ $animal->id }};  // ✅ This gets the ID from Blade

            const coinsDisplay = document.getElementById('coins');
            const hungerDisplay = document.getElementById('hunger');
            const cleanlinessDisplay = document.getElementById('cleanliness');
            const happinessDisplay = document.getElementById('happiness');
            const energyDisplay = document.getElementById('energy');
            const clickerAnimal = document.getElementById('clicker');
            const feedButton = document.getElementById('feedButton');
            const cleanButton = document.getElementById('cleanButton');
            const sleepButton = document.getElementById('sleepButton');

            if (!coinsDisplay || !clickerAnimal || !hungerDisplay) return;


            try {
                // Fetch saved data from server
                const coinsRes = await fetch("{{ route('coins.get') }}");
                const coinsData = await coinsRes.json();
                coins = coinsData.coins;
                coinsDisplay.textContent = coins;

                // Fetch energy from server
                const energyRes = await fetch("{{ route('energy.get') }}");
                const energyData = await energyRes.json();
                energy = energyData.energy;
                energyDisplay.textContent = energy;

                // Fetch animal data using the route helper with ID
                const animalRes = await fetch("{{ route('animal.get', ['id' => $animal->id]) }}");

                if (!animalRes.ok) {
                    throw new Error(`HTTP error! status: ${animalRes.status}`);
                }

                const animalData = await animalRes.json();
                hunger = animalData.hunger ?? 100;
                cleanliness = animalData.cleanliness ?? 100;
                happiness = animalData.happiness ?? 100;
                hungerDisplay.textContent = hunger;
                cleanlinessDisplay.textContent = cleanliness;
                energyDisplay.textContent = energy;
                updateDirtiness(cleanliness);

                console.log('Loaded animal:', animalData);
            } catch (error) {
                console.error('Failed to load data:', error);
                hungerDisplay.textContent = hunger;
                cleanlinessDisplay.textContent = cleanliness;
                energyDisplay.textContent = energy;
            }

            const walker = clickerAnimal.parentElement;
            if (walker) walker.classList.add('walk');

            // Hunger decreases every second
            setInterval(async () => {
                hunger = Math.max(0, hunger - 1);
                hungerDisplay.textContent = hunger;

                // Save hunger to database every 10 points or when it reaches 0
                if (hunger % 10 === 0 || hunger === 0) {
                    try {
                        await fetch("{{ route('animal.update', ['id' => $animal->id]) }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({hunger: hunger})
                        });
                    } catch (error) {
                        console.error('Failed to save hunger:', error);
                    }
                }
            }, 1000);

            clickerAnimal.addEventListener('click', async () => {
                // Check if sleeping or out of energy
                if (energy <= 0 || clickerAnimal.dataset.sleeping === 'true') return;

                coins++;
                coinsDisplay.textContent = coins;

                energy = Math.max(0, energy - 1);
                energyDisplay.textContent = energy;

                cleanliness = Math.max(0, cleanliness - 10);
                cleanlinessDisplay.textContent = cleanliness;

                updateDirtiness(cleanliness);
                updateWalkerAnimation();

                if (walker) walker.style.animationPlayState = 'paused';

                clickerAnimal.classList.remove('pet');
                void clickerAnimal.offsetWidth;
                clickerAnimal.classList.add('pet');

                try {
                    await fetch("{{ route('coins.add') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({amount: 1})
                    });
                } catch (error) {
                    console.error('Failed to save coins:', error);
                }

                try {
                    await fetch("{{ route('energy.add') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({amount: -1})
                    });
                } catch (error) {
                    console.error('Failed to save energy:', error);
                }

                try {
                    await fetch("{{ route('animal.update', ['id' => $animal->id]) }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({cleanliness: cleanliness})
                    });
                } catch (error) {
                    console.error('Failed to save cleanliness:', error);
                }
            });

            feedButton.addEventListener('click', async () => {
                hunger = Math.min(100, hunger + 20);
                hungerDisplay.textContent = hunger;

                try {
                    await fetch("{{ route('animal.update', ['id' => $animal->id]) }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({hunger: hunger})
                    });
                } catch (error) {
                    console.error('Failed to save hunger:', error);
                }
            });

            cleanButton.addEventListener('click', async () => {
                cleanliness = Math.min(100, cleanliness + 10);
                cleanlinessDisplay.textContent = cleanliness;

                updateDirtiness(cleanliness);

                try {
                    await fetch("{{ route('animal.update', ['id' => $animal->id]) }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({cleanliness: cleanliness})
                    });
                } catch (error) {
                    console.error('Failed to save cleanliness:', error);
                }
            });

            let energyInterval = null;

            sleepButton.addEventListener('click', async () => {
                const isSleeping = clickerAnimal.dataset.sleeping === 'true';
                const walker = clickerAnimal.parentElement;
                const overlay = document.getElementById('sleepOverlay');
                const statsText = document.getElementById('statsText');
                const feedBtn = document.getElementById('feedButton');
                const cleanBtn = document.getElementById('cleanButton');
                const sleepBtn = document.getElementById('sleepButton');
                const errorMsg = document.getElementById('errorMessage');

                if (isSleeping) {
                    // Wake up
                    clickerAnimal.querySelector('.animal-image').src = '{{ $animal->species->image ?? '/images/fox-standing.png' }}';
                    clickerAnimal.dataset.sleeping = 'false';
                    if (walker) walker.style.animationPlayState = 'running';
                    if (overlay) {
                        overlay.style.opacity = '0';
                        overlay.style.pointerEvents = 'none';
                    }
                    statsText.classList.remove('sleep-mode-text');
                    feedBtn.classList.remove('sleep-mode-button');
                    cleanBtn.classList.remove('sleep-mode-button');
                    sleepBtn.classList.remove('sleep-mode-button');
                    errorMsg.classList.remove('sleep-mode-text');

                    // Clear energy gain interval
                    if (energyInterval) {
                        clearInterval(energyInterval);
                        energyInterval = null;
                    }

                    updateWalkerAnimation();
                } else {
                    // Sleep
                    clickerAnimal.querySelector('.animal-image').src = '{{ $animal->species->image }}';
                    clickerAnimal.dataset.sleeping = 'true';
                    if (walker) walker.style.animationPlayState = 'paused';
                    if (overlay) {
                        overlay.style.opacity = '1';
                        overlay.style.pointerEvents = 'auto';
                    }
                    statsText.classList.add('sleep-mode-text');
                    feedBtn.classList.add('sleep-mode-button');
                    cleanBtn.classList.add('sleep-mode-button');
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
                        }
                    }, 1000);
                }
            });

            clickerAnimal.addEventListener('animationend', (ev) => {
                if (ev.animationName === 'pet') {
                    clickerAnimal.classList.remove('pet');
                    if (walker && clickerAnimal.dataset.sleeping !== 'true' && energy > 0) {
                        walker.style.animationPlayState = 'running';
                    }
                }
            });

            function updateDirtiness(cleanliness) {
                const dirtOverlay = clickerAnimal.querySelector('.dirt-overlay');
                if (!dirtOverlay) return;

                // Opacity increases as cleanliness decreases
                const opacity = 1 - (cleanliness / 100);
                dirtOverlay.style.opacity = opacity;
            }

            function updateWalkerAnimation() {
                const errorMessage = document.getElementById('errorMessage');
                const isSleeping = clickerAnimal.dataset.sleeping === 'true';
                const isOutOfEnergy = energy <= 0;

                if (isSleeping || isOutOfEnergy) {
                    if (walker) walker.style.animationPlayState = 'paused';
                    feedButton.style.opacity = '0.5';
                    cleanButton.style.opacity = '0.5';
                    feedButton.style.pointerEvents = 'none';
                    cleanButton.style.pointerEvents = 'none';

                    if (errorMessage && isOutOfEnergy && !isSleeping) {
                        errorMessage.textContent = "Je hebt geen energie meer, laat je dier slapen!";
                    }
                } else {
                    if (walker) walker.style.animationPlayState = 'running';
                    feedButton.style.opacity = '1';
                    cleanButton.style.opacity = '1';
                    feedButton.style.pointerEvents = 'auto';
                    cleanButton.style.pointerEvents = 'auto';

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
            /*position: relative;*/
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
        .walker #clicker {
            position: absolute;
            bottom: 6px;
            left: 50%;
            transform: translateX(-50%);
            transform-origin: center bottom;
            width: 300px;
            height: auto;
        }

        .animal-container {
            position: relative;
            display: inline-block;
            width: 200px;
            height: 200px;
        }

        .animal-image {
            width: 100%;
            height: 100%;
            position: relative;
            z-index: 1;
        }

        .dirt-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 2;
        }

        .sleep-mode-text h2 {
            color: white !important;
            z-index: 10;
        }

        #statsText {
            z-index: 10;
        }

        .sleep-mode-button {
            filter: invert(100%) brightness(200%);
        }
    </style>
</head>

<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl leading-tight">
            {{ __('NM Klikker') }}
        </h1>
    </x-slot>
</x-app-layout>
<!-- background -->

<body class="min-h-screen flex flex-col items-center justify-center bg-fixed"
      style="background-image: url('https://static.vecteezy.com/system/resources/thumbnails/003/467/246/small_2x/nature-landscape-background-cute-simple-cartoon-style-free-vector.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">

<div id="sleepOverlay"
     class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 z-5"></div>

<!-- Coins + vos foto -->
<div class="flex flex-row items-center justify-center gap-6 mb-4 w-full">
    <div id="statsText" class="text-center sm:text-left">
        <h2 class="text-xl font-semibold text-gray-800 m-0">Honger: <span id="hunger">0</span></h2>
        <h2 class="text-xl font-semibold text-gray-800 m-0">Schoonheid: <span id="cleanliness">0</span></h2>
        <h2 class="text-xl font-semibold text-gray-800 m-0">Energie: <span id="energy">0</span></h2>
        <h2 class="text-xl font-semibold text-gray-800 m-0">Muntjes: <span id="coins">0</span></h2>
    </div>
    <div>
        <img class="w-10 h-10 cursor-pointer flex-shrink-0" src="/images/food.png" id="feedButton" alt="icon of food">
    </div>
    <div>
        <img class="w-10 h-10 cursor-pointer flex-shrink-0" src="/images/bath-tub.png" id="cleanButton"
             alt="icon of bathtub">
    </div>
    <div>
        <img class="w-10 h-10 cursor-pointer flex-shrink-0" src="/images/sleep-icon.png" id="sleepButton" alt="icon for sleeping">
    </div>
</div>
<div id="errorMessage"
     class="relative z-20 text-red-600 font-semibold text-sm sm:text-base md:text-lg text-center m-0 px-4"
     style="min-height: 1.5em;"></div>

<div class="walker walk">
    <div id="clicker" class="animal-container">
        <img id="animal-image"
             src="{{ $animal->species->image ?? '/images/fox-standing.png' }}"
             class="animal-image"
             alt="{{ $animal->species->name ?? 'Animal' }}">
        <img src="/images/mud-splatter.png"
             class="dirt-overlay"
             alt="dirt splatter">
    </div>
</div>
</body>
</html>
