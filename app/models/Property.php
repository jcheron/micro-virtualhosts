<?php
namespace models;
class Property{
	/**
	 * @id
	*/
	private $id;

	private $name;

	private $description;

	private $prority;

	private $required;

	/**
	 * @oneToMany("mappedBy"=>"property","className"=>"models\Stypeproperty")
	*/
	private $stypepropertys;

	/**
	 * @oneToMany("mappedBy"=>"property","className"=>"models\Virtualhostproperty")
	*/
	private $virtualhostpropertys;

	 public function getId(){
		return $this->id;
	}

	 public function setId($id){
		$this->id=$id;
	}

	 public function getName(){
		return $this->name;
	}

	 public function setName($name){
		$this->name=$name;
	}

	 public function getDescription(){
		return $this->description;
	}

	 public function setDescription($description){
		$this->description=$description;
	}

	 public function getPrority(){
		return $this->prority;
	}

	 public function setPrority($prority){
		$this->prority=$prority;
	}

	 public function getRequired(){
		return $this->required;
	}

	 public function setRequired($required){
		$this->required=$required;
	}

	 public function getStypepropertys(){
		return $this->stypepropertys;
	}

	 public function setStypepropertys($stypepropertys){
		$this->stypepropertys=$stypepropertys;
	}

	 public function getVirtualhostpropertys(){
		return $this->virtualhostpropertys;
	}

	 public function setVirtualhostpropertys($virtualhostpropertys){
		$this->virtualhostpropertys=$virtualhostpropertys;
	}

	public function __toString(){
		return $this->name;
	}
}