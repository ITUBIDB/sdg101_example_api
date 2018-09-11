<?php

/**
 * Class Client
 */
class Client {
	protected $name;
	protected $number;
	
	public function __construct($name, $number) {
		$this->name = $name;
		$this->number = $number;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getNumber() {
		return $this->number;
	}
	
	public function printClient() {
		return $this->getName() . ' ' . $this->getNumber();
	}
}