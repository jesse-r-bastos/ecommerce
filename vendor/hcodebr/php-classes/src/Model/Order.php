<?php 
/** 	
 * Order - Controla Finalização do Pedido de Compra
 */
namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;
use \Hcode\Model\Cart;

class Order extends Model {

	const ERROR = "Order-Error";
	const SUCCESS = "Order-Sucesss";

	public function save() 
	{
		$sql = new Sql();

		$idOrder = $this->getidorder();

		if ( is_null($idOrder) ) $idOrder = 0 ; var_dump($idOrder);

		$results = $sql->select("CALL sp_orders_save ( :idorder, :idcart, :iduser, :idstatus, :idaddress, :vltotal )", [
									':idorder'=>$idOrder,
									':idcart'=>$this->getidcart(),
									':iduser'=>$this->getiduser(),
									':idstatus'=>$this->getidstatus(),
									':idaddress'=>$this->getidaddress(),
									':vltotal'=>$this->getvltotal()
					]);

		if (count($results) > 0 ) {

			$this->setData($results[0]);
		}

	}

	public function get($idorder) 
	{
		$sql = new Sql();

		$results = $sql->select("
								SELECT * 
								FROM tb_orders a
								INNER JOIN tb_ordersstatus b USING(idstatus) 
								INNER JOIN tb_carts c USING(idcart) 
								INNER JOIN tb_users d ON d.iduser = a.iduser
								INNER JOIN tb_addresses e USING(idaddress) 
								INNER JOIN tb_persons f ON f.idperson = d.idperson
								WHERE a.idorder = :idorder ;", [
									':idorder'=>$idorder
								]);

		if (count($results) > 0 ) {

			$this->setData($results[0]);
		}

	}

	public static function listAll() {

		$sql = new Sql();

		return $sql->select("
					SELECT * 
					FROM tb_orders a
					INNER JOIN tb_ordersstatus b USING(idstatus) 
					INNER JOIN tb_carts c USING(idcart) 
					INNER JOIN tb_users d ON d.iduser = a.iduser
					INNER JOIN tb_addresses e USING(idaddress) 
					INNER JOIN tb_persons f ON f.idperson = d.idperson 
					ORDER BY a.dtregister DESC ;
				");

	}

	public function delete() {

		$sql = new Sql();

		$sql->query("DELETE FROM tb_orders WHERE idorder = :idorder ;", [
			':idorder'=>$this->getidorder()
		]);

	}

	public function getCart():Cart {

		$cart = new Cart();

		$cart->get((int)$this->getidcart());

		return $cart;

	}

	public static function setError($msg)
	{

		$_SESSION[Order::ERROR] = $msg;

	} // end function setError

	public static function getError()
	{

		$msg = (isset($_SESSION[Order::ERROR]) && $_SESSION[Order::ERROR]) ? $_SESSION[Order::ERROR] : '';

		Order::clearError();

		return $msg;

	} // end function getError

	public static function clearError()
	{

		$_SESSION[Order::SUCCESS] = NULL;

	} // end function clearError

	public static function setSuccess($msg)
	{

		$_SESSION[Order::SUCCESS] = $msg;

	} // end function setSUCCESS

	public static function getSuccess()
	{

		$msg = (isset($_SESSION[Order::SUCCESS]) && $_SESSION[Order::SUCCESS]) ? $_SESSION[Order::SUCCESS] : '';

		Order::clearError();

		return $msg;

	} // end function getSuccess

	public static function clearSuccess()
	{

		$_SESSION[Order::ERROR] = NULL;

	} // end function clearSuccess

} // End Class Order - Model


 ?>