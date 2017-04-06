<?php
namespace models;
class Host{
	/**
	* @id
	*/
	public $id;

	private $name;

	private $ipv4;

	private $ipv6;

	/**
	* @oneToMany("mappedBy"=>"host","className"=>"models\Server")
	*/
	private $servers;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\User","name"=>"idUser","nullable"=>false)
	*/
	private $user;

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

	 public function getIpv4(){
		return $this->ipv4;
	}

	 public function setIpv4($ipv4){
		$this->ipv4=$ipv4;
	}

	 public function getIpv6(){
		return $this->ipv6;
	}

	 public function setIpv6($ipv6){
		$this->ipv6=$ipv6;
	}

	 public function getServers(){
		return $this->servers;
	}

	 public function setServers($servers){
		$this->servers=$servers;
	}

	 public function getUser(){
		return $this->user;
	}

	 public function setUser($user){
		$this->user=$user;
	}

	public function __toString(){
		return $this->name;
	}

}