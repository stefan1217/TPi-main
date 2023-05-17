
/**
 * fonction qui permet d'envoiyer les donnés javascript en php via une rêquete HTTP
 * @param {string} categorie // (catégorie d'aliments que le joueur a choisi)
 * @param {int} score // (le score du joueur)
 * @param {int} slice_count // (nombres d'aliments que le joueur a découpé)
 * @param {bool} status  // (partie terminé ou pas)
 */
export function sendDataToPhp(categorie, score, slice_count, status) {
    // Les données à envoiyé
    let dataToSend = JSON.stringify([score, slice_count, status]);
    fetch('../pages/game.php?category=' + categorie, {
        method: 'POST',
        headers: {
            // On indique les headers
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        // On envoie les données
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