<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use PDF;
use Auth;
use DB;
use App\Exports\StaffExport;
use Maatwebsite\Excel\Facades\Excel;

class StaffController extends Controller
{
    public $request;

    public function __construct(Request $request) 
    {
        $this->request = $request;
        $this->middleware('permission:View Staffs', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {
        $items = $request->items ?? 5;
        $staffs = Staff::with('roles')->orderBy('id', 'desc')->paginate($items);
        $trashedStaff = Staff::onlyTrashed()->count();
        $roles = Role::all();

        return response()->json([
            'staffs' => $staffs,
            'total_trashed_staff' => $trashedStaff,
            'items' => $items,
            'roles' => $roles
        ], 200);
    }

    public function searchStaff($keyword)
    {
        $items = $this->request->items ?? 5;
        $staffs = Staff::where('name', 'LIKE', "%{$keyword}%")
            ->orWhere('email', 'LIKE', "%{$keyword}%")
            ->paginate($items);
        $trashedStaff = Staff::onlyTrashed()->count();

        return response()->json([
            'staffs' => $staffs,
            'total_trashed_staff' => $trashedStaff,
            'items' => $items,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // use /validate method provided by Illuminate\Http\Request object to validate post data
        // if validation fails JSON response will be sent for AJAX requests
        $this->validate(
            $request,
            [
                'name' => 'required|string|max:191',
                'email' => 'required|string|email|unique:users|max:191',
                'password' => 'required|string|min:6',
                'role_id' => 'required|numeric'
            ], [
                'role_id.required' => 'Please select a role!',
                'role_id.numeric' => 'Please select a role!',
            ]
        );

        $staff = Staff::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        $staff->assignRole($request->get('role_id'));

        return response()->json([
            'message' => 'User successfully created!',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $this->validate(
            $request,
            [
                'name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191|unique:users,email,' . $staff->id,
                'password' => 'sometimes|min:6',
                'role_id' => 'required|numeric'
            ], [
                'role_id.required' => 'Please select a role!',
                'role_id.numeric' => 'Please select a role!',
            ]
        );

        $staff->update($request->all());
        DB::table("model_has_roles")->where('model_id', $id)->delete();
        $staff->assignRole($request->get('role_id'));

        return response()->json([
            'success' => true,
            'message' => 'Staff updated!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Staff::findOrFail($id);

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Staff deleted!',
        ]);
    }

    public function deleteMultiple(Request $request)
    {
        $get_ids = $request->ids;
        $ids = explode(',', $get_ids);

        // precess request one by one
        foreach ($ids as $id) {
            $staff = Staff::findOrFail($id);

            if ($staff) {
                $staff->delete();
            }
        }

        return response()->json(['success' => 'Product deleted successfully.']);
    }

    public function downloadPDF()
    {
        $staffs = Staff::all();
        $pdf = PDF::loadview('staffs.pdf', ['staffs' => $staffs]); 
        return $pdf->stream();
    }

    public function downloadExcel()
    {
        return Excel::download(new StaffExport, 'staffs.xlsx');
    }

    public function downloadWord()
    {
        $staffs = Staff::all();
        $headers = array(
            "Content-type"        => "text/html",
            "Content-Disposition" => "attachment;Filename=list-users.doc"
        );
        $content =  view('staffs.pdf', ['staffs' => $staffs])->render();
        return \Response::make($content, 200, $headers);
    }
}
