document.addEventListener('DOMContentLoaded', () => {
    const grid = document.getElementById('animals-grid');
    const regionSelect = document.getElementById('region');

    async function loadAnimals(region = null) {
        grid.innerHTML = '';
        let url = '/api/animals';
        if (region) url += `?region=${encodeURIComponent(region)}`;

        try {
            const res = await fetch(url);
            const animals = await res.json();

            animals.forEach(a => {
                const card = document.createElement('div');
                card.className = 'bg-white rounded shadow p-4 text-center relative transition-all duration-300';

                const owner = a.owner ?? a.beheerder ?? 'Onbekend';
                const imgSrc = a.image ?? '/images/placeholder.jpg';

                card.innerHTML = `
                    <div class="relative">
                        <img src="${imgSrc}" alt="${a.vernacularName}" class="w-full h-40 object-cover rounded mb-2 brightness-50">
                        ${a.locked ? '<div class="absolute inset-0 flex items-center justify-center bg-black rounded"><span class="text-white text-3xl">🔒</span></div>' : ''}
                    </div>
                    <h3 class="font-bold text-lg">${a.vernacularName}</h3>
                    <p class="italic text-sm mb-1">Wetenschappelijke Naam: ${a.scientificName}</p>
                    <p class="text-sm mb-1">Leefgebied: ${a.location}</p>
                    <p class="text-sm font-medium">Owner: ${owner}</p>
                `;

                // locked cards are greyed out
                if (a.locked) {
                    card.querySelector('img').classList.add('brightness-50');
                }

                // info button
                if (!a.locked) {
                    const infoBtn = document.createElement('button');
                    infoBtn.innerHTML = 'ℹ️';
                    infoBtn.className = 'absolute top-2 right-2 bg-white rounded-full p-1 shadow hover:bg-gray-200 transition';

                    const tooltip = document.createElement('div');
                    tooltip.className = 'absolute top-10 right-2 bg-gray-800 text-white text-xs p-2 rounded shadow hidden z-10 w-44 text-left';
                    tooltip.textContent = a.info ?? 'Geen extra informatie beschikbaar';

                    infoBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        tooltip.classList.toggle('hidden');
                    });

                    // Klik buiten de card → tooltip sluiten
                    document.addEventListener('click', function closeTooltip(e) {
                        if (!card.contains(e.target)) {
                            tooltip.classList.add('hidden');
                        }
                    });

                    card.appendChild(infoBtn);
                    card.appendChild(tooltip);
                }

                // Unlock on click
                card.addEventListener('click', () => {
                    if (a.locked) {
                        a.locked = false;
                        card.querySelector('img').classList.remove('brightness-50');

                        const overlay = card.querySelector('div.absolute');
                        if (overlay) overlay.remove();

                        // Info-knop nu toevoegen nadat het dier unlocked is
                        const infoBtn = document.createElement('button');
                        infoBtn.innerHTML = 'ℹ️';
                        infoBtn.className = 'absolute top-2 right-2 bg-white rounded-full p-1 shadow hover:bg-gray-200 transition';

                        const tooltip = document.createElement('div');
                        tooltip.className = 'absolute top-10 right-2 bg-gray-800 text-white text-xs p-2 rounded shadow hidden z-10 w-44 text-left';
                        tooltip.textContent = a.info ?? 'Geen extra informatie beschikbaar';

                        infoBtn.addEventListener('click', (e) => {
                            e.stopPropagation();
                            tooltip.classList.toggle('hidden');
                        });

                        document.addEventListener('click', function closeTooltip(e) {
                            if (!card.contains(e.target)) {
                                tooltip.classList.add('hidden');
                            }
                        });

                        card.appendChild(infoBtn);
                        card.appendChild(tooltip);
                    }
                });

                grid.appendChild(card);
            });

        } catch (err) {
            console.error(err);
            grid.innerHTML = '<p class="text-red-600">Er is iets misgegaan bij het laden van de dieren.</p>';
        }
    }

    loadAnimals();

    regionSelect.addEventListener('change', () => loadAnimals(regionSelect.value || null));
});
