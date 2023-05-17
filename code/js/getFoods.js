/**
 * fonction qui permet de stocker tous les aliments dans le localStorage
 */
function GetAllFood() {
    const config = {
        method: "get",
    };

    fetch("./api/getFoods.php", config)
        .then(response => { return response.json() })
        .then(json => {
            // On stocke la liste des aliments dans une variable localstorage
            localStorage.setItem("Foods", JSON.stringify(json.foods));
        });
}









