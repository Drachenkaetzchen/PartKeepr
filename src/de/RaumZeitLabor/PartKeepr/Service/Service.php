<?php
namespace de\RaumZeitLabor\PartKeepr\Service;
use de\RaumZeitLabor\PartKeepr\Session\Session;

declare(encoding = 'UTF-8');

use de\RaumZeitLabor\PartKeepr\Session\SessionManager,
	de\RaumZeitLabor\PartKeepr\Service\Exceptions\ServiceException;

class Service {
	private $params;
	
	public function __construct (Array $params) {
		$this->params = $params;
	}
	
	public function mayCall ($call) {
		if (SessionManager::getCurrentSession()->getUser() === null) {
			return false;
		} else {
			/* @todo: Implement permission checking */
			return true;	
		}
		
		
	}
	
	protected function requireParameter ($name) {
		if (!$this->hasParameter($name)) {
			throw new ServiceException(sprintf("Parameter %s is required.", $name));
		}	
	}
	
	public function getParameter ($name, $default = null) {
		if (!$this->hasParameter($name)) {
			return $default;
		} else {
			return $this->params[$name];
		}
	}
	
	public function hasParameter ($name) {
		if (array_key_exists($name, $this->params)) {
			return true; 
		} else {
			return false;
		}
	}
	
	public function hasHeader ($name) {
		$targetName = "HTTP_".strtoupper($name);
		
		return array_key_exists($targetName, $_SERVER);
	}
	
	public function getHeader ($name) {
		$targetName = "HTTP_".strtoupper($name);
		
		if (array_key_exists($targetName, $_SERVER)) {
			return $_SERVER[$targetName];
		} else {
			throw new \Exception("Header ".$targetName." not found");
		}
	}
}


?>