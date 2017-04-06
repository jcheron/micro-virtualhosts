<?php
namespace controllers;
use Ajax\service\JString;
use Ajax\semantic\html\elements\HtmlHeader;
use Ajax\semantic\html\elements\HtmlButton;
use micro\orm\DAO;
use micro\orm\Reflexion;
use micro\orm\OrmUtils;

class Admin extends ControllerBase{

	public function index(){
		$semantic=$this->jquery->semantic();
		$dbs=DAO::$db->getTablesName();
		$menu=$semantic->htmlMenu("menuDbs",$dbs);
		$menu->setPropertyValues("data-ajax", $dbs);
		$menu->setVertical()->setInverted();
		$i=0;
		foreach ($dbs as $table){
			$model="models\\".ucfirst($table);
			$count=DAO::count($model);
			$menu->getItem($i)->addLabel($count);
			$i++;
		}
		$menu->getOnClick("Admin/showTable","#divTable",["attr"=>"data-ajax"]);
		$menu->onClick("$('.ui.label.left.pointing.teal').removeClass('left pointing teal');$(this).find('.ui.label').addClass('left pointing teal');");
		$this->jquery->compile($this->view);
		$this->loadView("Admin/index.html");
	}

	public function showTable($table){
		$_SESSION["table"]= $table;
		$semantic=$this->jquery->semantic();
		$model="models\\".ucfirst($table);

		$header=$semantic->htmlHeader("header-table",2,"","content");
		$header->asTitle($model,"Administration des données")->addIcon("table");
		$datas=DAO::getAll($model);
		$lv=$semantic->dataTable("lv", $model, $datas);
		$attributes=$this->getFields($model);

		$lv->setCaptions(array_map("ucfirst", $attributes));
		$lv->setFields($attributes);
		$lv->setIdentifierFunction($this->getIdentifierFunction($model));
		$lv->getOnRow("click", "Admin/showDetail","#table-details",["attr"=>"data-ajax"]);
		$lv->setUrls(["delete"=>"Admin/delete"]);
		$lv->setTargetSelector(["delete"=>"#table-messages"]);

		$lv->addEditDeleteButtons(false,["ajaxTransition"=>"random"]);
		$lv->setActiveRowSelector("error");
		$lv->addClass("small very compact");
		echo $header;
		echo $lv;
		echo "<div id='table-messages'></div>";

		echo "<div id='table-details'></div>";

		echo $this->jquery->compile($this->view);
	}

	private function getFields($model){
		return OrmUtils::getSerializableFields($model);
	}

	private function getIdentifierFunction($model){
		$pks=$this->getPks($model);
		return function($index,$instance) use ($pks){
			$values=[];
			foreach ($pks as $pk){
				$getter="get".ucfirst($pk);
				if(method_exists($instance, $getter)){
					$values[]=$instance->{$getter}();
				}
			}
			return implode("_", $values);
		};
	}

	private function getPks($model){
		$instance = new $model();
		return OrmUtils::getKeyFields($instance);
	}

	private function getOneWhere($ids,$table){
		$ids=explode("_", $ids);
		if(sizeof($ids)<1)
			return "";
		$pks=$this->getPks(ucfirst($table));
		$strs=[];
		for($i=0;$i<sizeof($ids);$i++){
			$strs[]=$pks[$i]."='".$ids[$i]."'";
		}
		return implode(" AND ", $strs);
	}

	private function getModelInstance($ids){
		$table=$_SESSION['table'];
		$model="models\\".ucfirst($table);
		return DAO::getOne($model,$ids);
	}

	public function delete($ids){
		$instance=$this->getModelInstance($ids);
		if(method_exists($instance, "__toString"))
			$instanceString=$instance."";
		else
			$instanceString=get_class($instance);
		if(sizeof($_POST)>0){
			if(DAO::remove($instance)){
				$message=$this->showSimpleMessage("Suppression de `".$instanceString."`", "info","info",4000);
				$this->jquery->exec("$('tr[data-ajax={$ids}]').remove();",true);
			}else{
				$message=$this->showSimpleMessage("Impossible de supprimer `".$instanceString."`", "warning","warning");
			}
		}else{
			$message=$this->showConfMessage("Confirmez la suppression de `".$instanceString."`?", "", "Admin/delete/{$ids}", "#table-messages", $ids);
		}
		echo $message;
		echo $this->jquery->compile($this->view);
	}

	private function getFKMethods($model){
		$reflection=new \ReflectionClass($model);
		$publicMethods=$reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
		$result=[];
		foreach ($publicMethods as $method){
			$methodName=$method->getName();
			if(JString::startswith($methodName, "get")){
				$attributeName=lcfirst(JString::replaceAtFirst($methodName, "get", ""));
				if(!property_exists($model, $attributeName))
					$result[]=$methodName;
			}
		}
		return $result;
	}

	private function showSimpleMessage($content,$type,$icon="info",$timeout=NULL){
		$semantic=$this->jquery->semantic();
		$message=$semantic->htmlMessage("msg-".rand(0,50),$content,$type);
		$message->setIcon($icon." circle");
		$message->setDismissable();
		if(isset($timeout))
			$message->setTimeout(3000);
		return $message;
	}

	private function showConfMessage($content,$type,$url,$responseElement,$data,$attributes=NULL){
		$messageDlg=$this->showSimpleMessage($content, $type,"help circle");
		$btOkay=new HtmlButton("bt-okay","Confirmer","positive");
		$btOkay->addIcon("check circle");
		$btOkay->postOnClick($url,"{data:'".$data."'}",$responseElement,$attributes);
		$btCancel=new HtmlButton("bt-cancel","Annuler","negative");
		$btCancel->addIcon("remove circle outline");
		$btCancel->onClick($messageDlg->jsHide());

		$messageDlg->addContent([$btOkay,$btCancel]);
		return $messageDlg;
	}

	public function showDetail($ids){
		$hasElements=false;
		$instance=$this->getModelInstance($ids);
		$table=$_SESSION['table'];
		$model="models\\".ucfirst($table);
		$relations = OrmUtils::getFieldsInRelations($model);
		$semantic=$this->jquery->semantic();
		$grid=$semantic->htmlGrid("detail");
		if(sizeof($relations)>0){
		$wide=intval(16/sizeof($relations));
		if($wide<4)
			$wide=4;
			foreach ($relations as $member){
				if(OrmUtils::getAnnotationInfoMember($model, "#oneToMany",$member)!==false){
					$objectFK=DAO::getOneToMany($instance, $member);
				}else{
					$objectFK=Reflexion::getMemberValue($instance, $member);
				}
				$memberFK=$member;

				$header=new HtmlHeader("",4,$memberFK,"content");
				if(is_array($objectFK) || $objectFK instanceof Traversable){
					$element=$semantic->htmlList("");
					$element->addClass("animated divided celled");
					$header->addIcon("folder");
					foreach ($objectFK as $item){
						if(method_exists($item, "__toString")){
							$element->addItem($item."");
							$hasElements=true;
						}
					}
				}else{
					if(method_exists($objectFK, "__toString")){
						$element=$semantic->htmlLabel("",$objectFK."");
						$header->addIcon("file outline");
					}
				}
				if(isset($element)){
					$grid->addCol($wide)->setContent($header.$element);
					$hasElements=true;
				}
			}
			if($hasElements)
				echo $grid;
		}
	}

}

