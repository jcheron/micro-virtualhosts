<?php
namespace libraries;
/**
 * Classe d'échange avec le server vhServer permettant la communication avec le service web
 * @author jc
 *
 */
class ServerExchange{

	private $server;
	private $port;

	public function __construct($server="127.0.0.1",$port=9001){
		$this->server=$server;
		$this->port=$port;
	}

	public function sendPing(){
		return $this->send( "ping", "", []);
	}

	public function sendRun($executable,$params=[]){
		return $this->send("run", $executable, $params);
	}

	public function sendFile($filename){
		return $this->send("sendfile", $filename);
	}

	public function send($action,$content,$params){
		set_error_handler(function($errno, $errstr, $errfile, $errline, array $errcontext) {
			if (0 === error_reporting()) {
				return false;
			}
			throw new \ErrorException($errstr, $errno, $errno, $errfile, $errline);
		});
			$serverResponses=[];
			$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			$msg=$this->createTCPMessage($action,$content,$params);
			try{
				$result = socket_connect($sock, $this->server, $this->port);
				if ($result !== false) {
					$this->sendMessage($sock, $msg);
					$buf = '';
					if(false!==($buf= socket_read($sock, 2048))){
						if(mb_detect_encoding($buf, 'UTF-8', true)===false)
							$buf=utf8_encode($buf);
						$serverResponses=explode("|", $buf);
					}
					socket_close($sock);
					$serverResponses[]='{"type":"info","content":"Lecture de '.strlen($buf).' bytes provenant du serveur.\nFermeture de la connexion..."}';
				}
			}catch(ErrorException $e){
				$serverResponses[]='{"type":"error","content":"Communication impossible avec le serveur.\nAssurez vous que <b>vhServer</b> est lancé sur '.$this->server.' et écoute sur le port '.$this->port.'"}';
			}
			return $serverResponses;
	}


	public static function hasError($messages){
		$result=false;
		foreach ($messages as $message){
			$obj=json_decode($message);
			if($obj!==null){
				if($obj->type==="error")
					$result=true;
			}
		}
		return $result;
	}

	private function createTCPMessage($action,$content="",$params=[]){
		if(!is_array($params))
			$params=explode(",",$params);
		if($action==="sendfile"){
			$fileContent=file_get_contents($content);
			$msg ='{"action":"'.$action.'", "content":'.json_encode($fileContent).',"params":'.json_encode($params).'}';
		}else{
			$msg ='{"action":"'.$action.'", "content":'.json_encode($content).',"params":'.json_encode($params).'}';
		}
		return $msg."\n";
	}

	private function sendMessage($socket,$msg){
		$length = strlen($msg);
		while (true) {
			$sent = socket_write($socket, $msg, $length);
			if ($sent === false) {
				break;
			}
			if ($sent < $length) {
				$msg = substr($msg, $sent);
				$length -= $sent;
			} else {
				break;
			}
		}
	}

	public function getServer() {
		return $this->server;
	}

	public function setServer($server) {
		$this->server=$server;
		return $this;
	}

	public function getPort() {
		return $this->port;
	}

	public function setPort($port) {
		$this->port=$port;
		return $this;
	}


}