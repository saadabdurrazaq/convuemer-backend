<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use PDF;
use Auth;
use App\Exports\StaffExport;
use Maatwebsite\Excel\Facades\Excel;

class StaffController extends Controller
{
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = $request->items ?? 5;
        $staffs = Staff::orderBy('id', 'desc')->paginate($items);
        $trashedStaff = Staff::onlyTrashed()->count();

        return response()->json([
            'staffs' => $staffs,
            'total_trashed_staff' => $trashedStaff,
            'items' => $items,
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
            ]
        );

        return Staff::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
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
        $user = Staff::findOrFail($id);

        $this->validate(
            $request,
            [
                'name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191|unique:users,email,' . $user->id,
                'password' => 'sometimes|min:6',
            ]
        );

        $user->update($request->all());

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
