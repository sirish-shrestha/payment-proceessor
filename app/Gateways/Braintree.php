<?php 
namespace App\Gateways;

use App\AbstractClasses\AbstractGateway;
use Braintree_Gateway;

class Braintree extends AbstractGateway {
	
	protected $braintree;

	public function __construct(){
		$this->braintree = new Braintree_Gateway([
		    'environment' => env('BRAINTREE_ENVIRONMENT'),
		    'merchantId' => env('BRAINTREE_MERCHANT_ID'),
		    'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
		    'privateKey' => env('BRAINTREE_PRIVATE_KEY')
		]);
	}

	public function getClientToken(){
		$token = $this->braintree->ClientToken()->generate();
		return $token;
	}

	public function getDefaultParameters(){
        return array(
            'merchantId' => '',
            'publicKey' => '',
            'privateKey' => '',
            'testMode' => false,
        );
    }
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }
    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }
    public function getPublicKey()
    {
        return $this->getParameter('publicKey');
    }
    public function setPublicKey($value)
    {
        return $this->setParameter('publicKey', $value);
    }
    public function getPrivateKey()
    {
        return $this->getParameter('privateKey');
    }
    public function setPrivateKey($value)
    {
        return $this->setParameter('privateKey', $value);
    }

    /**
     * @param array $parameters
     * @return Message
     */
    public function sale(array $parameters = array())
    {
        $result = $this->braintree->transaction()->sale($parameters);
        return $result;
    }

}