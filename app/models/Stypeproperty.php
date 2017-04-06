<?php
namespace models;

class Stypeproperty{
	/**
	 * @id
	*/
	private $idStype;

	/**
	 * @id
	*/
	private $idProperty;

	private $name;

	private $template;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\Property","name"=>"idProperty","nullable"=>false)
	*/
	private $property;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\Stype","name"=>"idStype","nullable"=>false)
	*/
	private $stype;

	 public function getIdStype(){
		return $this->idStype;
	}

	 public function setIdStype($idStype){
		$this->idStype=$idStype;
	}

	 public function getIdProperty(){
		return $this->idProperty;
	}

	 public function setIdProperty($idProperty){
		$this->idProperty=$idProperty;
	}

	 public function getName(){
		return $this->name;
	}

	 public function setName($name){
		$this->name=$name;
	}

	 public function getTemplate(){
		return $this->template;
	}

	 public function setTemplate($template){
		$this->template=$template;
	}

	 public function getProperty(){
		return $this->property;
	}

	 public function setProperty($property){
		$this->property=$property;
	}

	 public function getStype(){
		return $this->stype;
	}

	 public function setStype($stype){
		$this->stype=$stype;
	}

	public function __toString(){
		return $this->name;
	}

}