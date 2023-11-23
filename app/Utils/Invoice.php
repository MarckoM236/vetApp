<?php
namespace App\Utils;
use App\Models\Sale;
use App\Models\Params;
use Illuminate\Support\Facades\DB;

class Invoice {

    public static function generateInvoiceNumber(){
        $invoice = Params::value('value');
        $limit = 1000;
        $newInvoice="";
        $a = 65; //ASCII 'A'
        $z = 90; //ASCII 'Z'
        $lastInvoice = Sale::select(DB::raw("invoice AS invoice_number"))->orderBy('invoice', 'desc')->value('invoice_number');

        $ascii = 32; //ASCII ''
        $old = "";

        $lastInvoiceCharacters = substr($lastInvoice, 5 );
        $lastInvoiceNumber = substr($lastInvoice, 5, 4 );

        if(strlen($lastInvoiceCharacters) > 4 ){
            $lastCharacter = substr($lastInvoiceCharacters, -1 );
            $ascii=ord($lastCharacter);   
        }
        
        if($lastInvoiceNumber >= $limit){
            if((strlen($lastInvoiceCharacters) - 4)  > 0 ){
                if($ascii == $z) {
                    $ascii = chr($a);
                    if(ord(substr($lastInvoiceCharacters,4,(strlen($lastInvoiceCharacters)-4)-1)) < $z){
                        $old = chr(ord(substr($lastInvoiceCharacters,4,(strlen($lastInvoiceCharacters)-4)-1)) + 1); 
                    }
                    else{
                        $ascii = chr(32);
                        //se debe generar nueva nomenclatura 'FACT-' 
                        return "Debe generar nueva nomenclatura";   
                    }
                     
                }
                else{
                    $ascii = chr($ascii + 1);
                    $old = substr($lastInvoiceCharacters,4,(strlen($lastInvoiceCharacters)-4)-1);
                }  
            }
        
            else{
                $ascii = chr($a);
            }
        
            $newInvoice = 1; 
        }
        
        else{
            $ascii = chr($ascii);
            $old = substr($lastInvoiceCharacters,4,(strlen($lastInvoiceCharacters)-4)-1);
            $newInvoice = (int)$lastInvoiceNumber + 1;    
        }
        
        $formattedInvoice = str_pad($newInvoice, 4, '0', STR_PAD_LEFT);
        $invoiceNumber = $invoice . $formattedInvoice . $old. $ascii;

        return $invoiceNumber;
    }
}