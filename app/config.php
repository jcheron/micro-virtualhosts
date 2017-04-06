<?php
return array(
		"siteUrl"=>"http://127.0.0.1/micro-virtualhosts/",
		"documentRoot"=>"Test",
		"database"=>[
				"dbName"=>"virtualhosts",
				"serverName"=>"127.0.0.1",
				"port"=>"3306",
				"user"=>"root",
				"password"=>""
		],
		"onStartup"=>function($action){
		},
		"templateEngine"=>'micro\views\engine\Twig',
		"templateEngineOptions"=>array("cache"=>false),
		"test"=>false,
		"debug"=>false,
		"di"=>["jquery"=>function(){
							$jquery=new Ajax\php\micro\JsUtils(["defer"=>true]);
							$jquery->semantic(new Ajax\Semantic());
							return $jquery;
						}],
		"ormCache"=>["cacheDirectory"=>"/models/cache/"],
		"mvcNS"=>["models"=>"models\\","controllers"=>"controllers\\"]
);
