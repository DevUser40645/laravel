<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Blog\Admin\BaseController;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Http\Requests\BlogCategoryCreateRequest;
use App\Models\BlogCategory;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = BlogCategory::paginate(15);
        return view('blog.admin.categories.index',
            compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$item = new BlogCategory();
		$categoryList = BlogCategory::all();

        return view('blog.admin.categories.edit',
            compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();
        if (empty($data['slug'])) {
            $data['slug'] = str_slug($data['title'], '-');
        }

        // создаст объект, но не добавит в бд - 1 способ
//        $item = new BlogCategory($data);
//		$item->save(); // добавит в бд; в переменной будет true/false

        // создаст объект и добавит в бд - 2 способ
        $item = (new BlogCategory())->create($data); // в переменной будет объект/false

		if($item){
		    return redirect()->route('blog.admin.categories.edit', [$item->id])
                ->with(['success' => 'Saved successfully']);
        }else{
            return back()
                ->withErrors(['msg' => 'Save error'])
                ->withInput();
    }
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
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
//        $rules = [
//            'title'       => 'required|min:5|max:200',
//            'slug'        => 'max:200',
//            'description' => 'string|max:500|min:3',
//            'parent_id'   => 'required|integer|exists:blog_categories,id',
//        ];
//        $validateedData = $this->validate($request, $rules); // 1вариант
//        $validateedData = $request->validate($rules); // 2вариант
//        $validator = \Validator::make($request->all(), $rules); // 3вариант
//        $validateedData[] = $validator->passes(); // выполнит проверку и вернет true\false
//        $validateedData[] = $validator->validate(); // редирект
//        $validateedData[] = $validator->valid(); // получение валидных данных
//        $validateedData[] = $validator->failed(); // данные в которых ошибка
//        $validateedData[] = $validator->errors(); // ошибки в данных
//        $validateedData[] = $validator->fails(); // true\false
//        dd($validateedData);

		$item = BlogCategory::find($id);

		if(empty($item)){
			return back()
				->withErrors(['msg' => "Post id=[{$id}] is not defined"])
				->withInput();
		}
		$data = $request->all();
        if (empty($data['slug'])) {
            $data['slug'] = str_slug($data['title'], '-');
        }
//		$result = $item->fill($data)->save();
		$result = $item->update($data);
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
