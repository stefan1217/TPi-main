let SpwanningTime = 2500;
let Speed = 2;
let Score = 0;
let Slice_count = 0;
let time = 0;
let foods = [];

let FoodList = JSON.parse(localStorage.getItem("Foods"));
let ScoreElement = document.getElementById("score");
let TimerElement = document.getElementById("time");
let GameOverMenu = document.getElementById("game-over-menu");
let GameOverMenuScore = document.getElementById("game-over-menu-score");
let GameOverMenuButton = document.getElementById("game-over-menu-button");
const Informations = document.getElementById("informations");
let canvas = document.getElementById('canvas');
let ctx = canvas.getContext('2d');

FoodList.push({ category: "malbouffe", name: "Fausse-tomate", picture_path: "Fausse-tomate.png" });
FoodList.push({ category: "malbouffe", name: "Fausse-aubergine", picture_path: "Fausse-aubergine.png" });

canvas.width = window.innerWidth * 0.95;
canvas.height = window.innerHeight * 0.75;
const FoodWidth = canvas.width / 25;
const FoodHeight = canvas.width / 20;
let url = new URL(window.location.href);
let categorie = url.searchParams.get("categorie");
ScoreElement.innerText = "Score : " + Score;
let collisionDetected = false;
TimerElement.innerText = "Temps: 0h 0m 0s";




function RandomFoodFromList(list) {
  let fruitList = list.filter(item => item.category === categorie);
  if (fruitList.length > 0 && Math.random() < 0.75) {
    return fruitList[Math.floor(Math.random() * fruitList.length)];
  } else {
    return list[Math.floor(Math.random() * list.length)];
  }
}

function createImage() {
  let randomFood = RandomFoodFromList(FoodList);
  const food = {
    x: Math.random() * Math.floor(Math.random() * (canvas.width - (FoodHeight) - FoodWidth)) + FoodWidth, // position x aléatoire
    y: -FoodHeight,
    width: FoodWidth,
    height: FoodHeight,
    src: "../sprites/" + randomFood.picture_path,
    speed: Speed,
    name: randomFood.name,
    category: randomFood.category,
  };
  return food;
}


// Fonction pour dessiner les aliments
function draw() {
  // Effacer le canevas
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  // Dessiner chaque aliment
  for (let i = 0; i < foods.length; i++) {
    const image = foods[i];
    const img = new Image();
    img.src = image.src;
    ctx.drawImage(img, image.x, image.y, image.width, image.height);

    // Faire tomber l'aliment avec la vitesse 
    image.y += image.speed;

    // Si l'aliment atteint le bas de l'écran, la supprimer
    if (image.y > canvas.height - image.height) {
      if (image.category == categorie) {
        Score -= 2;
        if (Score < 0) {
          Score = 0;
          sendDataToPhp();
          GameOver();
        }
      }
      sendDataToPhp();
      foods.splice(i, 1);
      ScoreElement.innerText = "Score : " + Score;
      break;
    }
  }
  // Vérifie si le nombre d'aliment qui tombent en même temps ne depasse pas la valeur de la variable
}

function drawFruit() {
  foods.push(createImage());
}

let spawnInterval = setInterval(drawFruit, SpwanningTime);
// Fonction pour vérifier si un point est à l'intérieur d'un rectangle
function isPointInsideRect(x, y, rect) {
  return x >= rect.x && x <= rect.x + rect.width &&
    y >= rect.y && y <= rect.y + rect.height;
}

// Fonction pour traiter l'événement de clic
function handleClickEvent(event) {
  // Arrêter le dessin des fruits 

  // Obtenir les coordonnées du clic
  let clicX = event.offsetX;
  let clicY = event.offsetY;

  // Vérifier si le clic est sur un fruit
  for (let i = 0; i < foods.length; i++) {
    let fruit = foods[i];
    if (isPointInsideRect(clicX, clicY, fruit)) {
      // Supprimer le fruit du tableau "foods" et mettre à jour le score en fonction de sa catégorie
      if (fruit.category == categorie) {
        Speed += 0.1
        SpwanningTime * 0.8;
        Score++;
        Slice_count++;

        sendDataToPhp();
        ScoreElement.innerText = "Score : " + Score;
      } else {
        Score -= 2;
        Slice_count++;
        if (Score < 0) {
          Score = 0;
          GameOver();
        }
        sendDataToPhp();
        ScoreElement.innerText = "Score : " + Score;
      }

      // Vérifier si le fruit est de la catégorie "malbouffe"
      if (fruit.category == "malbouffe") {
        sendDataToPhp();
        GameOver();
      }

      // Supprimer le fruit du tableau
      foods.splice(i, 1);
      break;
    }
  }
}

// Ajouter l'événement de clic à l'élément canvas
canvas.addEventListener('click', handleClickEvent, false);

drawFruit();
drawInterval = setInterval(draw, 10);



function sendDataToPhp() {
  let dataToSend = JSON.stringify([Score, Slice_count, time]);
  fetch('../pages/game.php?categorie=' + categorie, {
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
    .catch(error => {
      console.error('Erreur:', error);
    });
}

window.addEventListener('resize', resizeCanvas);


function resizeCanvas() {
  canvas.width = window.innerWidth * 0.9;
  canvas.height = window.innerHeight * 0.9;
}

function Timer() {
  time++;
  var hours = Math.floor(time / 3600);
  var minutes = Math.floor((time - hours * 3600) / 60);
  var seconds = time - hours * 3600 - minutes * 60;
  TimerElement.innerText = "Temps: " + hours + "h " + minutes + "m " + seconds + "s";
}

const TimerInterval = setInterval(Timer, 1000);

function GameOver() {
  clearInterval(spawnInterval);
  clearInterval(TimerInterval);
  clearInterval(drawInterval);
  canvas.remove();
  GameOverMenu.style.visibility = "visible";
  Informations.style.visibility = "hidden";
  GameOverMenuScore.innerText = "Votre score est de : " + Score;
  GameOverMenuButton.addEventListener('click', function (event) {
    location.href = "./game.php?categorie=" + categorie;
  });
}
