<?php 

session_start();
require_once("vendor/autoload.php");

use Slim\Slim;

$app = new Slim();

$app->config('debug', true);
//-------------------------------------------- CONTROLE  DAS  ROTAS:
require_once("site.php");					// Sites Principais
require_once("functions.php");				// Funções Compartilhadas
require_once("admin.php");					// Rotas de Login
require_once("admin-users.php"); 			// Controle de Senhas de Usuários
require_once("admin-categorias.php");		// CRUD de Categorias
require_once("admin-products.php");			// CRUD de Produtos
require_once("admin-orders.php");			// CRUD de Produtos

$app->run();

 ?>