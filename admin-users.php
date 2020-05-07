<?php 
/**
 *  Rotas para o Administração de Usuários
 */
use Hcode\PageAdmin;
use Hcode\Model\User;

$app->get("/admin/users/:iduser/password", function($iduser) {

	User::verifyLogin();

	$user = new User();

	$user->get((int)$iduser);

	$page = new PageAdmin();

	$page->setTpl("users-password", [
		'user'=>$user->getValues(),
		'msgError'=>User::getError(),
		'msgSuccess'=>User::getSuccess()
	]);

});

$app->post("/admin/users/:iduser/password", function($iduser) {

	User::verifyLogin();

	User::setError("");

	if (!isset($_POST['despassword'])  || $_POST['despassword'] ==='') {
		User::setError("Preencha a nova Senha!");
		header("Location: /admin/users/$iduser/password");
		exit;
	}

	if (!isset($_POST['despassword-confirm'])  || $_POST['despassword-confirm'] ==='') {
		User::setError("Preencha a Confirmação da nova Senha!");
		header("Location: /admin/users/$iduser/password");
		exit;
	}
	if ($_POST['despassword'] !== $_POST['despassword-confirm'] ) {
		User::setError("A Nova Senha informada e a Confirmação da Senha não são iguais!");
		header("Location: /admin/users/$iduser/password");
		exit;
	} 

	$user = new User();

	$user->get((int)$iduser);

	$user->setPassword(User::getPasswordHash($_POST['despassword-confirm']));

	User::setSuccess("Senha Alterada com Sucesso!!");

	header("Location: /admin/users/$iduser/password");
	exit;

});

$app->get("/admin/users/:iduser/delete", function($iduser) {
	User::verifyLogin();
	$user = new User();
	$user->get((int)$iduser);
	$user->delete();
	header("Location: /admin/users");
	exit;
});

$app->get("/admin/users/:iduser", function($iduser) {
	User::verifyLogin();
	$user = new User();
	$user->get((int)$iduser);
	$page = new PageAdmin();
	$page->setTpl("users-update", [
		"user"=>$user->getValues()
	]);
});

$app->post("/admin/users/:iduser", function($iduser) {
	User::verifyLogin();
	$user = new User();
	$user->get((int)$iduser);
	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
	$user->setData($_POST);
	$user->update();
	header("Location: /admin/users");
	exit;
});

$app->get("/admin/users/create", function() {
	User::verifyLogin();
	$page = new PageAdmin();
	$page->setTpl("users-create");
});

$app->post("/admin/users/create", function () {
 	User::verifyLogin();
	$user = new User();
 	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
 	$_POST['despassword'] = password_hash($_POST["despassword"], PASSWORD_DEFAULT, [
 		"cost"=>12
 	]);
 	$user->setData($_POST);
	$user->save();
	header("Location: /admin/users");
 	exit;
});

$app->get("/admin/forgot", function() {
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	$page->setTpl("forgot");
});

$app->post("/admin/forgot", function() {
	$user = User::getForgot($_POST["email"]);
	header("Location: /admin/forgot/sent");
	exit;
});

$app->get("/admin/forgot/sent", function() {
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	$page->setTpl("forgot-sent");

});

$app->get("/admin/forgot/reset", function() {
	$user = User::validForgotDecrypt($_GET["code"]);
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	$page->setTpl("forgot-reset", [
		"name"=>$user["desperson"],
		"code"=>$_GET["code"]
	]);
});

$app->post("/admin/forgot/reset", function() {
	$forgot = User::validForgotDecrypt($_POST["code"]);
	User::setForgotUsed($forgot["idrecovery"]);
	$user =  new User();
	$user->get((int)$forgot["iduser"]);
	$password = password_hash($_POST["password"], PASSWORD_DEFAULT, ['cost'=>12]); // encrypta password
	$user->setPassword($password);
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	$page->setTpl("forgot-reset-success");
});

$app->get("/admin/users", function() {
	User::verifyLogin();

	$search = (isset($_GET['search'])) ? $_GET['search'] : '';
	$page = (isset($_GET['page'])) ? $_GET['page'] : 1;

	if ($search != '') {

		$pagination = User::getPageSearch($search, $page);

	} else {

		$pagination = User::getPage($page);
	}

	$pages = [];

	for ($x=0; $x < $pagination['pages'] ; $x++) { 
		
		array_push($pages, [
			'href'=>"/admin/users?". http_build_query([
				'page'=>$x+1,
				'search'=>$search
			]),
			'text'=>$x+1
		]);
	}

	$page = new PageAdmin();

	$page->setTpl("users", [
		'users'=>$pagination['data'],
		'search'=>$search,
		'pages'=>$pages
	]);

});



 ?>

