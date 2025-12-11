//FOTOS 1500 x 900
// Areas with image configurations - animals loaded server-side
const areas = [
    {
        name: 'De veluwe',
        animals: [],
        collected: [],
        images: {
            0: "/images/Gebieden/0/veluwe0-2.png",
            20: "/images/Gebieden/1/veluwe1.png",
            40: "/images/Gebieden/2/veluwe2.png",
            60: "/images/Gebieden/3/veluwe3.png",
            80: "/images/Gebieden/4/veluwe4.png",
            100: "/images/Gebieden/5/veluwe5.jpg",
        }
    },
    {
        name: 'Zuiderpark (Rotterdam)',
        animals: [],
        collected: [],
        images: {
            0: "/images/Gebieden/0/park0.png",
            20: "/images/Gebieden/1/park1.png",
            40: "/images/Gebieden/2/park2-2.png",
            60: "/images/Gebieden/3/park3.png",
            80: "/images/Gebieden/4/park4-2.png",
            100: "/images/Gebieden/5/park5-2.png",
        }
    },
    {
        name: 'De Biesbosch',
        animals: [],
        collected: [],
        images: {
            0: "/images/Gebieden/0/biesbosch0.png",
            20: "/images/Gebieden/1/biesbosch1.png",
            40: "/images/Gebieden/2/biesbosch2.png",
            60: "/images/Gebieden/3/biesbosch3.png",
            80: "/images/Gebieden/4/biesbosch4.png",
            100: "/images/Gebieden/5/biesbosch5.png",
        }
    },
    {
        name: 'De Waddeneilanden',
        animals: [],
        collected: [],
        images: {
            0: "/images/Gebieden/0/wadden0.png",
            20: "/images/Gebieden/1/wadden1.png",
            40: "/images/Gebieden/2/wadden2.png",
            60: "/images/Gebieden/3/wadden3.png",
            80: "/images/Gebieden/4/wadden4.png",
            100: "/images/Gebieden/5/wadden5.png",
        }
    },
    {
        name: 'Speulderbos',
        animals: [],
        collected: [],
        images: {
            0: "/images/Gebieden/0/speulderbos0.png",
            20: "/images/Gebieden/1/speulderbos1.png",
            40: "/images/Gebieden/2/speulderbos2.png",
            60: "/images/Gebieden/3/speulderbos3.png",
            80: "/images/Gebieden/4/speulderbos4.png",
            100: "/images/Gebieden/5/speulderbos5.png",
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

    const total = area.animals.length;
    const collected = area.collected.length;

    const percent = total === 0 ? 0 : (collected / total) * 100;

    progressBar.style.width = `${percent}%`;
    progressText.textContent = `${collected} / ${total} Verzameld`;

    areaImage.src = getProgressImage(area, percent);
}


// Load animals from server and calculate progress client-side
Promise.all([
    fetch('/api/areas').then(res => res.json()),
    fetch('/api/collected').then(res => res.json())
])
.then(([areasData, collectedData]) => {
    const collectedSpecies = collectedData.collected || [];
    
    // Populate animals from server and calculate collected client-side
    areas.forEach(area => {
        area.animals = areasData.areas[area.name] || [];
        area.collected = area.animals.filter(animal => collectedSpecies.includes(animal));
    });
    
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

// Info content for each area
const areaInfo = [
        {
            name: 'De veluwe',
            text: 'De Veluwe is het grootste natuurgebied in nederland! Gelegen in Gelderland (en een deel van utrecht). Dit natuurgebied is erg populair om te wandelen, fietsen of paardrijden. Ook zijn er wilde dieren te vinden zoals herten, wilde zwijnen en vossen!',
            image: '/images/Gebieden/veluwe.png',
        },

        {
            name: 'Zuiderpark (Rotterdam)',
            text: 'Een van de grootste stadsparken in Nederland! Ideaal om te wandelen, hardlopen of picknicken! Erg gezinsvriendelijk en daarnaast zijn er ook sportvoorzieningen. De beste plek om te zijn als je even de natuur in wil in Rotterdam!',
            image: '/images/Gebieden/Zuiderpark_Rotterdam.png',
        },

        {
            name: 'De Biesbosch',
            text: 'Een groot waterrijk natuurgebied in Noord-Brabant! prachtige zoetwatergetijden, bekend vanwege de bever en diverse andere dieren, en daarnaast perfect om te kanoën, varen, wandelen of fietsen!',
            image: '/images/Gebieden/biesbosch.png',
        },

        {
            name: 'De Waddeneilanden',
            text: 'Een rij aan eilanden in het Noorden van Nederland. De eilanden hebben brede & lange stranden. Ook is de Waddenzee goed te zien vanaf het eiland en bevat het eiland zeehonden, diverse vogelsoorten en unieke plantsoorten. Perfect voor een wandeltocht, strandactiviteiten of kamperen!',
            image: '/images/Gebieden/waaden.png',

        },

        {
            name: 'Speulderbos',
            text: 'Het Speulderbos is een van de meest Sfeervolle bossen in Nederland! Geleden in de Veluwe, De kronkelige bomen en scheefgegroeide bomen geven het bos een sprookjesachtige uitstraling! Ook is er een groot palette aan wildlife te vinden, zoals edelherten, zwijnen en vossen! Dit is het perfecte en allerbeste gebied voor een wandeltocht!',
            image: '/images/Gebieden/bos.png',
        },

    ]
;

// Open modal
infoButton.addEventListener('click', () => {
    const area = areas[currentArea];
    const info = areaInfo.find(a => a.name === area.name);

    modalTitle.textContent = info.name;
    modalText.textContent = info.text;
    modalImg.src = info.image;

    infoModal.classList.remove('hidden');
});


// Close modal
closeModal.addEventListener('click', () => {
    infoModal.classList.add('hidden');
});

