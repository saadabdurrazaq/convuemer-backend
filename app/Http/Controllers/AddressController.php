<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use \App\Models\Provinces;
use \App\Models\Regencies;
use \App\Models\Districts;
use \App\Models\Villages;
use \App\Models\Man;
use \App\Models\Woman;
use \App\Models\Childern;
use Illuminate\Support\Facades\Input;
use DB;

class AddressController extends Controller
{
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * register
     *
     * @param  mixed $request
     * @return void
     */
    public function provinces()
    {
        $provinces = Provinces::all(); 
        return response()->json([
            'provinces' => $provinces,
        ], 200);
    }

    public function regencies($id)
    {
        $regencies = Regencies::where('province_id', '=', $id)->get();
        return response()->json($regencies);
    }

    public function districts($id)
    {
        $districts = Districts::where('regency_id', '=', $id)->get();
        return response()->json($districts);
    }

    public function villages($id)
    {
        $villages = Villages::where('district_id', '=', $id)->get();
       
        return response()->json($villages);
    }    
}
