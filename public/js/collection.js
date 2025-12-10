document.addEventListener('DOMContentLoaded', () => {
    const grid = document.getElementById('animals-grid');
    const regionSelect = document.getElementById('region');

    const modal = document.getElementById("animal-modal");
    const closeModalBtn = document.getElementById("close-modal");

    function openModal(animal) {
        document.getElementById("modal-image").src = animal.image;
        document.getElementById("modal-name").textContent = animal.vernacularName;
        document.getElementById("modal-scientific").textContent = animal.scientificName ?? '-';
        document.getElementById("modal-location").textContent = animal.location ?? '-';
        document.getElementById("modal-beheerder").textContent = animal.beheerder ?? '-';
        document.getElementById("modal-info").textContent = animal.info ?? 'Geen extra informatie beschikbaar';

        modal.classList.add("flex");
        modal.classList.remove("hidden");
    }

    function closeModal() {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    }

    closeModalBtn.addEventListener("click", closeModal);
    modal.addEventListener("click", e => {
        if (e.target === modal) closeModal();
    });

    function createAnimalCard(animal) {
        const card = document.createElement("div");
        card.className = "bg-white rounded shadow p-3 relative cursor-pointer hover:shadow-lg transition";

        const imgSrc = animal.locked ? '/images/locked.png' : animal.image;
        card.innerHTML = `
            <div class="relative">
                <img src="${imgSrc}" class="w-full h-40 object-cover rounded mb-2" />
                ${animal.locked ? '<div class="absolute inset-0 flex items-center justify-center"><span class="text-white text-3xl">🔒</span></div>' : ''}
            </div>
            <h3 class="font-bold text-lg">${animal.vernacularName}</h3>
            <p class="text-sm italic mb-1">Wetenschappelijke naam: ${animal.scientificName ?? '-'}</p>
            <p class="text-sm mb-1">Leefgebied: ${animal.location ?? '-'}</p>
            <p class="text-sm font-medium">Beheerder: ${animal.beheerder ?? '-'}</p>
        `;

        const imgElement = card.querySelector("img");
        const overlay = card.querySelector("div.absolute");

        if (animal.locked) {
            card.addEventListener("click", () => {
                animal.locked = false;
                if (overlay) overlay.remove();
                if (imgElement) imgElement.src = animal.image;

                card.addEventListener("click", () => openModal(animal));
            });
        } else {
            card.addEventListener("click", () => openModal(animal));
        }
        return card;
    }

    async function loadAnimals(region = '') {
        grid.innerHTML = '';
        let url = `/collection`;
        if (region) url += `?region=${encodeURIComponent(region)}`;

        try {
            const res = await fetch(url);
            const animals = await res.json();

            animals.forEach(animal => {
                const card = createAnimalCard(animal);
                grid.appendChild(card);
            });
        } catch (err) {
            console.error(err);
            grid.innerHTML = '<p class="text-red-600">Er is iets misgegaan bij het laden van de dieren.</p>';
        }
    }

    loadAnimals();

    regionSelect.addEventListener("change", () => loadAnimals(regionSelect.value || ''));
});
