<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Indonesia; // Make sure to import the facade

class DependentDropdownController extends Controller
{
    public function provinces()
    {
        $provinces = Indonesia::allProvinces();

        return response()->json($provinces);
    }

        public function cities(Request $request)

        {

            $cities = Indonesia::findProvince($request->get('id'), ['cities']);

            return response()->json($cities ? $cities->cities : []); // Add null check

        }

    

        public function districts(Request $request)

        {

            $districts = Indonesia::findCity($request->get('id'), ['districts']);

            return response()->json($districts ? $districts->districts : []); // Add null check

        }

    

        public function villages(Request $request)

        {

            $villages = Indonesia::findDistrict($request->get('id'), ['villages']);

            return response()->json($villages ? $villages->villages : []); // Add null check

        }
}
