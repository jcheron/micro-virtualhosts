<?php
namespace controllers;
 use micro\utils\RequestUtils;

 /**
 * Controller Main
 **/
class Main extends ControllerBase{

	public function index(){
		$semantic=$this->jquery->semantic();
		$semantic->htmlHeader("header",1,"Micro framework");
		$bt=$semantic->htmlButton("btTest","Semantic-UI Button");
		$bt->onClick("$('#test').html('It works with Semantic-UI too !');");
		if(!RequestUtils::isAjax())
			$this->jquery->get("Login/index","#divInfoUser");
		$this->jquery->compile($this->view);
		$this->loadView("index.html");
	}
}