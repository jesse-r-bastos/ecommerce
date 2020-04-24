<?php 
/**
 *  Funções de comuns de Formatação
 */

function formatPrice($vlprice) 
{

	if (is_null($vlprice)) return 0;

	return number_format($vlprice, 2, ",", ".");

}


 ?>