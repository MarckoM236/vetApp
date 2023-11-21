<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function generatePdf($id){
        $invoice = Sale::leftjoin('customers','customers.id','sales.customer_id')
        ->join('sale_details','sale_details.sale_id','sales.id')
        ->join('products','products.id','sale_details.product_id')
        ->join('payment_details','payment_details.sales_id','sales.id')
        ->where('sales.id',$id)
        ->select('customers.identificacion as identification','customers.name as name_customer','customers.lastName as lastName_customer','customers.email as email_customer','customers.address as address_customer', 'customers.phone as phone_customer',
                'sales.invoice as invoice_sale','sales.created_at as date_sale','sales.total_amount as subTotal_sale',DB::raw('sales.total_amount * (16/100) as iva_sale'),
                'sale_details.quantity as quantity_product','sale_details.unit_price as unit_price_product','sale_details.total_price as total_price_product',
                'products.code as code_product','products.name as name_product',
                'payment_details.payment_status as status_payment','payment_details.payment_method as method_payment','payment_details.created_at as date_payment')
        ->get();

        
        //return view('invoice.pdf.template',['invoice'=>$invoice]);
        $pdf = Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif','default_paper_size' => 'letter'])->loadView('invoice.pdf.template',['invoice'=>$invoice]);
    
        $pdfContent = $pdf->output();
        file_put_contents(public_path('Invoice.pdf'), $pdfContent); // Save the PDF to a public location

        return redirect()->to(url('Invoice.pdf'));
    }
}
