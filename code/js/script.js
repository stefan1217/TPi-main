//Déclarations de varaiables
let nbFood = 1;
let Speed = 2;
let Score = 0;
let Slice_count = 0;
let time = 0;
let foods = [];

import { UpdateUserInformation } from "./functionsFood.js";
let isClicked = false;
let FoodList = JSON.parse(localStorage.getItem("Foods"));
let ScoreElement = document.getElementById("score");
let TimerElement = document.getElementById("time");
let GameOverMenu = document.getElementById("game-over-menu");
let GameOverMenuScore = document.getElementById("game-over-menu-score");
let SpeedElement = document.getElementById("speed");
let GameOverMenuButton = document.getElementById("game-over-menu-button");
const Informations = document.getElementById("informations");
let canvas = document.getElementById('canvas');
let ctx = canvas.getContext('2d');

FoodList.push({ category: "malbouffe", name: "Fausse-tomate", picture_path: "Fausse-tomate.png"});
FoodList.push({ category: "malbouffe", name: "Fausse-aubergine", picture_path: "Fausse-aubergine.png"});

canvas.width = window.innerWidth * 0.95;
canvas.height = window.innerHeight * 0.75;
const FoodWidth = canvas.width / 25;
const FoodHeight = canvas.width / 20;
let url = new URL(window.location.href);
let categorie = url.searchParams.get("category");
ScoreElement.innerText = "Score : " + Score;
SpeedElement.innerText = "Vitesse: *" +  Math.round(Speed * 10) / 10;
TimerElement.innerText = "Temps: 0h 0m 0s";

/**
 * function qui permet de récuperer un aliment aléatoire de la liste
 * @param {Array} list 
 * @returns 
 */
function RandomFoodFromList(list) {
  let fruitList = list.filter(item => item.category === categorie);
  if (fruitList.length > 0 && Math.random() < 0.75) { // 75% de chance de tomber sur les aliments de la catégorie choisie 
    return fruitList[Math.floor(Math.random() * fruitList.length)];
  } else {
    return list[Math.floor(Math.random() * list.length)];
  }
}
/** 
 * function qui permet de crée un nouveau aliment
 * @returns food
 */
function createFood() {
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

function sendDataToPhp(Score,Slice_count,time,status) {
  let dataToSend = JSON.stringify([Score, Slice_count, time,status]);
  fetch('../pages/game.php?category='+categorie, {
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
/**
 * function qui permet de dessiner les aliments
 */
function draw() {
  // Effacer le canvas
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  // Dessiner chaque aliment
  for (let i = 0; i < foods.length; i++) {
    const food = foods[i];

    const img = new Image();
    img.src = food.src;
    ctx.drawImage(img, food.x, food.y, food.width, food.height);

    // Faire tomber l'aliment avec la vitesse 
    food.y += food.speed;

    // Si l'aliment atteint le bas de l'écran,on le supprime
    if (food.y > canvas.height - food.height) {
      if (food.category == categorie) {
        Score -= 2;
        if (Score < 0) {
          Score = 0;         
          GameOver();
        }
      }
      
      foods.splice(i, 1);
      ScoreElement.innerText = "Score : " + Score;
      break;
    }
  }

  if(foods.length < nbFood){
    foods.push(createFood());
  }
}


let UpdateInformaions = setInterval(UpdateUserInformation, 1000);
// Fonction pour vérifier si un point est à l'intérieur d'un aliment
function isPointInsideFood(x, y, rect) {
  return x >= rect.x && x <= rect.x + rect.width &&
    y >= rect.y && y <= rect.y + rect.height;
}

canvas.addEventListener('mousemove', mouseAndClickEvent, false);

/**
 * function qui permet de gérer l'évenement click
 * @param {} event 
 */
function mouseAndClickEvent(event) {
  
  // Les coordonnés exacts du curseur
  if(isClicked){
    let clicX = event.offsetX;
    let clicY = event.offsetY;
  // Vérifier si le cursor est à l'intéreur d'un aliment
  for (let i = 0; i < foods.length; i++) {
    let fruit = foods[i];
    if (isPointInsideFood(clicX, clicY, fruit)) {
      // Supprimer l'aliment et on met à jour les informations
      if (fruit.category == categorie) {
        Speed += 0.1;
        Score++;
        nbFood = Math.floor(1+(0.2*(Speed-2)/0.1));
        SpeedElement.innerText = "Vitesse: *" + Math.round(Speed * 10) / 10;
        Slice_count++;
        sendDataToPhp(Score,Slice_count,time,1);
        ScoreElement.innerText = "Score : " + Score;
      } else {
        if (fruit.category == "malbouffe") {
        GameOver();
        }
        Score -= 2;
        Slice_count++;
        if (Score < 0) {
          Score = 0;

          GameOver();
        }
        ScoreElement.innerText = "Score : " + Score;
      }
      
      // Supprimer le fruit du tableau
      foods.splice(i, 1);
      break;
    }
  }
}
}

canvas.addEventListener('mousedown', handleClickEvent, false);

function handleClickEvent(event){
  if(event){
   isClicked = true;
  }
  else{
    isClicked = false;
  }
}

window.addEventListener('resize', resizeCanvas,false);

let drawInterval = setInterval(draw, 10); // Boucle principal
const TimerInterval = setInterval(Timer, 1000);


/**
 * function qui permet de rzise le canvas en fonction de la taille de la fênetre
 */
function resizeCanvas() {
  canvas.width = window.innerWidth * 0.9;
  canvas.height = window.innerHeight * 0.9;
}
/**
 * function qui permet d'affiche le timer 
 */
function Timer() {
  time++;
  var hours = Math.floor(time / 3600);
  var minutes = Math.floor((time - hours * 3600) / 60);
  var seconds = time - hours * 3600 - minutes * 60;
  TimerElement.innerText = "Temps: " + hours + "h " + minutes + "m " + seconds + "s";
}


/**
 * function qui permet d'afficher le menu de la fin du jeu
 */
function GameOver() {
  sendDataToPhp(Score,Slice_count,time,0);
  clearInterval(UpdateInformaions);
  clearInterval(TimerInterval);
  clearInterval(drawInterval);
  canvas.remove();
  GameOverMenu.style.visibility = "visible";
  Informations.style.visibility = "hidden";
  GameOverMenuScore.innerText = "Votre score est de : " + Score;
  GameOverMenuButton.addEventListener('click', function (event) {
    location.href = "./categories.php";
  });
}

window.addEventListener('beforeunload', function(event) {
  sendDataToPhp(Score,Slice_count,time,0);
});





