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
		
		if ( isset ( $vHostProperty['value'] ) )
		{
			$vhP_value = $vHostProperty->getValue();
		}
		else 
		{
			$vhP_value = "N/A";
		}
		
		if ( isset ( $vHostProperty['active'] ) )
		{
			$vhP_active = $vHostProperty->getActive();
		}
		else
		{
			$vhP_active = 0;
		}
		
		if ( isset ( $vHostProperty['comment'] ) )
		{
			$vhP_comment = $vHostProperty->getComment();
		}
		else
		{
			$vhP_comment = 0;
		}
		
		
		$this->jquery->compile($this->view);
		$this->loadView("Display/index.html",array("id_vhost"=>$idvirtualhost,"nom_vhost"=>$vHost->getName(),"config_vhost"=>$vHost->getConfig(),"id_serveur_vhost"=>$vHost->getServer(),"vhP_value"=>$vhP_value,"vhP_active"=>$vhP_active,"vhP_comment"=>$vhP_comment));
		
	}
	
	
	
	
	
}