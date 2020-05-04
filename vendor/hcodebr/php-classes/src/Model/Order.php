<?php 
/** 	
 * Order - Controla Finalização do Pedido de Compra
 */
namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;

class Order extends Model {

	public function save() 
	{
		$sql = new Sql();

echo '<br> -------Order::save ----------'; 

		$idOrder = $this->getidorder();

//echo '<br> -------Address::save ----------'; /echo '<br>:idaddress=>' ; var_dump($idAddress);

		if ( is_null($idOrder) ) $idOrder = 0 ; var_dump($idOrder);
/*
echo '<br>:idorder=>'.$idOrder;
echo '<br>:idcart=>'.$this->getidcart();
echo '<br>:iduser=>'.$this->getiduser();
echo '<br>:idstatus=>'.$this->getidstatus();
echo '<br>:idaddress=>'.$this->getidaddress();
echo '<br>:vltotal=>'.$this->getvltotal();
*/
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

		$results = $sql->select("SELECT * FROM tb_orders a
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



} // End Class Order - Model


 ?>