<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use PDF;
use Auth;

class InvoiceController extends Controller
{
    //downloads customer invoice
    public function customer_invoice_download($id)
    {
        $order = Order::findOrFail($id);
        $pdf = PDF::loadView('invoices.customer_invoice', compact('order'));
        return $pdf->download('order-'.$order->code.'.pdf');
    }

    //downloads seller invoice
    public function seller_invoice_download($id)
    {
        $order = Order::findOrFail($id);
        $pdf = PDF::loadView('invoices.seller_invoice', compact('order'));
        return $pdf->download('order-'.$order->code.'.pdf');
    }
}
