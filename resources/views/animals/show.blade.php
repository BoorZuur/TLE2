<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dier Status</title>

    <style>
        body {
            font-family: system-ui, sans-serif;
            background: #f3f4f6;
            padding: 24px;
        }

        .card {
            max-width: 420px;
            margin: auto;
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .1);
        }

        h2 {
            margin: 0 0 4px 0;
        }

        .stat {
            margin-bottom: 16px;
        }

        /* ===== METERS ===== */

        .meter {
            position: relative;
            height: 10px;
            border-radius: 9999px;
            background: rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .meter-fill {
            position: absolute;
            inset: 0;
            width: 0%;
            border-radius: inherit;
            transition: width 180ms ease;
        }

        .meter-hunger {
            background: #f97316;
        }

        .meter-cleanliness {
            background: #38bdf8;
        }

        .meter-energy {
            background: #22c55e;
        }

        button {
            margin-top: 8px;
            padding: 8px 12px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            background: #111827;
            color: white;
        }

        button + button {
            margin-left: 6px;
        }
    </style>
</head>

<body>

<div class="card">
    <div class="stat">
        <h2>Honger: <span id="hunger">0</span></h2>
        <div class="meter">
            <div id="hungerBar" class="meter-fill meter-hunger"></div>
        </div>
    </div>

    <div class="stat">
        <h2>Schoonheid: <span id="cleanliness">100</span></h2>
        <div class="meter">
            <div id="cleanlinessBar" class="meter-fill meter-cleanliness"></div>
        </div>
    </div>

    <div class="stat">
        <h2>Energie: <span id="energy">0</span></h2>
        <div class="meter">
            <div id="energyBar" class="meter-fill meter-energy"></div>
        </div>
    </div>

    <button id="feedBtn">Voer</button>
    <button id="cleanBtn">Was</button>
    <button id="sleepBtn">Slaap</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const HUNGER_MAX = 100;
        const CLEANLINESS_MAX = 100;
        const ENERGY_MAX = 1000;

        let hunger = 50;
        let cleanliness = 80;
        let energy = 300;

        const hungerDisplay = document.getElementById('hunger');
        const cleanlinessDisplay = document.getElementById('cleanliness');
        const energyDisplay = document.getElementById('energy');

        const hungerBar = document.getElementById('hungerBar');
        const cleanlinessBar = document.getElementById('cleanlinessBar');
        const energyBar = document.getElementById('energyBar');

        function clamp(value, max) {
            return Math.max(0, Math.min(max, value));
        }

        function setMeter(el, value, max) {
            el.style.width = `${(clamp(value, max) / max) * 100}%`;
        }

        function refresh() {
            hungerDisplay.textContent = hunger;
            cleanlinessDisplay.textContent = cleanliness;
            energyDisplay.textContent = energy;

            setMeter(hungerBar, hunger, HUNGER_MAX);
            setMeter(cleanlinessBar, cleanliness, CLEANLINESS_MAX);
            setMeter(energyBar, energy, ENERGY_MAX);
        }

        document.getElementById('feedBtn').onclick = () => {
            hunger = clamp(hunger + 10, HUNGER_MAX);
            refresh();
        };

        document.getElementById('cleanBtn').onclick = () => {
            cleanliness = clamp(cleanliness + 10, CLEANLINESS_MAX);
            refresh();
        };

        document.getElementById('sleepBtn').onclick = () => {
            energy = clamp(energy + 50, ENERGY_MAX);
            refresh();
        };

        refresh();
    });
</script>

</body>
</html>
