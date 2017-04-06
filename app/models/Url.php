<?php
namespace models;

class Url{
	/**
	 * @id
	*/
	private $id;

	private $icon;

	private $title;

	private $controller;

	private $action;

	private $subMenu;

	private $children;

	private $tools;

	private $roles;

	 public function getId(){
		return $this->id;
	}

	 public function setId($id){
		$this->id=$id;
	}

	 public function getIcon(){
		return $this->icon;
	}

	 public function setIcon($icon){
		$this->icon=$icon;
	}

	 public function getTitle(){
		return $this->title;
	}

	 public function setTitle($title){
		$this->title=$title;
	}

	 public function getController(){
		return $this->controller;
	}

	 public function setController($controller){
		$this->controller=$controller;
	}

	 public function getAction(){
		return $this->action;
	}

	 public function setAction($action){
		$this->action=$action;
	}

	 public function getSubMenu(){
		return $this->subMenu;
	}

	 public function setSubMenu($subMenu){
		$this->subMenu=$subMenu;
	}

	 public function getChildren(){
		return $this->children;
	}

	 public function setChildren($children){
		$this->children=$children;
	}

	 public function getTools(){
		return $this->tools;
	}

	 public function setTools($tools){
		$this->tools=$tools;
	}

	 public function getRoles(){
		return $this->roles;
	}

	 public function setRoles($roles){
		$this->roles=$roles;
	}

	public function __toString(){
		return $this->controller."/".$this->action;
	}

}