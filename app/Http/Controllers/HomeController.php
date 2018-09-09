<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CheckoutService;

class HomeController extends Controller
{

	protected $request;
	protected $FrontendAPIService;

	public function __construct(Request $request, CheckoutService $CheckoutService){
		$this->request = $request;
		$this->CheckoutService = $CheckoutService;
	}
     /*
    Function to show Checkout Page
    */
    public function checkout(){
    	return $this->CheckoutService->showCheckoutForm();
    }

    public function checkoutProcessor(){
    	return 	$this->CheckoutService->validateAndProcessOrder();
    }

    public function OrderConfirmation($orderid){
        return view('order-confirmation')->with('orderid', $orderid);
    }

}
