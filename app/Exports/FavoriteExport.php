<?php

namespace App\Exports;

use App\Models\Favorite;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class FavoriteExport implements FromCollection, WithHeadings
{
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$user_id = auth()->user()->id;
        $orders = DB::select("SELECT p.name,f.created_at FROM favorites f INNER JOIN products p ON f.product_id=p.id WHERE f.user_id=$user_id;");    
        return collect($orders);
    }
    public function headings(): array
    {
        return ["Producto", "Fecha"];
    }
}
