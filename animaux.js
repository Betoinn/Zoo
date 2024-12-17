fetch('animaux.php')
    .then(response => response.json())
    .then(data => {
        data.forEach(enclos => {
            // Créer la structure pour chaque enclos
            const enclosDiv = document.createElement('div');
            enclosDiv.classList.add('enclos');

            // Ajouter l'image de l'enclos
            const enclosImage = document.createElement('img');
            enclosImage.src = enclos.image_enclos;
            enclosImage.alt = enclos.nom_enclos;
            enclosImage.classList.add('img-fluid');
            enclosDiv.appendChild(enclosImage);

            // Ajouter le nom de l'enclos
            const enclosName = document.createElement('h3');
            enclosName.textContent = enclos.nom_enclos;
            enclosDiv.appendChild(enclosName);

            // Créer le bouton pour ouvrir le carrousel du pop-up
            enclosImage.addEventListener('click', () => {
                openPopup(enclos);
            });

            // Ajouter l'enclos à la page
            document.getElementById('enclos-list').appendChild(enclosDiv);
        });
    });

// Fonction pour ouvrir le pop-up avec le carrousel des animaux
function openPopup(enclos) {
    const modal = new bootstrap.Modal(document.getElementById('modal'));
    const modalBody = document.querySelector('.modal-body'); // Sélectionner correctement la section du modal

    // Réinitialiser le contenu du modal
    modalBody.innerHTML = '';

    // Ajouter l'image de l'enclos
    const enclosImage = document.createElement('img');
    enclosImage.src = enclos.image_enclos ? enclos.image_enclos : 'images/enclos/default-enclos.jpg';
    enclosImage.alt = enclos.nom_enclos;
    enclosImage.classList.add('img-fluid');
    modalBody.appendChild(enclosImage);
    console.log(enclos.image_enclos);  // Vérifier l'URL de l'image dans la console

    

    // Ajouter le nom de l'enclos
    const enclosName = document.createElement('h3');
    enclosName.textContent = enclos.nom_enclos;
    modalBody.appendChild(enclosName);

    // Créer le carrousel des animaux
    const carouselDiv = document.createElement('div');
    carouselDiv.id = 'carousel';
    carouselDiv.classList.add('carousel', 'slide');
    carouselDiv.setAttribute('data-bs-ride', 'carousel');

    const carouselInner = document.createElement('div');
    carouselInner.classList.add('carousel-inner');
    carouselDiv.appendChild(carouselInner);

    // Ajouter les animaux dans le carrousel
    enclos.animaux.forEach((animal, index) => {
        const carouselItem = document.createElement('div');
        carouselItem.classList.add('carousel-item');
        if (index === 0) {
            carouselItem.classList.add('active');
        }

        const animalImage = document.createElement('img');
        animalImage.src = animal.image_animal;
        animalImage.alt = animal.nom_animal;
        animalImage.classList.add('d-block', 'w-100');
        carouselItem.appendChild(animalImage);
        carouselInner.appendChild(carouselItem);
    });

    // Ajouter les boutons de navigation du carrousel
    const prevButton = document.createElement('button');
    prevButton.classList.add('carousel-control-prev');
    prevButton.setAttribute('type', 'button');
    prevButton.setAttribute('data-bs-target', '#carousel');
    prevButton.setAttribute('data-bs-slide', 'prev');
    prevButton.innerHTML = `<span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Précédent</span>`;
    carouselDiv.appendChild(prevButton);

    const nextButton = document.createElement('button');
    nextButton.classList.add('carousel-control-next');
    nextButton.setAttribute('type', 'button');
    nextButton.setAttribute('data-bs-target', '#carousel');
    nextButton.setAttribute('data-bs-slide', 'next');
    nextButton.innerHTML = `<span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Suivant</span>`;
    carouselDiv.appendChild(nextButton);

    // Ajouter le carrousel au modal
    modalBody.appendChild(carouselDiv);

    // Afficher le modal
    modal.show();
}