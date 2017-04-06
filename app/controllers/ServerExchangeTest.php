<?php
namespace controllers;
use Ajax\semantic\html\base\constants\Direction;
use Ajax\semantic\html\elements\HtmlButton;
use micro\utils\RequestUtils;
use libraries\ServerExchange;


class ServerExchangeTest extends ControllerBase {
	const ICONS=["success"=>"checkmark box","info"=>"info circle","warning"=>"warning circle","error"=>"announcement"];

	public function index(){

		$mess=$this->semantic->htmlMessage("infoFrm","<p>Ce module permet de tester les échanges entre le(s) server(s) distant(s) et l'application virtualhosts, pour transférer des fichiers, recharger apache ou NginX...</p>");
		$mess->addHeader("Interface de test Client/serveur");
		$bt=(new HtmlButton("bt-download", "Télécharger"))->asLink("https://github.com/jcheron/vhServer/releases/download/1.0/vhServer.jar");
		$bt->addIcon("download");
		$bt->addLabel("vhServer v1.0")->asLink("https://github.com/jcheron/vhServer/releases/download/1.0/vhServer.jar")->setPointing("left");

		$mess->addList(array($bt,"Copier le serveur java sur le(s) serveur(s) distant(s) ","Démarrer le serveur par la commande : <b>java -jar vhServer.jar 9001</b>","Exécuter des commandes via le module : ping, sendfile..."),false);
		$mess->setIcon("info circle");

		$frm=$this->semantic->htmlForm("frmPing");
		$fields=$frm->addFields();
		$fields->addInput("server","Serveur","text","127.0.0.1","Serveur")->setWidth(14);
		$fields->addInput("port","Port","number","9001","Port")->setWidth(2);
		$fields->addFieldRule(1, "integer");
		$input=$frm->addInput("message","Action","text","public/robots.txt","Message à envoyer...");
		$input->getDataField()->addProperties(["data-run"=>"c:\windows\system32\calc.exe","data-sendfile"=>"public/robots.txt","data-message"=>"","data-ping"=>""]);
		$input->getField()->addDropdown("ping",["run"=>"run","ping"=>"ping","sendFile"=>"sendFile","message"=>"message","stop"=>"stop","restart"=>"restart"],Direction::LEFT);
		$frm->addInput("params","Paramètres","text","","Paramètres séparés par une virgule");
		$this->jquery->execOn("change", "#select-div-message", "var self=this;$('['+'data-'+$(self).val()+']').each(function(){ if($(this).is('[value]')) $(this).val($(this).attr('data-'+$(self).val())); else $(this).html($(this).attr('data-'+$(self).val()));});");
		$bt=$frm->addButton("btPing", "Envoyer données vers le serveur")->asSubmit();
		$bt->addLabel("Connecté ?",false,"plug")->setPointing("left");
		$bt->getContent()[0]->addProperties(["data-run"=>"Exécuter sur le serveur","data-sendfile"=>"Envoyer le fichier vers le serveur","data-message"=>"?","data-ping"=>"Envoyer un ping"]);
		$frm->submitOnClick("btPing", "ServerExchangeTest/send", "#pingResponse");
		$this->jquery->postFormOn("change", "#server, #port", "ServerExchangeTest/ping","frmPing","#label-btPing");
		if(RequestUtils::isAjax()){
			$this->view->setVar("ajax", true);
		}
		$this->jquery->compile($this->view);
		$this->loadView("ServerExchangeTest/index.html");
	}

	public function send(){
			$address=$_POST["server"];$port=$_POST["port"];
			$action=$_POST["select-div-message"];
			$params=explode(",", $_POST["params"]);
			$content=$_POST["message"];
			$serverExchange=new ServerExchange($address,$port);
			if($action==="sendfile"){
				$content='http://'.$_SERVER['SERVER_NAME'].RequestUtils::getUrl($content);
			}
			$responses=$serverExchange->send($action, $content, $params);
			$this->displayMessages($responses);
			$this->updatePingDiv($responses);
			echo $this->jquery->compile();
	}

	public function ping(){
		$address=$_POST["server"];$port=$_POST["port"];
		$serverExchange=new ServerExchange($address,$port);
		$responses=$serverExchange->sendPing();
		$this->updatePingDiv($responses);
		echo $this->jquery->compile();
	}

	private function updatePingDiv($responses){
		$txt= "<i id='icon-label-btPing' class='icon warning'></i>Non connecté";
		if(ServerExchange::hasError($responses)){
			$this->jquery->doJQuery("#label-btPing", "removeClass","teal");
			$this->jquery->doJQuery("#label-btPing", "addClass","red");
		}else {
			$txt="<i id='icon-label-btPing' class='icon plug'></i>Connecté";
			$this->jquery->doJQuery("#label-btPing", "removeClass","red");
			$this->jquery->doJQuery("#label-btPing", "addClass","teal");
		}
		$this->jquery->doJQuery("#label-btPing", "html",$txt);
	}

	private function displayMessages($messages){
		foreach ($messages as $message){
			$obj=json_decode($message);
			if($obj!==null){
				$this->showMessage($obj->content, $obj->type);
			}
		}
	}

	private function showMessage($content,$style){
		$msg=$this->semantic->htmlMessage("",nl2br($content));
		$msg->setStyle($style);
		$msg->setIcon(self::ICONS[$style]);
		echo $msg;
	}
}