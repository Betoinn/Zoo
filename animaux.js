document.addEventListener("DOMContentLoaded", function () {
    const biomesContainer = document.getElementById("biomes-container");
    const popup = document.getElementById("popup");
    const popupTitle = document.getElementById("popup-title");
    const popupStatus = document.getElementById("popup-status");
    const closePopup = document.getElementById("close-popup");

    // Récupérer les données depuis animaux.php
    fetch("animaux.php")
        .then((response) => response.json())
        .then((biomes) => {
            biomes.forEach((biome) => {
                // Section du biome
                const biomeSection = document.createElement("div");
                biomeSection.innerHTML = `<h2 style="color: ${biome.couleur};">${biome.nom}</h2>`;
                biomeSection.classList.add("biome-section");

                const enclosContainer = document.createElement("div");
                enclosContainer.classList.add("enclos-container");

                // Ajout des enclos
                Object.values(biome.enclos).forEach((enclos) => {
                    const enclosDiv = document.createElement("div");
                    enclosDiv.classList.add("enclos");
                    enclosDiv.innerHTML = `
                        <img src="images/${enclos.nom}.jpg" alt="${enclos.nom}" />
                        <p>${enclos.nom}</p>
                    `;
                    enclosDiv.addEventListener("click", () => openPopup(enclos));
                    enclosContainer.appendChild(enclosDiv);
                });

                biomeSection.appendChild(enclosContainer);
                biomesContainer.appendChild(biomeSection);
            });
        });

    // Fonction pour ouvrir le pop-up
    function openPopup(enclos) {
        popupTitle.textContent = `${enclos.nom}`;
        popupStatus.textContent = `Statut : ${enclos.statut}`;
        popup.classList.remove("hidden");
    }

    // Fermer le pop-up
    closePopup.addEventListener("click", () => {
        popup.classList.add("hidden");
    });
});