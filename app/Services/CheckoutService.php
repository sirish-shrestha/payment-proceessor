<?php 
/**
 * Service for Checkout Processing
 *
 * @author Sirish Shrestha
 */

namespace App\Services;

use Illuminate\Http\Request;
use App\Gateways\Braintree;
/*use Braintree_Gateway;*/
use App\Order;


class CheckoutService{
	protected $request;
    protected $gateway;

    /**
     * @param Request $request
     */
    public function __construct(Request $request) {
        $this->request = $request;
        $this->gateway  = new Braintree;
        /*$this->gateway = new Braintree_Gateway([
		    'environment' => env('BRAINTREE_ENVIRONMENT'),
		    'merchantId' => env('BRAINTREE_MERCHANT_ID'),
		    'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
		    'privateKey' => env('BRAINTREE_PRIVATE_KEY')
		]);*/
    }

    public function showCheckoutForm(){
        //$token = $this->gateway->ClientToken()->generate();
        $token = $this->gateway->getClientToken();
        $orderid = mt_rand();//Generate a ranrom order ID for test purpose. No duplicate validation has been made.
        return view('checkout', ['token' => $token, 'order_id' => $orderid]);
    }

    /**
     *
     */
    public function validateAndProcessOrder(){
    	$currency   = $this->request->input('currency');
    	$amount = $this->request->input('price');
    	$order_id = $this->request->input('order_id');
    	$full_name = $this->request->input('full_name');
    	$messages = ["expiry_date.after" => "The Expiry date must be a future date."];
        $validator = \Validator::make(
            [
                'currency'     => $currency,
                'price' => $amount,
                'full_name'     => $full_name,
                'card_holder_name' => $this->request->input('card_holder_name'),
                /*'credit_card_number' => $this->request->input('credit_card_number'),
                'expiry_date' => $this->request->input('year')."-".$this->request->input('month'),
                'cvv' => $this->request->input('cvv'),*/
            ],
            [
                'currency'     => 'required',
                'price' => 'required|regex:/^\d*(\.\d{1,2})?$/',
                'full_name'     => 'required',
                'card_holder_name' => 'required',
                /*'credit_card_number' => 'required|digits_between:14,19',
                'expiry_date' => 'date|after:tomorrow',
                'cvv' => 'required|integer|digits_between:3,4',*/
            ],
            $messages
        );
        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)
                    ->withInput();
        } else {
        	$order = new order;
        	$order->order_id = $order_id;
        	$order->price = $amount;
        	$order->full_name = $full_name;
        	$order->currency = $currency;
        	$order->status = 'pending';
        	$order->save();
            return $this->processOrder();
        }
    }

    public function processOrder(){
    	$nonceFromTheClient = $this->request->input('payment_method_nonce');
		$amount = $this->request->input('price');
		$order_id = $this->request->input('order_id');
		$cardHolderName = $this->request->input('card_holder_name');
		$cvv = $this->request->input('cvv');

    	$arrayGatewayParam = array('amount' => $amount,
		    'paymentMethodNonce' => $nonceFromTheClient,
		    'orderId' => $order_id,
		     'options' => [
    			'submitForSettlement' => True
  			  ]);
    	$result = $this->gateway->sale($arrayGatewayParam);
    	if ($result->success || !is_null($result->transaction)) {
			$transaction = $result->transaction;
			$orderId = $transaction->orderId;
			$order = Order::where('order_id', '=' ,$orderId)->first();
			$order->status = 'Completed';
			$order->save();
			return redirect('order-confirmation/'.$transaction->orderId);
		} else {
		    $errorString = "";
		    foreach($result->errors->deepAll() as $error) {
		        $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
		    }
		    return \Redirect::back()->withErrors($errorString);
		}

    }
}
