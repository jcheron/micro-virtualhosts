<?php
namespace models;

class User{
	/**
	 * @id
	*/
	private $id;

	private $login;

	private $password;

	private $firstname;

	private $lastname;

	private $email;

	private $image;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\Role","name"=>"idrole","nullable"=>false)
	*/
	private $role;

	/**
	 * @oneToMany("mappedBy"=>"user","className"=>"models\Host")
	*/
	private $hosts;

	/**
	 * @oneToMany("mappedBy"=>"user","className"=>"models\Virtualhost")
	*/
	private $virtualhosts;

	 public function getId(){
		return $this->id;
	}

	 public function setId($id){
		$this->id=$id;
	}

	 public function getLogin(){
		return $this->login;
	}

	 public function setLogin($login){
		$this->login=$login;
	}

	 public function getPassword(){
		return $this->password;
	}

	 public function setPassword($password){
		$this->password=$password;
	}

	 public function getFirstname(){
		return $this->firstname;
	}

	 public function setFirstname($firstname){
		$this->firstname=$firstname;
	}

	 public function getLastname(){
		return $this->lastname;
	}

	 public function setLastname($lastname){
		$this->lastname=$lastname;
	}

	 public function getEmail(){
		return $this->email;
	}

	 public function setEmail($email){
		$this->email=$email;
	}

	 public function getImage(){
		return $this->image;
	}

	 public function setImage($image){
		$this->image=$image;
	}

	 public function getRole(){
		return $this->role;
	}

	 public function setRole($role){
		$this->role=$role;
	}

	 public function getHosts(){
		return $this->hosts;
	}

	 public function setHosts($hosts){
		$this->hosts=$hosts;
	}

	 public function getVirtualhosts(){
		return $this->virtualhosts;
	}

	 public function setVirtualhosts($virtualhosts){
		$this->virtualhosts=$virtualhosts;
	}

	public function __toString(){
		return $this->firstname." ".$this->lastname." (".$this->login.")";
	}

}