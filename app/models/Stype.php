<?php
namespace models;

class Stype{
	/**
	 * @id
	*/
	private $id;

	private $name;

	private $configTemplate;

	private $prism;

	/**
	 * @oneToMany("mappedBy"=>"stype","className"=>"models\Server")
	*/
	private $servers;

	/**
	 * @oneToMany("mappedBy"=>"stype","className"=>"models\Stypeproperty")
	*/
	private $stypepropertys;

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

	 public function getConfigTemplate(){
		return $this->configTemplate;
	}

	 public function setConfigTemplate($configTemplate){
		$this->configTemplate=$configTemplate;
	}

	 public function getPrism(){
		return $this->prism;
	}

	 public function setPrism($prism){
		$this->prism=$prism;
	}

	 public function getServers(){
		return $this->servers;
	}

	 public function setServers($servers){
		$this->servers=$servers;
	}

	 public function getStypepropertys(){
		return $this->stypepropertys;
	}

	 public function setStypepropertys($stypepropertys){
		$this->stypepropertys=$stypepropertys;
	}

	public function __toString(){
		return $this->name;
	}

}