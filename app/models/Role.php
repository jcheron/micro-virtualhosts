<?php
namespace models;
class Role{
	/**
	 * @id
	*/
	private $id;

	private $name;

	/**
	 * @oneToMany("mappedBy"=>"role","className"=>"models\User")
	*/
	private $users;

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

	 public function getUsers(){
		return $this->users;
	}

	 public function setUsers($users){
		$this->users=$users;
	}

	public function __toString(){
		return $this->name;
	}
}