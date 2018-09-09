<?php 
namespace App\AbstractClasses;

use App\Interfaces\PaymentGatewayInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use App\Helpers\helper;


abstract class AbstractGateway implements PaymentGatewayInterface{

	public function __construct(){
		$this->initialize();
	}

 	/**
     * Initialize this gateway with default parameters
     *
     * @param  array $parameters
     * @return $this
     */
	public function initialize(array $parameters = array()){
		 $this->parameters = new ParameterBag;
		 // set default parameters
        foreach ($this->getDefaultParameters() as $key => $value) {
            if (is_array($value)) {
                $this->parameters->set($key, reset($value));
            } else {
                $this->parameters->set($key, $value);
            }
        }
        Helper::initialize($this, $parameters);
        return $this;
	}

	/**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array();
    }

}