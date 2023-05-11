
/**
 * function qui permet d'envoiyer des donnés javascrpit en php via une rêquete Http
 * @param {string} categorie 
 * @param {int} score 
 * @param {int} slice_count 
 * @param {int} time 
 * @param {bool} status 
 */
export function sendDataToPhp(categorie, score, slice_count, time, status) {
    let dataToSend = JSON.stringify([score, slice_count, time, status]);
    fetch('../pages/game.php?category=' + categorie, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
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