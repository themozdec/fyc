<?php

namespace App\Exports;

use App\Models\Address;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class AddressesExport implements FromCollection, WithHeadings
{
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$user_id = auth()->user()->id;
        $addresses = DB::select("SELECT address,city,pincode FROM user_addresses WHERE user_id=$user_id;");    
        return collect($addresses);
    }
    public function headings(): array
    {
        return [ "Dirección","Ciudad", "Código Postal"];
    }
}
