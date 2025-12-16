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

            // Get the animal ID passed from the controller
            const animalId = {{ $animal->id }};  // ✅ This gets the ID from Blade

            const coinsDisplay = document.getElementById('coins');
            const hungerDisplay = document.getElementById('hunger');
            const cleanlinessDisplay = document.getElementById('cleanliness');
            const happinessDisplay = document.getElementById('happiness');
            const clickerAnimal = document.getElementById('clicker');
            const feedButton = document.getElementById('feedButton');
            const cleanButton = document.getElementById('cleanButton');

            if (!coinsDisplay || !clickerAnimal || !hungerDisplay) return;


            try {
                // Fetch saved data from server
                const coinsRes = await fetch("{{ route('coins.get') }}");
                const coinsData = await coinsRes.json();
                coins = coinsData.coins;
                coinsDisplay.textContent = coins;

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
                hungerDisplay.textContent = hunger;
                updateDirtiness(cleanliness);

                console.log('Loaded animal:', animalData);
            } catch (error) {
                console.error('Failed to load data:', error);
                hungerDisplay.textContent = hunger;
                cleanlinessDisplay.textContent = cleanliness;
                hungerDisplay.textContent = hunger;
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
                            body: JSON.stringify({ hunger: hunger })
                        });
                    } catch (error) {
                        console.error('Failed to save hunger:', error);
                    }
                }
            }, 1000);

            clickerAnimal.addEventListener('click', async () => {
                coins++;
                coinsDisplay.textContent = coins;

                cleanliness = Math.max(0, cleanliness - 10);
                cleanlinessDisplay.textContent = cleanliness;

                updateDirtiness(cleanliness);

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
                    await fetch("{{ route('animal.update', ['id' => $animal->id]) }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ cleanliness: cleanliness })
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
                        body: JSON.stringify({ hunger: hunger })
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
                        body: JSON.stringify({ cleanliness: cleanliness })
                    });
                } catch (error) {
                    console.error('Failed to save cleanliness:', error);
                }
            })

            clickerAnimal.addEventListener('animationend', (ev) => {
                if (ev.animationName === 'pet') {
                    clickerAnimal.classList.remove('pet');
                    if (walker) walker.style.animationPlayState = 'running';
                }
            });

            function updateDirtiness(cleanliness) {
                const dirtOverlay = clickerAnimal.querySelector('.dirt-overlay');
                if (!dirtOverlay) return;

                // Opacity increases as cleanliness decreases
                const opacity = 1 - (cleanliness / 100);
                dirtOverlay.style.opacity = opacity;
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
        <h2 class="text-xl font-semibold text-gray-800 m-0">Schoonheid: <span id="cleanliness">0</span></h2>
        <h2 class="text-xl font-semibold text-gray-800 m-0">Muntjes: <span id="coins">0</span></h2>

    </div>
    <div>
        <img class="w-10 h-10 cursor-pointer flex-shrink-0" src="/images/food.png" id="feedButton" alt="icon of food">
    </div>
    <div>
        <img class="w-10 h-10 cursor-pointer flex-shrink-0" src="/images/bath-tub.png" id="cleanButton" alt="icon of bathtub">
    </div>
</div>
<div class="walker walk">
    <div id="clicker" class="animal-container">
        <img src="/images/cheerful-fox.png"
             class="animal-image"
             alt="clickable animal">
        <img src="/images/mud-splatter.png"
             class="dirt-overlay"
             alt="dirt splatter">
    </div>
</div>
</body>
</html>

