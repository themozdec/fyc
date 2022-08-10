<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class OrderExport implements FromCollection, WithHeadings
{
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$user_id = auth()->user()->id;
        $orders = DB::select("SELECT o.id,p.name,o.created_at,o.total,'paypal' FROM orders o INNER JOIN carts c ON o.id=c.order_id INNER JOIN products p ON c.product_id=p.id 
/*INNER JOIN order_payments op ON O.order_payment_id= op.id*/ WHERE o.user_id=$user_id;");    
        return collect($orders);
    }
    public function headings(): array
    {
        return ["No. Orden", "Producto", "Fecha", "Total", "Tipo de pago"];
    }
}
