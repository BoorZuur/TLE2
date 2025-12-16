document.addEventListener('DOMContentLoaded', () => {
    const grid = document.getElementById('animals-grid');
    const regionSelect = document.getElementById('region');
    const progressBar = document.getElementById('progress-bar');

    const modal = document.getElementById("animal-modal");
    const modalDialog = modal.querySelector('[role="dialog"]');
    const closeModalBtn = document.getElementById("close-modal");

    let lastFocusedElement = null;

    // Modal
    function openModal(animal) {
        lastFocusedElement = document.activeElement;

        document.getElementById("modal-image").src = animal.image;
        document.getElementById("modal-image").alt = `Afbeelding van ${animal.vernacularName}`;
        document.getElementById("modal-name").textContent = animal.vernacularName;
        document.getElementById("modal-scientific").textContent = animal.scientificName ?? '-';
        document.getElementById("modal-location").textContent = animal.location ?? '-';
        document.getElementById("modal-beheerder").textContent = animal.beheerder ?? '-';
        document.getElementById("modal-info").textContent =
            animal.info ?? 'Geen extra informatie beschikbaar';

        modal.classList.remove("hidden");
        modal.classList.add("flex");

        closeModalBtn.focus();

        // Focus trap
        trapFocus(modal);
    }

    function closeModal() {
        modal.classList.add("hidden");
        modal.classList.remove("flex");

        // Restore focus
        if (lastFocusedElement) lastFocusedElement.focus();
    }

    closeModalBtn.addEventListener("click", closeModal);
    modal.addEventListener("click", e => {
        if (e.target === modal) closeModal();
    });
    document.addEventListener("keydown", e => {
        if (e.key === "Escape" && !modal.classList.contains("hidden")) closeModal();
    });

    function trapFocus(container) {
        const focusableSelectors = 'a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex="0"], [contenteditable]';
        const focusableEls = Array.from(container.querySelectorAll(focusableSelectors));
        const firstEl = focusableEls[0];
        const lastEl = focusableEls[focusableEls.length - 1];

        container.addEventListener("keydown", e => {
            if (e.key === "Tab") {
                if (e.shiftKey) {
                    if (document.activeElement === firstEl) {
                        e.preventDefault();
                        lastEl.focus();
                    }
                } else {
                    if (document.activeElement === lastEl) {
                        e.preventDefault();
                        firstEl.focus();
                    }
                }
            }
        });
    }

    // Progress bar
    function updateProgressBar(animals, region) {
        const total = animals.length;
        const owned = animals.filter(a => !a.locked).length;
        const percentage = total > 0 ? (owned / total) * 100 : 0;
        const regionText = region ? ` in ${region}` : '';

        progressBar.innerHTML = `
            <div style="margin-top:10px;">
                <div style="display:flex;justify-content:space-between;margin-bottom:5px;font-size:14px;">
                    <span>Animals Owned${regionText}: ${owned}/${total}</span>
                    <span>${percentage.toFixed(1)}%</span>
                </div>
                <div role="progressbar"
                     aria-valuenow="${owned}"
                     aria-valuemin="0"
                     aria-valuemax="${total}"
                     aria-label="Voortgang van verzameling${regionText}"
                     style="width:100%;height:24px;background-color:#e0e0e0;border-radius:12px;overflow:hidden;">
                    <div style="height:100%;background-color:#2e7d32;width:${percentage}%;transition:width 0.3s ease;"></div>
                </div>
            </div>
        `;
    }

    // Animal cards
    function createAnimalCard(animal) {
        const button = document.createElement("button");
        button.type = "button";
        button.className =
            "bg-white rounded shadow p-3 relative cursor-pointer hover:shadow-lg transition focus:outline-none focus:ring-2 focus:ring-blue-500 text-left";

        button.innerHTML = `
            <div class="relative">
                <img src="${animal.locked ? '/images/locked.png' : animal.image}"
                     class="w-full h-40 object-cover rounded mb-2"
                     alt="${animal.vernacularName}" />
                ${animal.locked ? '<div class="absolute inset-0 flex items-center justify-center" aria-hidden="true"><span class="text-white text-3xl">🔒</span></div>' : ''}
            </div>
            <h3 class="font-bold text-lg">${animal.vernacularName}</h3>
            <p class="text-sm italic mb-1">Wetenschappelijke naam: ${animal.scientificName ?? '-'}</p>
            <p class="text-sm mb-1">Leefgebied: ${animal.location ?? '-'}</p>
            <p class="text-sm font-medium">Beheerder: ${animal.beheerder ?? '-'}</p>
        `;

        if (animal.locked) {
            button.disabled = true;
            button.setAttribute("aria-disabled", "true");
        } else {
            button.setAttribute("aria-label", `Open details voor ${animal.vernacularName}`);
            button.addEventListener("click", () => openModal(animal));
        }

        return button;
    }

    // Load animals
    async function loadAnimals(region = '') {
        grid.innerHTML = '';
        let url = `/collection`;
        if (region) url += `?region=${encodeURIComponent(region)}`;

        try {
            const res = await fetch(url);
            const animals = await res.json();

            animals.forEach(animal => grid.appendChild(createAnimalCard(animal)));
            updateProgressBar(animals, region);
        } catch (err) {
            console.error(err);
            grid.innerHTML =
                '<p class="text-red-600">Er is iets misgegaan bij het laden van de dieren.</p>';
        }
    }

    loadAnimals();

    regionSelect.addEventListener("change", () => {
        loadAnimals(regionSelect.value || '');
    });
});
