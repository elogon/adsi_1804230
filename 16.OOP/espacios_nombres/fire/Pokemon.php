<?php

namespace fire;

class Pokemon {
	private $name;
	private $color;

	public function __construct($n, $c){
		$this->name  =$n;
		$this->color =$c;
	}

	public function getInfoPokemon(){
		return "<li class='list-group-item'>".$this->name." | ".$this->color."</li>";
	}
}

?>