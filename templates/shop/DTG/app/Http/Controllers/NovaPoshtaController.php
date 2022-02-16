<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Lang;
use App\NovaPoshta\Delivery\NovaPoshtaApi2;

class NovaPoshtaController extends Controller
{
	public function get_warehouses(){
        $np = new NovaPoshtaApi2('6fbacbe26346597568aec4fd476fda8b');
		$warehouses = $np->getWarehouses('');
        
        return $warehouses;
    }

    public function update_warehouses()
    {
        $warehouses = $this->get_warehouses();

        DB::table('npwarehouses')
        ->truncate();

        foreach ($warehouses['data'] as $warehouse) {
            $model = [];

            $model['site_key'] = $warehouse['SiteKey'];
            $model['description'] = trim(str_replace('  ', ' ', $warehouse['Description']));
            $model['number'] = $warehouse['Number'];
            $model['description_ru'] = trim(str_replace('  ', ' ', $warehouse['DescriptionRu']));
            $model['short_address'] = $warehouse['ShortAddress'];
            $model['short_address_ru'] = $warehouse['ShortAddressRu'];
            $model['phone'] = $warehouse['Phone'];
            $model['type_of_warehouse'] = $warehouse['TypeOfWarehouse'];
            $model['ref'] = $warehouse['Ref'];
            $model['city_ref'] = $warehouse['CityRef'];
            $model['city_description'] = $warehouse['CityDescription'];
            $model['city_description_ru'] = $warehouse['CityDescriptionRu'];
            $model['settlement_ref'] = $warehouse['SettlementRef'];

            DB::table('npwarehouses')
            ->insert($model);
        }

        echo "Обновление базы отделений НП закончено";
    }
}
