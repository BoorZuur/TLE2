//FOTOS 1500 x 900
// Areas loaded from server
let areas = [];

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

    const total = area.animals.length;
    const collected = area.collected.length;

    const percent = total === 0 ? 0 : (collected / total) * 100;

    progressBar.style.width = `${percent}%`;
    progressText.textContent = `${collected} / ${total} Verzameld`;

    areaImage.src = getProgressImage(area, percent);
}


// Load all data from server
Promise.all([
    fetch('/api/areas').then(res => res.json()),
    fetch('/api/collected').then(res => res.json())
])
.then(([areasData, collectedData]) => {
    const collectedSpecies = collectedData.collected || [];

    // Build areas array from server data
    areas = areasData.areas.map(area => ({
        id: area.id,
        name: area.name,
        description: area.description,
        info_image: area.info_image,
        animals: area.animals || [],
        collected: (area.animals || []).filter(animal => collectedSpecies.includes(animal)),
        images: area.images
    }));

    renderArea(currentArea);
})
.catch(error => {
    console.error('Error loading areas:', error);
});


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
const modalImg = document.getElementById('modal-img');

// Open modal
infoButton.addEventListener('click', () => {
    const area = areas[currentArea];

    modalTitle.textContent = area.name;
    modalText.textContent = area.description;
    modalImg.src = area.info_image;

    infoModal.classList.remove('hidden');
});


// Close modal
closeModal.addEventListener('click', () => {
    infoModal.classList.add('hidden');
});

