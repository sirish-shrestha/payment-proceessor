<?php
/*
* Payment Gateway Interface
*/
namespace App\Interfaces;

interface PaymentGatewayInterface{

	/*
	* Get Default Gateway Parameters
	*
	*@return associative array
	*/
	public function getDefaultParameters();

	/*
	* Initialize the Payment Gatway
	*
	*@return $this
	*/
	public function initialize(array $parameters = array());

}