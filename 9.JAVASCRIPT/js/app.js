// Variables de Tipo Elemento 
var eBrand     = document.getElementById('brand');
var eReference = document.getElementById('reference');
var eModel     = document.getElementById('model');
var eColor     = document.getElementById('color');
var eCc        = document.getElementById('cc');
var eType      = document.getElementById('type');
var sstart     = document.getElementById('start');
var sengine    = document.getElementById('engine')
var vhc        = document.getElementById('vhc');
var path 	   = document.getElementById('path');

// Variables Botones 
var btnOn       = document.getElementById('btnOn');
var btnOff      = document.getElementById('btnOff');
var btnStop     = document.getElementById('btnStop');
var btnForward  = document.getElementById('btnForward');
var btnBackward = document.getElementById('btnBackward');

// Variables Lógicas 
var stateEngine = false;
var statePath   = false;

// Objeto
var vehicle = {
	// Atributos 
	brand: 'Audi',
	reference : 'S8 Plus',
	model: 2017,
	color : 'Amarillo',
	cc: 1.8,
	type: 'Deportivo',

	// Métodos 
	showInfo: function() {
		eBrand.innerHTML = this.brand;
		eReference.innerHTML = this.reference;
		eModel.innerHTML = this.model;
		eColor.innerHTML = this.color;
		eCc.innerHTML = this.cc;
		eType.innerHTML = this.type;

	},
	on: function() {
		//alert('On');
		if(stateEngine == false){
			sstart.play();
			vhc.classList.add('on');
			stateEngine = true;
		}
	},
	off: function() {
		//alert('Off');
		if(statePath == false){ 
		sstart.pause();
		sstart.currentTime = 0;
		sengine.pause();
		sengine.currentTime = 0;
		vhc.classList.remove('on');

		stateEngine = false;
		}
	},
	stop: function() {
		//alert('Stop');
		if(statePath == true) {
			path.classList.add('stop');
			statePath = false;
		}
	},
	forward: function () {
		//alert('Forward');
		if(stateEngine == true)
		sengine.play();
		path.classList.remove('stop');
		path.classList.remove('backward');
		path.classList.add('forward');
		statePath = true;
	},
	backward: function() {
		//alert ('Backward');
		if(stateEngine == true) {
			path.classList.add('backward');
		}
	}
};

vehicle.showInfo();
btnOn.onclick = function() {
	vehicle.on();
}
btnOff.onclick = function() {
	vehicle.off();
}
btnStop.onclick = function() {
	vehicle.stop();
}
btnForward.onclick = function() {
	vehicle.forward();
}
btnBackward.onclick = function() {
	vehicle.backward();
}
