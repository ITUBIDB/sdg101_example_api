<?php
require_once 'ClientManager.php';
require_once 'Client.php';

$clientManager = new ClientManager();

$uri = str_replace('/karakayasemi/api/index.php/', '', $_SERVER['REQUEST_URI']);
$path = preg_split('/\//', $uri);
$resource = array_shift($path);

$method = $_SERVER['REQUEST_METHOD'];

if ($resource == 'clients') {
	$name = array_shift($path);
	if (empty($name)) {
		switch($method) {
			case 'DELETE':
				$clientManager->deleteAll();
				header('HTTP/1.1 204');
				break;
			case 'GET':
				if($clientManager->printAll() != '') {
					echo $clientManager->printAll();
					header('', true, 200);
				} else {
					header('HTTP/1.1 404');
				}
				break;
			case 'POST':
				$client = new Client($_POST['name'], $_POST['number']);
				if($clientManager->addClient($client)) {
					header('HTTP/1.1 201');
				}
				break;	
			default:
				header('HTTP/1.1 405 Method Not Allowed', true, 405);
				header('Allow: GET, PUT, DELETE');
				break;
		}
	} else {
		switch($method) {
			case 'PUT':
				$client = new Client($_POST['name'], $_POST['number']);
				if($this->updateClient($client)) {
					header('HTTP/1.1 204');
				} else {
					header('HTTP/1.1 404');
				}
				break;
			case 'DELETE':
				if($clientManager->deleteClient($name)) {
					header('HTTP/1.1 204', true, 204);
			   	} else {
					header('HTTP/1.1 404');
				}
				break;
			case 'GET':
				if($clientManager->printClient($name)) {
					echo $clientManager->printClient($name);
					header('HTTP/1.1 200');
				} else {
					header('HTTP/1.1 404');
				}
				break;
			default:
				header('HTTP/1.1 405 Method Not Allowed', true, 405);
				header('Allow: GET, PUT, DELETE');
				break;
		}
	}
} else {
    // sadece musteriler altindaki isteklere yanit veriyoruz
    header('HTTP/1.1 404 Not Found', true, 404);
}
$clientManager->writeAll();