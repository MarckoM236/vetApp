<?php
namespace App\Utils;

use App\Models\Customer as ModelsCustomer;

class Customer{
    public function getCustomerByID($identificacion){
        $customer = ModelsCustomer::where('customers.identificacion','=',$identificacion)->first();
        
        if ($customer == null) {
            return response()->json(['success' => false, 'message' => 'Cliente no Existe.']);
        }

        return response()->json(['success' => true, $customer]);
    }
}