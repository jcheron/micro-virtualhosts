<?php
namespace libraries;
use controllers\ControllerBase;
use models\User;

/**
 * Classe de gestion de l'authentification
 * @author jcheron
 * @version 1.2
 * @package libraries
 */
class Auth {
	/**
	 * Retourne l'utilisateur actuellement connecté<br>
	 * ou NULL si personne ne l'est
	 * @return User
	 */
	public static function getUser(){
		$user=null;
		if(array_key_exists("activeUser", $_SESSION))
			$user=$_SESSION["activeUser"];
		return $user;
	}

	/**
	 * Retourne vrai si un utilisateur est connecté
	 * @return boolean
	 */
	public static function isAuth(){
		return null!==self::getUser();
	}

	/**
	 * Retourne vrai si un utilisateur de type administrateur est connecté<br>
	 * Faux si l'utilisateur connecté n'est pas admin ou si personne n'est connecté
	 * @return boolean
	 */
	public static function isAdmin(){
		$user=self::getUser();
		if($user instanceof User){
			return $user->getRole()->getName()=="admin";
		}else{
			return false;
		}
	}

	/**
	 * Retourne la zone d'information au format HTML affichant l'utilisateur connecté<br>
	 * ou les boutons de connexion si personne n'est connecté
	 * @return string
	 */
	public static function getInfoUser(ControllerBase $controller,$inc=""){
		$jquery=$controller->jquery;
		$user=self::getUser($controller);
		if(isset($user)){
			$bt=$jquery->semantic()->htmlButton("btDisconnect".$inc,"Déconnexion","basic green");
			$bt->addLabel($user."",false,"user");
			$bt->getOnClick("Login/disconnect","#divInfoUser",["jsCallback"=>$controller->jquery->getDeferred("Main/index","#content-container")]);
		}else{
			$bt=$jquery->semantic()->htmlButton("btConnect".$inc,"Connexion pour tests");
			$bt->addIcon("sign in");
			$bt->getOnClick("Login/connectAsUser","#divInfoUser",["jsCallback"=>$controller->jquery->getDeferred("Main/index","#content-container")]);
		}
		return $bt;
	}
}