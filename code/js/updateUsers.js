/**
 * fonction qui permet de mettre à jour les informations de tous les joueurs présant dans une partie
 */
export function UpdateUsers() {
    const config = {
        method: "get",
    };
    var url = new URL(document.location.href);
    var search_params = new URLSearchParams(url.search);
    //On vérifie si le paramètre id existe dans l'url 
    if (search_params.has('parentUserId')) {
        var id = search_params.get('parentUserId');
        // On récupere le résultat que retourne l'api getUsers
        fetch('../api/getUsers.php?parentUserId=' + id, config)
            .then(response => { return response.json() })
            .then(json => {
                let nicknames = "";
                let time = ""
                json.users.forEach(element => {
                    nicknames += "Joueur: " + element["nickname"] + " Score: " + element["score"]+ "\n";
                    time =  "Temps : " + element["duration"];                  
                });     
                //On affiche les données des utilisateurs        
                document.getElementById("nickaname").innerText = nicknames;
                document.getElementById("time").innerText = time;
                sessionStorage.setItem('ListUsers', JSON.stringify(json.users));
            });        
    }
}
