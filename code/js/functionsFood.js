function methodGet(){
        const config = {
            method: "get",
        };
        
        fetch("../api/foods.php",config)
        .then(response => { return response.json() })
        .then (json => {  
            localStorage.setItem("Foods",JSON.stringify(json.foods));
        });
}




