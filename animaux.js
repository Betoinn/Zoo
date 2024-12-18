fetch('animaux.php')
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('enclos-list');
        container.innerHTML = '';  // Nettoyage du container

        Object.keys(data).forEach(biome => {
            // Ajouter le titre du biome
            const biomeTitle = document.createElement('h2');
            biomeTitle.textContent = biome;
            biomeTitle.classList.add('text-center', 'my-4');
            container.appendChild(biomeTitle);

            // Div pour les enclos en ligne
            const enclosRow = document.createElement('div');
            enclosRow.classList.add('row', 'gy-3', 'gx-3');  // Bootstrap Grid
            container.appendChild(enclosRow);

            Object.values(data[biome]).forEach(enclos => {
                const enclosCol = document.createElement('div');
                enclosCol.classList.add('col-2', 'text-center');

                

                // Image cliquable
                const enclosImg = document.createElement('img');
                enclosImg.src = enclos.image_enclos;
                enclosImg.alt = enclos.nom_enclos;
                enclosImg.classList.add('img-fluid', 'rounded', 'clickable');
                enclosImg.style.cursor = 'pointer';

                // Nom de l'enclos
                const enclosName = document.createElement('p');
                enclosName.textContent = enclos.nom_enclos;

                // Événement pour ouvrir le pop-up
                enclosImg.addEventListener('click', () => openPopup(enclos));

                enclosCol.appendChild(enclosImg);
                enclosCol.appendChild(enclosName);
                enclosRow.appendChild(enclosCol);
            });
        });
    });

// Fonction pour ouvrir le pop-up
function openPopup(enclos) {
    const modal = new bootstrap.Modal(document.getElementById('modal'));
    const modalBody = document.querySelector('.modal-body');
    modalBody.innerHTML = '';

    // Nom de l'enclos
    const enclosName = document.createElement('h3');
    enclosName.textContent = enclos.nom_enclos;
    modalBody.appendChild(enclosName);

    // Statut de l'enclos
    const statut = document.createElement('p');
    statut.textContent = `Statut : ${enclos.statut}`;
    modalBody.appendChild(statut);

    // Carrousel des animaux
    const carouselDiv = document.createElement('div');
    carouselDiv.classList.add('carousel', 'slide');
    carouselDiv.id = 'carouselAnimaux';

    const carouselInner = document.createElement('div');
    carouselInner.classList.add('carousel-inner');
    carouselDiv.appendChild(carouselInner);

    enclos.animaux.forEach((animal, index) => {
        const carouselItem = document.createElement('div');
        carouselItem.classList.add('carousel-item', index === 0 ? 'active' : '');

        const img = document.createElement('img');
        img.src = animal.image_animal;
        img.alt = animal.nom_animal;
        img.classList.add('d-block', 'w-100');

        carouselItem.appendChild(img);
        carouselInner.appendChild(carouselItem);
    });

    // Boutons de navigation
    carouselDiv.innerHTML += `
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselAnimaux" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselAnimaux" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
    `;

    modalBody.appendChild(carouselDiv);
    modal.show();
}