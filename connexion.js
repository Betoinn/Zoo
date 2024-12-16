<script>
    // Fonction pour lire un cookie
    function getCookie(name) {
        let cookieArr = document.cookie.split(";"); // Obtenir tous les cookies
        for (let i = 0; i < cookieArr.length; i++) {
            let cookiePair = cookieArr[i].split("=");

            // Supprimer les espaces avant le nom du cookie et le comparer
            if (name === cookiePair[0].trim()) {
                return decodeURIComponent(cookiePair[1]); // Retourne la valeur du cookie
            }
        }
        return null; // Si le cookie n'existe pas
    }

    // Vérifier si l'utilisateur est connecté
    const nomUtilisateur = getCookie("nom_utilisateur");

    // Gestion du clic sur "Se connecter"
    const loginContainer = document.getElementById("login-container");
    loginContainer.addEventListener("click", function (event) {
        if (!nomUtilisateur) {
            // Si l'utilisateur n'est pas connecté, empêcher la navigation et actualiser la page
            event.preventDefault();
            window.location.reload(); // Actualise la page
        }
    });
</script>