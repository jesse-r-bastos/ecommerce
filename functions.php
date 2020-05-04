<?php 
/**
 *  Funções de comuns de Formatação
 */
use \Hcode\Model\User;
use \Hcode\Model\Cart;


function formatPrice($vlprice = 0) 
{

	if (!$vlprice > 0 ) $vlprice = 0;

	return number_format($vlprice, 2, ",", ".");

}

function checkLogin($inadmin = true) {

	return User::checkLogin($inadmin);

}

function getUserName() {

	$user = User::getFromSession();

	return $user->getdeslogin();

}

function getCartNrQdt() {

	$cart = Cart::getFromSession();

	$totals = $cart->getProductstotal();

	return $totals['nrqtd'];

}

function getCartvlSubTotal() {

	$cart = Cart::getFromSession();

	$totals = $cart->getProductstotal();

	return formatPrice($totals['vlprice']);

}


 ?>