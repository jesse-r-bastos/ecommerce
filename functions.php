<?php 
/**
 *  Funções de comuns de Formatação
 */

function formatPrice(float $vlprice) 
{

	return number_format($vlprice, 2, ",", ".");

}


 ?>