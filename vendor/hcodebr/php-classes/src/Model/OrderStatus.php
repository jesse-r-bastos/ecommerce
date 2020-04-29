<?php 
/** 	
 * OrderStatus - Controla Status dos Pedidos de Compra
 */
namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;

class OrderStatus extends Model {

	Const EM_ABERTO = 1;
	Const AGUARDANDO_PAGAMENTO =2;
	Const PAGO = 3;
	Const ENTREGUE = 4;

} // End Class OrderStatus - Model


 ?>