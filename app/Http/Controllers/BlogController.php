<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\blog;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $auth_id = Auth::id();
        if ($request->ajax()) {
            $data = blog::where('subscriber_id', $auth_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()->addColumn('image', function ($row) {
                    $img = $row->image;
                    return $img;
                })->addColumn('action', function ($row) {

                    $btn = '<a href="blog/' . $row->id . '/edit" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm editsubscriber" style="margin-right:3px;">Edit</a>
                    <a href="javascript:void(0)" data-id="' . $row->id . '" class="edit btn btn-dark btn-sm deletesubscriber">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('blog.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images', $fileName);
        $subscriber_id = Auth::id();
        $data = new blog();
        $data->title = $request->title;
        $data->content = $request->content;
        $data->image = $fileName;
        $data->publish_date = $request->publish_date;
        $data->subscriber_id = $subscriber_id;
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
        $data = Blog::find($id);
        return view('blog.edit')
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
        $data = Blog::find($id);
        $fileName = '';
        if ($request->file('file')) {
            $file = $request->file('file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $fileName);
            if ($data->image) {
                Storage::delete('public/images/' . $data->image);
            }
        } else {
            $fileName = $data->image;
        }
        $data->title = $request->title;
        $data->image = $fileName;
        $data->publish_date = $request->publish_date;
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
        $data = Blog::find($id);
        if (Storage::delete('public/images/' . $data->image)) {
            Blog::destroy($id);
        }
    }
    public function home()
    {
        $auth_id = Auth::id();
        $blogs = blog::where('subscriber_id', $auth_id)->paginate(4);
        return view('blog.home')->with('blogs', $blogs);
    }
}
