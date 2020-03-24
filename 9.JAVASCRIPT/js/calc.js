//Variable (Btns)
var display = document.getElementById('display');
var btn7 	= document.getElementById('btn7');
var btn8 	= document.getElementById('btn8');
var btn9 	= document.getElementById('btn9');
var btnMod  = document.getElementById('btnMod');

var btn4  	= document.getElementById('btn4');
var btn5  	= document.getElementById('btn5');
var btn6  	= document.getElementById('btn6');
var btnProd = document.getElementById('btnProd');

var btn1  	= document.getElementById('btn1');
var btn2  	= document.getElementById('btn2');
var btn3  	= document.getElementById('btn3');
var btnSub  = document.getElementById('btnSub');

var btn0  	= document.getElementById('btn0');
var btnDot  = document.getElementById('btnDot');
var btnSum  = document.getElementById('btnSum');
var btnEqual= document.getElementById('btnEqual');

var btnClear  = document.getElementById('btnClear');
var btnAclear = document.getElementById('btnAclear');
var btnDiv    = document.getElementById('btnDiv');

//Variables (lógica)
var lDisplay = 0;
var allowOper = false;

//Eventos (Click)

function validateLength() {
	if(lDisplay <= 15) {
		lDisplay++;
		return true;
	} else {
		return false;
	}
}

function teclado(){
	
}

function addToDisplay(n) {
	if(n.constructor.name == 'Number'){
		allowOper = true;
	
	}
	if(allowOper){
		if(validateLength()) {
			display.innerHTML += n;
			if(n.constructor.name == 'String'){
				allowOper = true;
			}
		}
		
	}
}
btn7.onclick = function() {
	addToDisplay(7);
}
btn8.onclick = function() {
	addToDisplay(8);
}
btn9.onclick = function() {
	addToDisplay(9);
}
btnMod.onclick = function() {
	addToDisplay('%');
}

btn4.onclick = function() {
	addToDisplay(4);
}
btn5.onclick = function() {
	addToDisplay(5);
}
btn6.onclick = function() {
	addToDisplay(6);
}
btnProd.onclick = function() {
	addToDisplay('*');
}
btn1.onclick = function() {
	addToDisplay(1);
}
btn2.onclick = function() {
	addToDisplay(2);
}
btn3.onclick = function() {
	addToDisplay(3);
}
btnSub.onclick = function() {
	addToDisplay('-');
}
btn0.onclick = function() {
	addToDisplay(0);
}
btnDot.onclick = function() {
	addToDisplay('.');
}
btnSum.onclick = function() {
	addToDisplay('+');
}
btnEqual.onclick = function() {
	display.innerHTML= eval(display.value);
	lDisplay = display.value.length;

}
btnClear.onclick = function() {
	display.innerHTML= '';
	lDisplay= 0;
}
btnAClear.onclick = function() {
	if(lDisplay > 0){
		display.value = display.value.slice(0, -1);
		lDisplay--;
	}

}
btnDiv.onclick = function() {
	addToDisplay('/');
}



 
