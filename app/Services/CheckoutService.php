<?php 
/**
 * Service for Checkout Processing
 *
 * @author Sirish Shrestha
 */

namespace App\Services;

use Illuminate\Http\Request;


class CheckoutService{
	protected $request;
	
	public function __construct(Request $request) {
        $this->request = $request;
    }

    public function validateAndProcessOrder(){
    	$currency   = $this->request->input('currency');
    	$messages = ["expiry_date.after" => "The Expiry date must be a future date."];
        $validator = \Validator::make(
            [
                'currency'     => $this->request->input('currency'),
                'price' => $this->request->input('price'),
                'full_name'     => $this->request->input('full_name'),
                'card_holder_name' => $this->request->input('card_holder_name'),
                'credit_card_number' => $this->request->input('credit_card_number'),
                'expiry_date' => $this->request->input('year')."-".$this->request->input('month'),
                'cvv' => $this->request->input('cvv'),
            ],
            [
                'currency'     => 'required',
                'price' => 'required|regex:/^\d*(\.\d{1,2})?$/',
                'full_name'     => 'required',
                'card_holder_name' => 'required',
                'credit_card_number' => 'required|integer|digits_between:14,19',
                'expiry_date' => 'date|after:tomorrow',
                'cvv' => 'required|integer|digits_between:3,4',
            ],
            $messages
        );
        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)
                    ->withInput();
        } else {
            return 1;
        }
    }
}