<?php 
/** 	
 * Address - Busca CEP e Controla Dados de Endereço so Cliente
 */
namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;

class Address extends Model {

	Const SESSION_ERROR = "AddressError";

	public static function getCEP($nrcep) 
	{
		$nrcep = str_replace('-', '', $nrcep);

		$ch = curl_init(); // Inicia cURL

		curl_setopt($ch, CURLOPT_URL, "https://viacep.com.br/ws/$nrcep/json/");

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Tem retorno?
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Tem Autenticação ?

		$data = json_decode(curl_exec($ch), true); // Retorno como array[]

		curl_close($ch); // Encerra cURL

		return $data;

	}

	public function loadFromCEP($nrcep) 
	{
		$data = Address::getCEP($nrcep);

		if (isset($data['logradouro']) && $data['logradouro']) {

			$this->setdesaddress($data['logradouro']);
			$this->setdescomplement($data['complemento']);
			$this->setdesdistrict($data['bairro']);
			$this->setdescity($data['localidade']);
			$this->setdesstate($data['uf']);
			$this->setdescountry('Brasil');
			$this->setnrzipcode($nrcep);
		}

	}

	public function save() 
	{
		$sql = new Sql();
		
		$idAddress = $this->getidaddress();

//echo '<br> -------Address::save ----------'; /echo '<br>:idaddress=>' ; var_dump($idAddress);

		if ( is_null($idAddress) ) $idAddress = 0 ; var_dump($idAddress);
/*
	echo '<br>:idaddress=>'.$idAddress;
	echo '<br>:idperson=>'.$this->getidperson();
	echo '<br>:desaddress=>'.utf8_decode($this->getdesaddress());
	echo '<br>:descomplement=>'.utf8_decode($this->getdescomplement());
	echo '<br>:descity=>'.utf8_decode($this->getdescity());
	echo '<br>:desstate=>'.utf8_decode($this->getdesstate());
	echo '<br>:descountry=>'.utf8_decode($this->getdescountry());
	echo '<br>:nrzipcode=>'.$this->getnrzipcode();
	echo '<br>:desdistrict=>'.$this->getdesdistrict();
*/
		$results = $sql->select("CALL sp_addresses_save(:idaddress, :idperson, :desaddress, :descomplement, :descity, :desstate, :descountry, :nrzipcode, :desdistrict)", [
			':idaddress'=>$idAddress,
			':idperson'=>$this->getidperson(),
			':desaddress'=>utf8_decode($this->getdesaddress()),
			':descomplement'=>utf8_decode($this->getdescomplement()),
			':descity'=>utf8_decode($this->getdescity()),
			':desstate'=>utf8_decode($this->getdesstate()),
			':descountry'=>utf8_decode($this->getdescountry()),
			':nrzipcode'=>$this->getnrzipcode(),
			':desdistrict'=>$this->getdesdistrict()
		]);  

//echo "<br> checkout >> save.<br>"; echo var_dump($results); 

		if (count($results) > 0) {
			$this->setData($results[0]);
		}

	}

	public static function setMsgError($msg)
	{

		$_SESSION[Address::SESSION_ERROR] = $msg;

	}

	public static function getMsgError()
	{

		$msg = (isset($_SESSION[Address::SESSION_ERROR])) ? $_SESSION[Address::SESSION_ERROR] : "";

		Address::clearMsgError();

		return $msg;

	}

	public static function clearMsgError()
	{

		$_SESSION[Address::SESSION_ERROR] = NULL;

	}
	

} // End Class Address - Model


 ?>