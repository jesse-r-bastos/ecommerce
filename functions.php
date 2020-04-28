<?php 
/**
 *  Funções de comuns de Formatação
 */
use \Hcode\Model\User;


function formatPrice($vlprice) 
{

	if (is_null($vlprice)) return 0;

	return number_format($vlprice, 2, ",", ".");

}

function checkLogin($inadmin = true) {

	return User::checkLogin($inadmin);

}

function getUserName() {

	$user = User::getFromSession();

	return $user->getdeslogin();

}


 ?>