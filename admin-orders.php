<?php 
/**
 *  Rotas para o Controle de Crrinhos de Compra (Orders)
 */
use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Order;
use \Hcode\Model\OrderStatus;

// ----- Rotas para Controle dos Pedidos (Orders)  -----------------[INICIO]
// Deleta Pedido
$app->get("/admin/orders/:idorder/delete", function($idorder) {

	User::verifyLogin();

	$order = new Order();

	$order->get((int)$idorder);

	$order->delete();

	header("Location: /admin/orders");
	exit;

});
// Muda Status <GET>
$app->get("/admin/orders/:idorder/status", function($idorder) {

	User::verifyLogin();

	$order = new Order();

	$order->get((int)$idorder);

	$page = new Pageadmin();

	$page->setTpl("order-status", [
		'order'=>$order->getValues(),
		'status'=>OrderStatus::listAll(),
		'msgSuccess'=>Order::getSuccess(),
		'msgError'=>Order::getError()
	]);

});
// Muda Status <POST>
$app->post("/admin/orders/:idorder/status", function($idorder) {

	User::verifyLogin();

	if (!isset($_POST['idstatus']) || !(int)$_POST['idstatus'] > 0 ) {

		Order::setError("Informe o Status Atual..");
		header("Location: /admin/orders/".$idorder."/status");
		exit;
	}

	$order = new Order();

	$order->get((int)$idorder);

	$order->setidstatus($_POST['idstatus']);

	$order->save();

	Order::setSuccess('Status Atualizado com sucesso!!');

	header("Location: /admin/orders/".$idorder."/status");
	exit;

});
// Detalhes do Pedido
$app->get("/admin/orders/:idorder", function($idorder) {

	User::verifyLogin();

	$order = new Order();

	$order->get((int)$idorder);

	$cart = $order->getCart();

	$page = new Pageadmin();

	$page->setTpl("order", [
		'order'=>$order->getValues(),
		'cart'=>$cart->getValues(),
		'products'=>$cart->getProducts()
	]);

});

// Principal
$app->get("/admin/orders", function() {

	User::verifyLogin();

	$page = new Pageadmin();

	$page->setTpl("orders", [
		'orders'=>Order::listAll()
	]);

});
// 
// Orders        ----------------------------------------------------[FINAL]
//


 ?>
