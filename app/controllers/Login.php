<?php
namespace controllers;
use micro\orm\DAO;
use libraries\Auth;

class Login extends ControllerBase {

	public function index(){
		echo Auth::getInfoUser($this);
		echo $this->jquery->compile($this->view);
	}

	/**
	 * Déconnecte l'utilisateur actuel
	 */
	public function disconnect(){
		unset($_SESSION["activeUser"]);
		$this->forward("Login","index");
	}

	/**
	 * Simule une connexion du premier utilisateur trouvé dans la BDD
	 */
	public function connectAsUser(){
		$user=DAO::getOne("models\User",1);
		$_SESSION["activeUser"]=$user;
		$this->forward("Login","index");
	}

	public function pleaseLogin(){
		$message=$this->semantic->htmlMessage("error","Merci de vous connecter pour tester.");
		$message->setIcon("announcement")->setError();
		$message->setDismissable();
		$message->addContent(Login::getInfoUser($this,"-login"));
		echo $message;
		echo $this->jquery->compile($this->view);
	}


}