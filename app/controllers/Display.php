<?php
namespace controllers;
use libraries\Auth;
use micro\orm\DAO;
use Ajax\semantic\html\content\view\HtmlItem;
use models\Virtualhost;

class Display extends ControllerBase
{
	
	
	public function index()
	{
		var_dump($_POST);
	}
	
	
	
	
/* TODO 2 */
	
	
	
	
	
	
	
	/*
	 * 
	 * 
	 * /!\ Besoin de la variable $id_host contenant L'ID HOST /!\
	 * 
	 */
	public function virtualhost ($idvirtualhost)
	{
		
		$vHost=DAO::getOne("models\Virtualhost","id=".$idvirtualhost);		
		$vHostProperty=DAO::getOne("models\Virtualhostproperty","idVirtualhost=".$idvirtualhost);
		
		
		$id_host=1; /*FAUSSE VARIABLE EN ATTENDANT DE RECUPER LA VRAIE*/
		
		if ( isset($vHostProperty) ) /*Test de la présence ou non de properties sur le vhost*/
		{

			$vhP_value = "";
			$vhP_active = "";  
			$vhP_comment = "";
			
			
			
			$vHost_prop_value=DAO::getAll("models\VirtualhostProperty","idvirtualhost=".$idvirtualhost); /*Creation tableau contenant les valeures des propriétes d'un vhost sous forme d'objet*/
			$property=DAO::getAll("models\Property"); /*Creation tableau contenant les propriétes d'un vhost sous forme d'objet*/
			
			$vHost_prop = 
			[
					$property[0]->__toString()=>$vHost_prop_value[0]->__toString(),
					$property[1]->__toString()=>$vHost_prop_value[1]->__toString(), /*Creation du tableau + transformation des objets en chaines de caractères exploitables*/
					$property[2]->__toString()=>$vHost_prop_value[2]->__toString(), 
					$property[3]->__toString()=>$vHost_prop_value[3]->__toString()
			];

		}
		else 
		{
			$vhP_value = "N/A";
			$vhP_active = 0;			/*Déclaration de variables vides à afficher si le vhost n'a pas de properties*/
			$vHost_prop = "";
		}
		
		
		$this->jquery->compile($this->view);
		
		$this->loadView("Display/virtualhost.html"
		,array(
			"id_vhost"=>$idvirtualhost,"nom_vhost"=>$vHost->getName(),"config_vhost"=>$vHost->getConfig(),"id_serveur_vhost"=>$vHost->getServer() /* Conf obligatoire d'un vhost */
			,"vhP_value"=>$vhP_value,"vhP_active"=>$vhP_active /* Seulement utile si le vhost ne possède pas de properties*/
			,"vHost_prop"=>$vHost_prop /* Passage à la vue du tableau associant propiété=>valeur */
			,"id_host"=>$id_host /*recuperer l'IDhost pour rediriger correctement l'utilisateur*/
		)); 
		
	}
	
	
	
	/*                                                            
	 * Arriver sur cette fonction si on clique sur le boutton de conf. dans My
	 */                                                        
	
	public function confvhost ($idvirtualhost)
	{
		
		$vHost=DAO::getOne("models\Virtualhost","id=".$idvirtualhost);
		
		
		
		/*
		 * setConf($_POST[newConfiguration])
		 * etc..
		 * 
		 */
		
		if ( isset( $_POST ["newConfiguration"]) )
		{
			
			if ( $_POST["newConfiguration"] !== "")
			{
				$vHost->setConfig($_POST["newConfiguration"]);
			}
			if ($_POST["newServeur"] !== "")
			{
				$vHost->setServer($_POST["newServeur"]);
			}
			if ($_POST["newAddresse"] !== "")
			{
				$vHost->setName($_POST["newAddresse"]);
			}
		
		}
		
		
		$this->loadView("Display/confvhost.html"
				,array(
						"id_vhost"=>$idvirtualhost
				));








		
		
		
		
		
		
		
		
		
		
	}
	
	
}