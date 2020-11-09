<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Blog\Admin\BaseController;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = BlogCategory::paginate(5);
        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		dd(__METHOD__);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		dd(__METHOD__);
    }
	
//	/**
//	 * Display the specified resource.
//	 *
//	 * @param  int  $id
//	 * @return \Illuminate\Http\Response
//	 */
//	public function show($id)
//	{
//		dd(__METHOD__);
//	}
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//		$item = BlogCategory::find($id);
//		$item = BlogCategory::where('id', '<=>', $id)->first();
//		$item = BlogCategory::where('id', $id)->get(); // get collection
		$item = BlogCategory::findOrFail($id);
		$categoryList = BlogCategory::all();
		
		return view('blog.admin.categories.edit',compact('item', 'categoryList'));
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
		$item = BlogCategory::find($id);
		if(empty($item)){
			return back()
				->withErrors(['msg' => "Post id=[{$id}] is not defined"])
				->withInput();
		}
		$data = $request->all();
		$result = $item->fill($data)->save();
		if($result){
			return redirect()
				->route('blog.admin.categories.edit', $item->id)
				->with(['success' => 'Saved successfully']);
		}else{
			return back()
				->withErrors(['msg' => 'Save error'])
				->withInput();
		}
    }
//	/**
//	 * Remove the specified resource from storage.
//	 *
//	 * @param  int  $id
//	 * @return \Illuminate\Http\Response
//	 */
//	public function destroy($id)
//	{
//		dd(__METHOD__);
//	}
}
