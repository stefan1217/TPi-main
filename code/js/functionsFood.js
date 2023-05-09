function methodGet() {
    const config = {
        method: "get",
    };

    fetch("../api/Getfoods.php", config)
        .then(response => { return response.json() })
        .then(json => {
            localStorage.setItem("Foods", JSON.stringify(json.foods));
        });
}

function UpdateUserInformation() {
    const config = {
        method: "get",
    };

    var url = new URL(document.location.href);
    var search_params = new URLSearchParams(url.search);
    //On vérifie si le paramètre id existe dans l'url courante
    if (search_params.has('parentUserId')) {
        var id = search_params.get('parentUserId');
        fetch('../api/GetUsers.php?parentUserId=' + id, config)
            .then(response => { return response.json() })
            .then(json => {
                console.log(json);
            })
            
    }
}







