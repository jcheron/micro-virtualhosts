<?php

namespace controllers;
use libraries\Auth;
use micro\orm\DAO;
use Ajax\semantic\html\content\view\HtmlItem;



/**
 * Controller My de base -> Piqué depuis kobject.net
 **/




class My extends ControllerBase{
	
	/**
	 * Mes services
	 * Hosts et virtualhosts de l'utilisateur connecté
	 */
	
	
	public function index(){
		
		if(Auth::isAuth()){
			$user=Auth::getUser();
			$hosts=DAO::getAll("models\Host","idUser=".$user->getId());
			
			$hostsItems=$this->semantic->htmlItems("list-hosts");
			$hostsItems->fromDatabaseObjects($hosts, function($host){
				$item=new HtmlItem("");
				$item->addImage("public/img/host.png")->setSize("tiny");
				$item->addItemHeaderContent($host->getName(),$host->getIpv4(),"");
				return $item;
			});
				
				//A faire : ajouter virtualhosts
				
			
				<?php
				mysql_connect("virtualhosts", "root", "root") or die(mysql_error( )) ;
				mysql_select_db("ap") or exit(mysql_error( )) ;
				
				$result = mysql_query("SELECT pseudo FROM utilisateur") or exit(mysql_error( )) ;
				
				while($row = mysql_fetch_array($result))
				{
					
					echo '<span class="pseudo">'. row['pseudo'].'</span>';
					
				}
				?>
			
			
			
			
				$this->jquery->compile($this->view);
				$this->loadView("My/index.html");
		}
		
		
		/* PROTECTION DU CONTROLLEUR MY */
		
		else 
		{
			$this->loadView("Auth/pleaselogin.html");
		}
		
	}
}