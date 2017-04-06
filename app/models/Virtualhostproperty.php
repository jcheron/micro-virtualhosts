<?php
namespace models;

class Virtualhostproperty{
	/**
	 * @id
	*/
	private $idVirtualhost;

	/**
	 * @id
	*/
	private $idProperty;

	private $value;

	private $active;

	private $comment;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\Property","name"=>"idProperty","nullable"=>false)
	*/
	private $property;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\Virtualhost","name"=>"idVirtualhost","nullable"=>false)
	*/
	private $virtualhost;

	 public function getIdVirtualhost(){
		return $this->idVirtualhost;
	}

	 public function setIdVirtualhost($idVirtualhost){
		$this->idVirtualhost=$idVirtualhost;
	}

	 public function getIdProperty(){
		return $this->idProperty;
	}

	 public function setIdProperty($idProperty){
		$this->idProperty=$idProperty;
	}

	 public function getValue(){
		return $this->value;
	}

	 public function setValue($value){
		$this->value=$value;
	}

	 public function getActive(){
		return $this->active;
	}

	 public function setActive($active){
		$this->active=$active;
	}

	 public function getComment(){
		return $this->comment;
	}

	 public function setComment($comment){
		$this->comment=$comment;
	}

	 public function getProperty(){
		return $this->property;
	}

	 public function setProperty($property){
		$this->property=$property;
	}

	 public function getVirtualhost(){
		return $this->virtualhost;
	}

	 public function setVirtualhost($virtualhost){
		$this->virtualhost=$virtualhost;
	}

	public function __toString(){
		return $this->value;
	}
}