<?php
namespace controllers;
use Ajax\semantic\html\elements\HtmlButton;
use Ajax\semantic\html\elements\HtmlButtonGroups;
use micro\utils\RequestUtils;

class Test extends ControllerBase{

    public function index(){

    	$semantic=$this->jquery->semantic();

    	$semantic->htmlButton("btApache","Apache file","green")->getOnClick("Test/readApache","#file");
		$semantic->htmlButton("btNginx","NginX file","black")->getOnClick("Test/readNginX","#file");
		$semantic->htmlButton("btStypes","Types de servers","red")->getOnClick("SType/index","#content-container");
		$semantic->htmlButton("btAdmin","Administration","red")->getOnClick("Admin/index","#content-container");
		$btEx=$semantic->htmlButton("btEx","Test des échanges client/serveur")->getOnClick("ServerExchangeTest/index","#content-container");
		$btEx->addLabel("New");

		$grid=$semantic->htmlGrid("grid");
		$grid->setStretched()->setCelled(true);
		$grid->addRow(2)->setValues(["Page principale user",$this->createBts("mainUser",["Mes services"=>"/my/index"],"","1&nbsp;&nbsp;&nbsp;")]);
		$grid->addRow(2)->setValues(["VirtualHosts par machine (host)",$this->createBts("hosts",["Liste des VirtualHosts par host"=>"/Display/host/1"],"","2&nbsp;&nbsp;&nbsp;")]);
		$grid->addRow(2)->setValues(["Détail d'un virtualhost sur dédié",$this->createBts("virtualhosts",["Virtualhost detail sur host"=>"/Display/virtualhost/4/1"],"","3.a")]);
		$grid->addRow(2)->setValues(["Détail d'un virtualhost sur mutualisé",$this->createBts("virtualhosts",["Virtualhost detail"=>"/Display/virtualhost/2"],"","3.b")]);

		$grid->setColWidth(0,4);
		$grid->setColWidth(1,12);
		$this->jquery->getOnClick(".clickable", "","#content-container",["attr"=>"data-ajax"]);
		$this->jquery->get("Login/index","#divInfoUser");
		$this->view->setVar("ajax",RequestUtils::isAjax());
		$this->jquery->compile($this->view);
		$this->loadView("test/index.html");
    }

    private function createBts($name,$actions,$color="",$todo=null){
    	$bts=new HtmlButtonGroups("bg-".$name);
    	foreach ($actions as $k=>$action){
    		$bt=new HtmlButton($k."-".$action);
    		$bt->setValue($k);
    		$bt->setProperty("data-ajax", $action);
    		$bt->addToProperty("class", "clickable");
    		$bt->setColor($color);
    		if(isset($todo)){
    			$bt->addLabel("//TODO ".$todo,true)->setColor("blue");
    		}
    		$bts->addElement($bt);
    	}

    	return $bts;

    }

    public function hosts(){
    	$this->jquery->get("Index/secondaryMenu/{$this->controller}/{$this->action}","#secondary-container");
		$this->jquery->compile($this->view);
    }

    public function virtualhosts(){
    	$this->jquery->get("Index/secondaryMenu/{$this->controller}/{$this->action}","#secondary-container");
    	$this->jquery->compile($this->view);
    }

    public function newVirtualhost(){

    }

    public function readApache(){
    	$this->readAndHighlightAll("apache", "apacheconf");
    }

    public function readNginX(){
    	$this->readAndHighlightAll("nginx", "javascript");
    }

    private function readAndHighlightAll($file,$language){
    	$fileContent=trim(htmlspecialchars(file_get_contents(ROOT.DS."views/{$file}.cnf")));
    	echo "<pre><code class='language-{$language}'>".$fileContent."</code></pre>";
    	$this->jquery->exec("Prism.highlightAll();",true);
    	echo $this->jquery->compile($this->view);
    }

}

