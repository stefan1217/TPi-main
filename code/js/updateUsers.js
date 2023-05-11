/**
 * function qui permet de mettre à jour les informations de tous les joueurs présant dans la partie
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
        fetch('../api/getUsers.php?parentUserId=' + id, config)
            .then(response => { return response.json() })
            .then(json => {
                let nicknames = "";
                let Scores = "";
                json.users.forEach(element => {
                    nicknames += element["nickname"] + " ";
                    Scores += element["score"] + " ";
                });              
                document.getElementById("nickaname").innerText ="Joueurs : " + nicknames;
                document.getElementById("score").innerText ="Scores : " + Scores;
                sessionStorage.setItem('ListUsers', JSON.stringify(json.users));
            });        
    }
}
