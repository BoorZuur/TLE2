document.addEventListener('DOMContentLoaded', () => {
    async function fetchAnimals() {
        const regions = ['area1', 'area2', 'area3'];
        let allAnimals = [];

        for (const region of regions) {
            try {
                const response = await fetch(`/api/animals?region=${encodeURIComponent(region)}`);
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                const data = await response.json();
                allAnimals = allAnimals.concat(data);
            } catch (error) {
                console.error('Error while loading animals:', error);
            }
        }

        const tbody = document.querySelector('tbody');
        allAnimals.forEach(animal => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${animal.vernacularName ?? 'Onbekend'}</td>
                <td>${animal.scientificName ?? 'Onbekend'}</td>
                <td>${animal.location ?? 'Onbekend'}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    fetchAnimals();
});
