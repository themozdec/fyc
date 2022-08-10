<?php

namespace App\Exports;

use App\Models\Cart;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class CartExport implements FromCollection, WithHeadings
{
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$user_id = auth()->user()->id;
        $carts = DB::select("SELECT p.name,p.description,c.quantity,p2.price FROM carts c INNER JOIN products p ON c.product_id=p.id INNER JOIN product_items p2 ON c.product_id=p2.id WHERE c.user_id=$user_id AND c.active=1;");    
        return collect($carts);
    }
    public function headings(): array
    {
        return ["Producto", "Descripción", "Cantidad", "Precio"];
    }
}
