/**
 * fonction qui permet de mettre à jour les informations de tous les joueurs présant dans une partie
 */
export function updateUsers() {
    const config = {
        method: "get",
    };
    var url = new URL(document.location.href);
    var search_params = new URLSearchParams(url.search);
    // On vérifie si le paramètre id existe dans l'url 
    if (search_params.has('parentUserId')) {
        var id = search_params.get('parentUserId');
        // On récupere le résultat que retourne l'api getUsers
        fetch('../api/getUsers.php?parentUserId=' + id, config)
            .then(response => { return response.json() })
            .then(json => {
                let nicknames = "";
                let time = ""
                json.users.forEach(element => {
                    nicknames += "Joueur: " + element["nickname"] + " Score: " + element["score"] + "\n";
                    time = element["date_start"];
                });
                // On affiche les données des utilisateurs        
                document.getElementById("nickaname").innerText = nicknames;
                let now = new Date();
                let date_start = new Date(time);

                // Calculer la différence en millisecondes entre la date de début de la partie et la date actuelle
                let difference = now.getTime() - date_start.getTime();

                // Convertir la différence en millisecondes en secondes, minutes, heures
                let seconds = Math.floor(difference / 1000);
                let minutes = Math.floor(seconds / 60);
                let hours = Math.floor(minutes / 60);

                // Calculer le temps restant dans chaque unité
                let GameSeconds = seconds % 60;
                let GameMinutes = minutes % 60;
                let GameHours = hours % 24;

                // On affiche le temps écoulé depuis le début de la partie
                document.getElementById("time").innerText = "Temps : " + GameHours + ":" + GameMinutes + ":" + GameSeconds;
                sessionStorage.setItem('ListUsers', JSON.stringify(json.users));
            });
    }
}
