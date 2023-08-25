<?php
namespace App\Utils;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class Invoice {

    public static function generateInvoiceNumber(){
        $limit = 1000;
        $newInvoice=null;
        $lastInvoiceNumber = Sale::select(DB::raw("SUBSTRING_INDEX(invoice, '-', -1) AS invoice_number"))
        ->orderBy('invoice', 'desc')
        ->value('invoice_number');

        if($lastInvoiceNumber == $limit || $lastInvoiceNumber == null){
            $newInvoice=1;
        }
        else{
            $newInvoice=($lastInvoiceNumber + 1);
        }

        $formattedInvoice = str_pad($newInvoice, 4, '0', STR_PAD_LEFT);

        $invoiceNumber = 'FACT-' . $formattedInvoice;


        return $invoiceNumber;

    }
}