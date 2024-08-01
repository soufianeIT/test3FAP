<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Générer un PDF pour la commande spécifiée.
     *
     * @param  int  $orderId
     * @return \Illuminate\Http\Response
     */
    public function downloadPdf($orderId)
    {
        $order = Order::findOrFail($orderId);

        $pdf = Pdf::loadView('pdf.order', compact('order'));

        return $pdf->download('commande_'.$order->id.'.pdf');
    }
}
