const regionSelect = document.querySelector('#region');
document.addEventListener('DOMContentLoaded', () => {
    const tbody = document.querySelector('tbody'); // ← belangrijk!
    const regionSelect = document.querySelector('#region');

    regionSelect.addEventListener('change', () => {
        const selectedRegion = regionSelect.value || null;
        loadAnimals(selectedRegion);
    });

    async function loadAnimals(region = null) {
        tbody.innerHTML = '';
        let url = '/api/animals';
        if (region) url += `?region=${encodeURIComponent(region)}`;

        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const animals = await response.json();

            animals.forEach(animal => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${animal.vernacularName ?? 'Onbekend'}</td>
                    <td>${animal.scientificName ?? 'Onbekend'}</td>
                    <td>${animal.location ?? 'Onbekend'}</td>
                `;
                tbody.appendChild(tr);
            });

        } catch (error) {
            console.error('Error while loading animals:', error);
        }
    }

    loadAnimals();
});
