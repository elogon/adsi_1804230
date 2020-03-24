// Variables
var pig     = document.getElementById('pig');
var time    = document.getElementById('time');
var score   = document.getElementById('score');
var list    = document.getElementById('list');
var btnPlay = document.getElementById('btnPlay');
var foods   = document.getElementsByClassName('food');
var snbg    = document.getElementById('soundBg');
var snbt    = document.getElementById('soundBite');
var ps      = [0, 100, 200, 300, 400, 500];
var food    = ['apple', 'banana', 'burger', 'chicken', 'fish', 'icecream', 'meat', 'soup'];
var psX     = 0;
var psY     = 0;
var psc     = 0;
var player  = '';
var arrBestScores = new Array();
var idx = new Array();
var irf = null;

// Almacenamiento Local
// if(localStorage.getItem("players") === null) {
// 	localStorage.removeItem("players");
// 	localStorage.removeItem("scores");
// 	var arrplayers = new Array();
// 	var arrscores  = new Array();
// } else {
// 	var arrplayers = JSON.parse(localStorage.getItem("players"));
// 	var arrscores  = JSON.parse(localStorage.getItem("scores"));
// }

// Mostrar Mejores Puntajes
//showScores();

// Eventos
btnPlay.onclick = function() {
	player = document.getElementById('player').value;
	if(player.length > 0) {
		this.parentElement.style.display = "none";
		initGame();
	} else {
		alert('Debe ingresar el nombre del jugador!');
	}
}

// Funciones

// Iniciar Juego
function initGame() {
	soundBg();
	randomPig();
	gameTime();
	movePig();
	irf = setInterval(randomFood, 1000);
}
// Posición Inicial Aleatoria del Cerdo
function randomPig() {
	psX = randomPosition();
	psY = randomPosition();
	pig.style.top  = psY+"px";
	pig.style.left = psX+"px";
}
// Retorna posicion aleatoria entre la tabla
function randomPosition() {
	var rnd = Math.round(Math.random()*ps.length);
	return ps[rnd];
}
// Muestra el conteo regresivo
function gameTime() {
	var ct = 30;
	var igt = setInterval(function() {
		if(ct == 0) {
			// EndGame
			time.innerHTML = ct;
			clearInterval(igt);
			endGame();
		} else {
			time.innerHTML = ct;
		}
		ct--;
	},1000);
} 
// Permite mover el cerdo
function movePig() {
	document.onkeydown = function(evt) {
		pig.classList.remove('eat');
		switch(evt.keyCode) {
			// Left
			case 37:
				//console.log("left")
				if(psX > 0) {
					psX -= 100;
					pig.style.left = psX+"px";
				}
				break;
			// Up
			case 38:
				//console.log("up")
				if(psY > 0) {
					psY -= 100;
					pig.style.top = psY+"px";
				}
				break;	
			// Right
			case 39:
				//console.log("right")
				if(psX < 500) {
					psX += 100;
					pig.style.left = psX+"px";
				}
				break;	
			// Down
			case 40:
				//console.log("down")
				if(psY < 500) {
					psY += 100;
					pig.style.top = psY+"px";
				}
				break;			
		}
	}
}
// Comida en posiciones aleatorias en el tablero
function randomFood() {
	for(var i=0; i<3; i++) {
		var rfood = Math.floor(Math.random()*food.length);
		foods[i].className = 'food';
		foods[i].classList.add(food[rfood]);
		foods[i].style.top  = randomPosition()+"px";
		foods[i].style.left = randomPosition()+"px";
		checkEat(pig, foods[i]);
	}
}
// Verificar si el cerdo ha comido
function checkEat(elm1, elm2) {
    elm1top    = elm1.offsetTop;
    elm1left   = elm1.offsetLeft;
    elm1right  = Number(elm1.offsetLeft) + Number(elm1.offsetWidth);
    elm1bottom = Number(elm1.offsetTop)  + Number(elm1.offsetHeight);

    elm2top    = elm2.offsetTop;
    elm2left   = elm2.offsetLeft;
    elm2right  = Number(elm2.offsetLeft) + Number(elm2.offsetWidth);
    elm2bottom = Number(elm2.offsetTop)  + Number(elm2.offsetHeight);

    if (elm1right  > elm2left   && 
        elm1left   < elm2right  && 
        elm1top    < elm2bottom && 
        elm1bottom > elm2top ) {
    		psc += 10;
            score.innerHTML = psc;
            soundBite();
            pig.classList.add('eat');
        }
}	
// Finaliar el juego
function endGame() {
	soundOff();
	clearInterval(irf);
	alert("Player: "+player+"\n\nScore: "+psc);
	//arrplayers.push(player);
	//arrscores.push(psc);
	//localStorage.setItem("players", JSON.stringify(arrplayers));
	//localStorage.setItem("scores", JSON.stringify(arrscores));
	window.location.replace('index.html');
}
// Mostrar mejores puntajes
function showScores() {
	arrBestScores = JSON.parse(localStorage.getItem("scores"));
	arrBestScores.sort(function(a, b){
		return b-a}
	);
	indexArray();
	for (var i=0; i <= 4; i++) {
		var ibp = idx[i];
		if(arrBestScores[i] != undefined) {
			list.innerHTML += "<li> "+arrplayers[ibp]+" \
							   ("+arrBestScores[i]+")</li>";
		}
	}
}
// Guarda los indices de los puntajes
function indexArray() {
	var len = arrscores.length;
	idx = new Array(len);
	for (var i=0; i<len; ++i) {
		idx[i] = i;
	} 
	idx.sort(function (a, b) { 
		return arrscores[a] > arrscores[b] ? -1 : arrscores[a] < arrscores[b] ? 1 : 0; 
	});
	//console.log(idx);
}
function soundBite() {
	snbt.play();
	setTimeout(function() {
		snbt.pause();
		snbt.currentTime = 0;
	},500);
}
function soundBg() {
	snbg.play();
}
function soundOff() {
	snbg.pause();
	snbg.currentTime = 0;
	snbt.pause();
	snbt.currentTime = 0;
}