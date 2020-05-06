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

function formatDate($date) {

	return Date('d/m/Y', strtotime($date));

}

function checkLogin($inadmin = true) {

	return User::checkLogin($inadmin);

}

function getUserName() {

	$user = User::getFromSession();

	return $user->getdesperson();

}

function getCartNrQdt() {

	$cart = Cart::getFromSession();

	$totals = $cart->getProductsTotals();

	if ($totals  === NULL ) $totals['nrqtd'] = 0 ;

	return $totals['nrqtd'];

}

function getCartVlSubTotal() {

	$cart = Cart::getFromSession();

	$totals = $cart->getProductsTotals();

	if ($totals  === NULL ) $totals['vlprice'] = 0 ;

	return formatPrice($totals['vlprice']);

}


 ?>