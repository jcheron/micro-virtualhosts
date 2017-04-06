<?php
namespace controllers;
use micro\utils\RequestUtils;
use micro\controllers\Controller;
 /**
 * ControllerBase
 * @property Ajax\JsUtils $jquery
 **/
abstract class ControllerBase extends Controller{
	protected $semantic;
	public function initialize(){
		$this->semantic=$this->jquery->semantic();
		if(!RequestUtils::isAjax()){
			$this->loadView("main/vHeader.html");
			$this->jquery->get("Login/index","#divInfoUser");
		}
	}

	public function finalize(){
		if(!RequestUtils::isAjax()){
			$this->loadView("main/vFooter.html");
		}
	}
}
