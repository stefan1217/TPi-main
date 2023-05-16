
/**
 * fonction qui permet d'envoiyer les donnés javascript en php via une rêquete HTTP
 * @param {string} categorie 
 * @param {int} score 
 * @param {int} slice_count 
 * @param {bool} status 
 */
export function sendDataToPhp(categorie, score, slice_count, status) {
    let dataToSend = JSON.stringify([score, slice_count, status]);
    fetch('../pages/game.php?category=' + categorie, {
        method: 'POST',
        headers: {
            //On indique les headers
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        // Envoie des données
        body: 'data=' + encodeURIComponent(dataToSend)
    })
        .then(response => response.text())
        .then(result => {
            document.getElementById("result").innerHTML = result;
        })
        // S'il y a une erreur on l'affiche dans la console
        .catch(error => {
            console.error('Erreur:', error);
        });
}