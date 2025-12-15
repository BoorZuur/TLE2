window.addEventListener('DOMContentLoaded', async () => {
    let coins = 0;
    let hunger = 100;
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
            showMessage("Wacht even voordat je je dier weer kunt voeden!");
            return;
        }

        // Update local hunger and reload from server
        hunger = data.hunger;
        hungerDisplay.textContent = hunger;
        lastServerSync = Date.now();
        await loadHunger();
    });

    // let hunger = 0;
    let lastServerSync = Date.now();

    //fetch hunger from server and update display
    async function loadHunger() {
        const res = await fetch("{{ route('animal.hunger.get', $animal->id) }}");
        const data = await res.json();
        hunger = data.hunger;
        hungerDisplay.textContent = hunger;
        lastServerSync = Date.now();
    }

    // Update hunger display every second for smooth countdown
    setInterval(() => {
        const secondsSinceSync = Math.floor((Date.now() - lastServerSync) / 1000);
        const decrease = Math.floor(secondsSinceSync / 2);
        const currentHunger = Math.max(0, hunger - decrease);
        hungerDisplay.textContent = currentHunger;
        updateWalkerAnimation();
    }, 1000);

    // Sync with server every 2 seconds
    setInterval(loadHunger, 2000);
    loadHunger();


    clickerAnimal.addEventListener('click', async () => {
        if (energy <= 0 || clickerAnimal.dataset.sleeping === 'true') return;
        coins++;
        energy = Math.max(0, energy - 1);
        coinsDisplay.textContent = coins;
        energyDisplay.textContent = energy;

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
    });

    sleepButton.addEventListener('click', async () => {
        const isSleeping = clickerAnimal.dataset.sleeping === 'true';
        const walker = clickerAnimal.parentElement;
        const overlay = document.getElementById('sleepOverlay');
        const statsText = document.getElementById('statsText');
        const feedBtn = document.getElementById('feedButton');
        const sleepBtn = document.getElementById('sleepButton');
        const errorMsg = document.getElementById('errorMessage');

        if (isSleeping) {
            clickerAnimal.src = '/images/fox-standing.png';
            clickerAnimal.dataset.sleeping = 'false';
            if (walker) walker.style.animationPlayState = 'running';
            if (overlay) overlay.style.opacity = '0';
            statsText.classList.remove('sleep-mode-text');
            feedBtn.classList.remove('sleep-mode-button');
            sleepBtn.classList.remove('sleep-mode-button');
            errorMsg.classList.remove('sleep-mode-text');
        } else {
            clickerAnimal.src = '/images/fox-sleeping.png';
            clickerAnimal.dataset.sleeping = 'true';
            if (walker) walker.style.animationPlayState = 'paused';
            if (overlay) overlay.style.opacity = '1';
            statsText.classList.add('sleep-mode-text');
            feedBtn.classList.add('sleep-mode-button');
            sleepBtn.classList.add('sleep-mode-button');
            errorMsg.classList.add('sleep-mode-text');
        }

        const gained = 1;
        const energyInterval = setInterval(async () => {
            if (clickerAnimal.dataset.sleeping !== 'true') {
                clearInterval(energyInterval);
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
    });

    // When pet animation finishes, resume walking
    clickerAnimal.addEventListener('animationend', (ev) => {
        if (ev.animationName === 'pet') {
            clickerAnimal.classList.remove('pet');
            if (walker) walker.style.animationPlayState = 'running';
        }
    });

    function updateWalkerAnimation() {
        const errorMessage = document.getElementById('errorMessage');
        if (clickerAnimal.dataset.sleeping === 'true' || energy <= 0) {
            walker.style.animationPlayState = 'paused';
            feedButton.style.opacity = '0.25';
            feedButton.style.pointerEvents = 'none';

            if (errorMessage && energy <= 0) {
                errorMessage.textContent = "Je hebt geen energie meer, laat je dier slapen!";
            }
        } else {
            walker.style.animationPlayState = 'running';
            feedButton.style.opacity = '1';
            feedButton.style.pointerEvents = 'auto';

            if (errorMessage) {
                errorMessage.textContent = "";
            }
        }
    }
});
