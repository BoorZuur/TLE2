<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collected Animals</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-50 min-h-screen">

<x-app-layout>

    <div class="min-h-screen flex flex-col items-center pt-2">

        <!-- Area Title -->
        <h2 id="area-title" class="text-3xl font-bold text-gray-800 mb-6">Forest</h2>

        <!-- Progress Bar -->
        <div class="w-11/12 md:w-3/4 lg:w-2/3 py-6">
            <div class="w-full bg-red-400 rounded-lg h-6 overflow-hidden">
                <div id="progress-bar" class="bg-green-500 h-6 w-0 transition-all"></div>
            </div>
            <div id="progress-text" class="text-center mt-2 text-gray-800 font-medium">0 / 0 collected</div>
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
                ← Previous
            </button>
            <button id="next-area"
                    class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                Next →
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
                0: "https://picsum.photos/id/1025/300/300",
                20: "https://picsum.photos/id/1020/300/300",
                40: "https://picsum.photos/id/1015/300/300",
                60: "https://picsum.photos/id/1011/300/300",
                80: "https://picsum.photos/id/1011/300/300",
                100: "https://picsum.photos/id/1010/300/300"
            }
        },
        {
            name: 'Kunstgebied',
            animals: ['Fox', 'Deer', 'Rabbit', 'Owl', 'Squirrel'],
            collected: ['Fox', 'Owl'],
            images: {
                0: "https://picsum.photos/id/1025/300/300",
                20: "https://picsum.photos/id/1020/300/300",
                40: "https://picsum.photos/id/1015/300/300",
                60: "https://picsum.photos/id/1011/300/300",
                80: "https://picsum.photos/id/1011/300/300",
                100: "https://picsum.photos/id/1010/300/300"
            }
        },
        {
            name: 'Heide',
            animals: ['Fox', 'Deer', 'Rabbit', 'Owl', 'Squirrel'],
            collected: ['Fox', 'Owl'],
            images: {
                0: "https://picsum.photos/id/1025/300/300",
                20: "https://picsum.photos/id/1020/300/300",
                40: "https://picsum.photos/id/1015/300/300",
                60: "https://picsum.photos/id/1011/300/300",
                80: "https://picsum.photos/id/1011/300/300",
                100: "https://picsum.photos/id/1010/300/300"
            }
        },
        {
            name: 'Zandverstuiving',
            animals: ['Fox', 'Deer', 'Rabbit', 'Owl', 'Squirrel'],
            collected: ['Fox', 'Owl'],
            images: {
                0: "https://picsum.photos/id/1025/300/300",
                20: "https://picsum.photos/id/1020/300/300",
                40: "https://picsum.photos/id/1015/300/300",
                60: "https://picsum.photos/id/1011/300/300",
                80: "https://picsum.photos/id/1011/300/300",
                100: "https://picsum.photos/id/1010/300/300"
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
        progressText.textContent = `${area.collected.length} / ${area.animals.length} collected`;

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
</script>

</body>
</html>
