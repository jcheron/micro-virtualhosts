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
	
	}
	
	
	
	
/* TODO 2 */
	
	
	
	
	
	
	
	/*Arriver sur cette fonction à partir du bouton : getOnClick("Display/virtualhost","#balise");
	 *  
	 *  $user=Auth::getUser();
	 * 
	 */
	public function virtualhost ($idvirtualhost)
	{
		
		$vHost=DAO::getOne("models\Virtualhost","id=".$idvirtualhost);		
		$vHostProperty=DAO::getOne("models\Virtualhostproperty","idVirtualhost=".$idvirtualhost);
		
		
		
		
		
		
		
		if ( isset($vHostProperty) ) /*TEST POUR SAVOIR SI LE VHOST POSSEDE DES PROPERTIES*/
		{
			
			$vhP_value = $vHostProperty->getValue();
			$vhP_active = $vHostProperty->getActive();
			$vhP_comment = $vHostProperty->getComment();
			
			
			
			$vHost_prop_value=DAO::getAll("models\VirtualhostProperty","idvirtualhost=".$idvirtualhost);
			$property=DAO::getAll("models\Property");
			
			$vHost_prop = 
			[
					$property[0]->__toString()=>$vHost_prop_value[0]->__toString(),
					$property[1]->__toString()=>$vHost_prop_value[1]->__toString(),
					$property[2]->__toString()=>$vHost_prop_value[2]->__toString(),
					$property[3]->__toString()=>$vHost_prop_value[3]->__toString()
			];

		}
		else 
		{
			$vhP_value = "N/A";
			$vhP_active = 0;
			$vhP_comment = 0;
			$vHost_prop = "";
		}
		
		
		
		
		
		$this->jquery->compile($this->view);
		$this->loadView("Display/index.html",array(
			"id_vhost"=>$idvirtualhost,"nom_vhost"=>$vHost->getName(),"config_vhost"=>$vHost->getConfig(),"id_serveur_vhost"=>$vHost->getServer()
			,"vhP_value"=>$vhP_value,"vhP_active"=>$vhP_active,"vhP_comment"=>$vhP_comment
			,"vHost_prop"=>$vHost_prop ));
		
	}
	
	
}