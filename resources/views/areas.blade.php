<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verzamelde gebieden</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-50 min-h-screen">

<x-app-layout>

    <div class="min-h-screen flex flex-col items-center pt-2">

        <!-- Area Title -->
        <div class="flex justify-center items-center  space-x-4">
            <h2 id="area-title" class="text-3xl font-bold text-gray-800 m-0">Bos</h2>
            <img id="info-button" alt="info" src="/images/info.png"
                 class="w-10 h-10 cursor-pointer hover:scale-110 transition-transform">
        </div>

        <!-- Info Modal -->
        <div id="info-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-xl p-6 w-11/12 md:w-2/3 lg:w-1/2 relative">
                <!-- Close button -->
                <img id="close-modal" src="/images/close.png" alt="Close"
                     class="w-8 h-8 absolute top-4 right-4 cursor-pointer hover:scale-110 transition-transform">

                <!-- Modal content -->
                <h3 id="modal-title" class="text-2xl font-bold mb-4"></h3>
                <p id="modal-text" class="text-gray-700"></p>
            </div>
        </div>


        <!-- Progress Bar -->
        <div class="w-11/12 md:w-3/4 lg:w-2/3 py-6">
            <div class="w-full bg-red-400 rounded-lg h-6 overflow-hidden">
                <div id="progress-bar" class="bg-green-500 h-6 w-0 transition-all"></div>
            </div>
            <div id="progress-text" class="text-center mt-2 text-gray-800 font-medium">0 / 0 Verzameld</div>
        </div>

        <!-- image-->
        <div class="p-4 bg-green-200 rounded-xl">
            <img id="area-image"
                 class="w-96 h-auto object-contain transition-all duration-300" src="">
        </div>

        <!-- Arrows -->
        <div class="flex gap-4 py-4">
            <button id="prev-area"
                    class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                ← Vorige
            </button>
            <button id="next-area"
                    class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                Volgende →
            </button>
        </div>

    </div>

</x-app-layout>

<script>
    const areas = [
        {
            name: 'Bos',
            animals: ['Fox', 'Deer', 'Rabbit', 'Owl', 'Squirrel'],
            collected: ['Fox', 'Owl', 'Rabbit', 'Squirrel', 'Deer'],
            images: {
                0: "/images/Gebieden/0/bos0.png",
                20: "/images/Gebieden/1/bos1.png",
                40: "/images/Gebieden/2/bos2.png",
                60: "/images/Gebieden/3/bos3.png",
                80: "/images/Gebieden/4/bos4.png",
                100: "/images/Gebieden/5/bos5.png",
            }
        },
        {
            name: 'Strand',
            animals: ['Lion', 'Elephant', 'Zebra', 'Giraffe', 'Hyena'],
            collected: ['Elephant', 'Giraffe', 'Zebra'],
            images: {
                0: "/images/Gebieden/0/bos0.png",
                20: "/images/Gebieden/1/bos1.png",
                40: "/images/Gebieden/2/bos2.png",
                60: "/images/Gebieden/3/bos3.png",
                80: "/images/Gebieden/4/bos4.png",
                100: "/images/Gebieden/5/bos5.png",
            }
        },
        {
            name: 'Kunstgebied',
            animals: ['Fox', 'Deer', 'Rabbit', 'Owl', 'Squirrel'],
            collected: [],
            images: {
                0: "/images/Gebieden/0/bos0.png",
                20: "/images/Gebieden/1/bos1.png",
                40: "/images/Gebieden/2/bos2.png",
                60: "/images/Gebieden/3/bos3.png",
                80: "/images/Gebieden/4/bos4.png",
                100: "/images/Gebieden/5/bos5.png",
            }
        },
        {
            name: 'Heide',
            animals: ['Fox', 'Deer', 'Rabbit', 'Owl', 'Squirrel'],
            collected: ['Fox', 'Owl', 'Rabbit', 'Deer'],
            images: {
                0: "/images/Gebieden/0/bos0.png",
                20: "/images/Gebieden/1/bos1.png",
                40: "/images/Gebieden/2/bos2.png",
                60: "/images/Gebieden/3/bos3.png",
                80: "/images/Gebieden/4/bos4.png",
                100: "/images/Gebieden/5/bos5.png",
            }
        },
        {
            name: 'Zandverstuiving',
            animals: ['Fox', 'Deer', 'Rabbit', 'Owl', 'Squirrel'],
            collected: ['Fox'],
            images: {
                0: "/images/Gebieden/0/bos0.png",
                20: "/images/Gebieden/1/bos1.png",
                40: "/images/Gebieden/2/bos2.png",
                60: "/images/Gebieden/3/bos3.png",
                80: "/images/Gebieden/4/bos4.png",
                100: "/images/Gebieden/5/bos5.png",
            }
        },
    ];

    let currentArea = 0;

    const areaTitle = document.getElementById('area-title');
    const areaImage = document.getElementById('area-image');
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');

    function getProgressImage(area, percent) {
        if (percent === 0) return area.images[0];
        if (percent > 0 && percent <= 20) return area.images[20];
        if (percent > 20 && percent <= 40) return area.images[40];
        if (percent > 40 && percent <= 60) return area.images[60];
        if (percent > 60 && percent <= 80) return area.images[80];
        return area.images[100];
    }

    function renderArea(index) {
        const area = areas[index];
        areaTitle.textContent = area.name;

        const percent = (area.collected.length / area.animals.length) * 100;

        progressBar.style.width = `${percent}%`;
        progressText.textContent = `${area.collected.length} / ${area.animals.length} Verzameld`;

        // Pick image based on progress
        areaImage.src = getProgressImage(area, percent);
    }

    renderArea(currentArea);

    document.getElementById('prev-area').addEventListener('click', () => {
        currentArea = (currentArea - 1 + areas.length) % areas.length;
        renderArea(currentArea);
    });

    document.getElementById('next-area').addEventListener('click', () => {
        currentArea = (currentArea + 1) % areas.length;
        renderArea(currentArea);
    });


    const infoButton = document.getElementById('info-button');
    const infoModal = document.getElementById('info-modal');
    const closeModal = document.getElementById('close-modal');

    const modalTitle = document.getElementById('modal-title');
    const modalText = document.getElementById('modal-text');

    // Info content for each area
    const areaInfo = [
        {
            name: 'Bos',
            text: 'Het bos is rijk aan dieren en planten. Hier kun je allerlei wilde dieren vinden.'
        },
        {
            name: 'Strand',
            text: 'Het strand is een open gebied met zand en zee. Je vindt hier andere soorten dieren.'
        },
        {
            name: 'Kunstgebied',
            text: 'Het kunstgebied bevat verschillende kunstwerken en creatieve plekken.'
        },
        {
            name: 'Heide',
            text: 'De heide is een kleurrijk gebied vol bloemen en bijzondere dieren.'
        },
        {
            name: 'Zandverstuiving',
            text: 'Een uitgestrekt zandgebied waar het moeilijk is om dieren te vinden.'
        },
    ];

    // Open modal
    infoButton.addEventListener('click', () => {
        const area = areas[currentArea]; // get current area
        const info = areaInfo.find(a => a.name === area.name);

        modalTitle.textContent = info.name;
        modalText.textContent = info.text;

        infoModal.classList.remove('hidden');
    });

    // Close modal
    closeModal.addEventListener('click', () => {
        infoModal.classList.add('hidden');
    });

</script>

</body>
</html>
