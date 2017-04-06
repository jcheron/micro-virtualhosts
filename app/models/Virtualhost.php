<?php
namespace models;

class Virtualhost{
	/**
	 * @id
	*/
	private $id;

	private $name;

	private $config;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\Server","name"=>"idServer","nullable"=>false)
	*/
	private $server;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\User","name"=>"idUser","nullable"=>false)
	*/
	private $user;

	/**
	 * @oneToMany("mappedBy"=>"virtualhost","className"=>"models\Virtualhostproperty")
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

	 public function getConfig(){
		return $this->config;
	}

	 public function setConfig($config){
		$this->config=$config;
	}

	 public function getServer(){
		return $this->server;
	}

	 public function setServer($server){
		$this->server=$server;
	}

	 public function getUser(){
		return $this->user;
	}

	 public function setUser($user){
		$this->user=$user;
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