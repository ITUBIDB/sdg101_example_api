<?php
require_once 'Client.php';

/**
 * Class ClientManager
 */
class ClientManager {
    /** @var Client[] */
    protected $clients;

    /**
     * ClientManager constructor.
     */
    public function __construct() {
		$this->clients = array();
	    $this->readAll();
    }

    /**
     * @return string
     */
    public function printAll() {
	    $printString = '';
	    foreach($this->clients as $client) {
		    $printString .= $client->printClient();
	    }
	    return $printString;
    }

    /**
     * @return boolean
     */
    public function writeAll() {
	    $clientFile = fopen("clients.txt", "w");
	    fwrite($clientFile, $this->printAll());
	    fclose($clientFile);
	    return true;
    }

    /**
     * @return boolean
     */
    public function readAll() {
	    $clientFile = fopen("clients.txt", "r");
		if($clientFile === false) {
			return false;
		}
	    while(!feof($clientFile)) {
		    $line = fgets($clientFile);
			if($line) {
				$splittedLine = preg_split('/ /', $line);
				$client = new Client($splittedLine[0], $splittedLine[1]);
				array_push($this->clients, $client);
			}
	    }
	    return true;
    }

    /**
     * return boolean
     */
    public function deleteAll() {
	    $clientFile = fopen("clients.txt", "w");
		if($clientFile === false) {
			return false;
		}
	    fwrite($clientFile, "");
	    fclose($clientFile);
	    return true;
    }

    /**
     * @param $name
     * @return string
     */
    public function printClient($name) {
	    foreach($this->clients as $client) {
		    if($client->getName() === $name) {
			    return $client->printClient();
		    }
	    }
	    return '';
    }

    /**
     * @param $clientIn
     * @return boolean
     */
    public function addClient($clientIn) {
	    array_push($this->clients, $clientIn);
	    return true;
    }

    /**
     * @param $clientIn
     * @return bool
     */
    public function updateClient($clientIn) {
	    foreach($this->clients as $client) {
		    if($client->getName() === $clientIn->getName()) {
			    $this->deleteClient($clientIn->getName());
			    $this->addClient($clientIn);
			    return true;
		    }
	    }
	    return false;
    }

    /**
     * @param $name
     * @return bool
     */
    public function deleteClient($name) {
	    for($i = 0; $i<count($this->clients);$i++) {
		    if($this->clients[$i]->getName === $name) {
			    unset($this->clients[$i]);
			    return true;
		    }
	    }
	    return false;
    }
}