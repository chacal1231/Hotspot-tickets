<?php
/**
* PHP Mikrotik Billing (www.phpmixbill.com)
* Ismail Marzuqi iesien22@yahoo.com
* @version		4.0.0
* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt
* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
**/
class ServerMonitor
{
	private $_tasklist = array();
	private $_email = "";

	public function ping($link, $poort){
		$paketten=5;
		$timeout=0.5;
		$pingtijd = 0;
		for ($i=0;$i<=$paketten;$i++){
			$a=substr(microtime(),11,9)+substr(microtime(),0,10);
			$fs = @fsockopen($link, $poort, $errno, $errstr, $timeout);
			$b=substr(microtime(),11,9)+substr(microtime(),0,10);
			if (!$fs){
				return FALSE;
			}
			$pingtijd=$pingtijd+round(($b-$a)*1000);
			@fclose($fs);
		}
		if(($pingtijd/$paketten)<3){
			$pingtijd="2";
		}else {
			$pingtijd=($pingtijd/$paketten);
		}
		return $pingtijd;
	}
	
	public function add($name, $address, $port){
		$Task = new ServerMonitorTask();
		$Task->name 	= $name;
		$Task->address 	= $address;
		$Task->port 	= $port;
		$this->_tasklist[] = $Task;
		return TRUE;
	}

	public function setEmail($email){
		$this->_email = $email;
	}

	public function run($email=FALSE){
		if(count($this->_tasklist) > 0){
			
			// Loop through tasks
			foreach ($this->_tasklist as $task){
				$time = $this->Ping($task->address, $task->port);
				if(is_numeric($time)){
					$task->active = TRUE;
				}else{
					$task->active = FALSE;
				}
				$tasklist[] = $task;
			}
			
			if(!$email || empty($this->_email)){
				return $tasklist;
			}else{
				
				// Send email
				$to      = $this->_email;
				$subject = 'Service/Server problems';
				$message = "There are problems with some of your servers/services.\n\n";
				
				$found_inactive = false;
				foreach ($tasklist as $task){
					if(!$task->active){
						$message .= $task->name . " (" . $task->address . ":" . $task->port . ") is offline.\n";
						$found_inactive = true;
					}
				}
				
				
				$headers = 'From: admin@phpmixbill.com' . "\r\n" .
				    		'X-Mailer: PHP/' . phpversion();
				
				if($found_inactive) {
					mail($to, $subject, $message, $headers);
					return nl2br($message);
				}
				return false;
			}
		}else{
			return array();
		}
	}
	
}

class ServerMonitorTask
{
	public $name;
	public $address;
	public $port;
	public $active;
}
