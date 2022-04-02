<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\User;
use App\Models\ShippingAddress;
use App\Models\Provinces;
use App\Models\Regencies;
use App\Models\Districts;
use App\Models\Villages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use DB;
use Auth;

class ShippingAddressesController extends Controller
{
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index($id) {
        $usersAddr = ShippingAddress::where('address_id', $id)->get()->toArray();
        $dataAddresses = [];
        foreach($usersAddr as $index => $userAddr) {
            $provinceName = Provinces::where('id', $userAddr['province_residence'])->pluck('name');
            $regencyName = Regencies::where('id', $userAddr['regency_residence'])->pluck('name');
            $districtName = Districts::where('id', $userAddr['district_residence'])->pluck('name');
            $villageName = Villages::where('id', $userAddr['village_residence'])->pluck('name');
            $dataAddresses[] = [
                'id' => $userAddr['id'],
                'label' => $userAddr['label'],
                'address' => $userAddr['address'],
                'province_residence_name' => $provinceName[0],
                'province_residence' => $userAddr['province_residence'],
                'regency_residence_name' => $regencyName[0],
                'regency_residence' => $userAddr['regency_residence'],
                'district_residence_name' => $districtName[0],
                'district_residence' => $userAddr['district_residence'],
                'village_residence_name' => $villageName[0],
                'village_residence' => $userAddr['village_residence'],
                'kode_pos' => $userAddr['kode_pos'],
            ];
        };
        
        return response()->json([
            'success' => true,
            'data' => $dataAddresses,
        ]);
    }

    public function store(Request $request) {
        $this->request->validate([
            'label' => 'required|min:2|max:20',
            'address' => 'required|max:50',
            'province_residence' => 'required',
            'regency_residence' => 'required',
            'district_residence' => 'required',
            'village_residence' => 'required',
            'kode_pos' => 'required|numeric|digits:5'
        ]);

        $user = Auth::guard('user-api')->user();

        ShippingAddress::insertGetId([
            'address_id' => $user->id,
            'label' =>  $request->get('label'),
            'address' =>  $request->get('address'),
            'province_residence' => $request->get('province_residence'),
            'regency_residence' => $request->get('regency_residence'),
            'district_residence' => $request->get('district_residence'),
            'village_residence' => $request->get('village_residence'),
            'kode_pos' => $request->get('kode_pos'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address has successfully added!',
        ]);
    }

    public function update($id)
	{
        $this->request->validate([
            'label' => 'required|min:2|max:20',
            'address' => 'required|max:50',
            'province_residence' => 'required',
            'regency_residence' => 'required',
            'district_residence' => 'required',
            'village_residence' => 'required',
            'kode_pos' => 'required|numeric|digits:5'
        ]);

		$addr = ShippingAddress::where('id', $id);

		$addr->update([
            'label' =>  $this->request->get('label'),
            'address' =>  $this->request->get('address'),
            'province_residence' => $this->request->get('province_residence'),
            'regency_residence' => $this->request->get('regency_residence'),
            'district_residence' => $this->request->get('district_residence'),
            'village_residence' => $this->request->get('village_residence'),
            'kode_pos' => $this->request->get('kode_pos'),
        ]);

		return response()->json([
			'success' => true,
			'message' => 'Address succesfully updated!',
		]);
	}

    public function forceDelete($id) {
        ShippingAddress::find($id)->forceDelete();

        return response()->json([
			'success' => true,
			'message' => 'Address succesfully deleted!',
		]);
    }
}
