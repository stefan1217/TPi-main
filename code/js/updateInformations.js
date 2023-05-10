function methodGet() {
    const config = {
        method: "get",
    };

    fetch("./api/Getfoods.php", config)
        .then(response => { return response.json() })
        .then(json => {

            localStorage.setItem("Foods", JSON.stringify(json.foods));
        });
}