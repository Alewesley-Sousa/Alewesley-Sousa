<?php
// Define a constante APP_PATH
define('APP_PATH', dirname(__DIR__));

// Parseia a URL
$url = isset($_GET['url']) ? explode('/', trim($_GET['url'], '/')) : ['personagem', 'lista'];

// Define o controlador padrão se não existir na URL
$controllerName = isset($url[0]) ? ucfirst($url[0]) . 'Controller' : 'PersonagemController';
$acao = isset($url[1]) ? $url[1] : 'lista';

// Verifica se o arquivo do controlador existe
$controllerFile = "app/Controllers/{$controllerName}.php";
if (!file_exists($controllerFile)) {
    die("Controlador não encontrado: {$controllerName}");
}

require_once $controllerFile;

// Verifica se a classe existe antes de instanciar
if (!class_exists($controllerName)) {
    die("Classe do controlador não existe: {$controllerName}");
}

$controller = new $controllerName();

// Verifica se o método existe antes de chamar
if (!method_exists($controller, $acao)) {
    die("Ação não existe: {$acao}");
}

$controller->$acao();