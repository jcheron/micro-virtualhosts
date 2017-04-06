<?php
namespace models;

class Server{
	/**
	 * @id
	*/
	private $id;

	private $name;

	private $config;

	private $configFile;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\Host","name"=>"idHost","nullable"=>false)
	*/
	private $host;

	/**
	 * @oneToMany("mappedBy"=>"server","className"=>"models\Virtualhost")
	*/
	private $virtualhosts;

	/**
	 * @manyToOne
	 * @joinColumn("className"=>"models\Stype","name"=>"idStype","nullable"=>false)
	*/
	private $stype;

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

	 public function getConfigFile(){
		return $this->configFile;
	}

	 public function setConfigFile($configFile){
		$this->configFile=$configFile;
	}

	 public function getHost(){
		return $this->host;
	}

	 public function setHost($host){
		$this->host=$host;
	}

	 public function getVirtualhosts(){
		return $this->virtualhosts;
	}

	 public function setVirtualhosts($virtualhosts){
		$this->virtualhosts=$virtualhosts;
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