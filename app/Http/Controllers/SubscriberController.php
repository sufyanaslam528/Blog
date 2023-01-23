<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\subscriber;
use Yajra\DataTables\DataTables;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = subscriber::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="subscriber/' . $row->id . '/edit" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm editsubscriber" style="margin-right:3px;">Edit</a>
                    <a href="javascript:void(0)" data-id="' . $row->id . '" class="edit btn btn-dark btn-sm deletesubscriber">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('subscriber.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('subscriber.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:subscribers|max:20',
            'password' => [
                'required',
                'min:8'
            ]
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->is_admin = 0;
        $user->save();
        $data = new subscriber;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->username = $request->username;
        $data->status = $request->status;
        $data->save();
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
        $data = subscriber::find($id);
        return view('subscriber.edit')
            ->with('data', $data);
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
        $data = subscriber::find($id);
        $data->name = $request->name;
        $data->username = $request->username;
        $data->password = $request->password;
        $data->status = $request->status;
        $data->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        subscriber::find($id)->delete();

        return response()->json(['success' => 'subscriber deleted successfully.']);
    }
}
