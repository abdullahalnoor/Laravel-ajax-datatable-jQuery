<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       
        return view('category',get_defined_vars());
    }

    public function getData(Request $request){

    //   return  $request->all();

        $columns = array(
            0 => 'sl',
            1 => 'name',
            2 => 'created_at',
            3 => 'status',
            4 => 'id',
        );

        $totalData = Category::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search_keywords')) && empty($request->input('filter_option'))) {
            $posts = Category::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search_keywords = $request->input('search_keywords');
            $filter_option = $request->input('filter_option');
           
            if($search_keywords && $filter_option ){
                $collection =  Category::where('name', 'LIKE', "%{$search_keywords}%")
                                    ->where('status', $filter_option);

            } else  if ($filter_option){
                $collection =  Category::Where('status', $filter_option);
                
            } else  if ($search_keywords) {
                $collection =  Category::where('name', 'LIKE', "%{$search_keywords}%");
            }

            $posts  = $collection->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
            $totalFiltered = $collection->count();
           
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {
                $show =  route('category.show', $post->id);
                $edit =  route('category.edit', $post->id);

                $nestedData['sl'] = $i;
                $nestedData['name'] = $post->name;
                $nestedData['status'] = $post->status === 1 ? 'Active' : 'Inactive';
                $nestedData['created_at'] = date('j M Y ', strtotime($post->created_at));
                $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' >View</a>
                                          &emsp;<a href='{$edit}' title='EDIT' >Edit</a>";
                $data[] = $nestedData;
                $i++;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }




    public function getDatabc2(Request $request)
    {



        $columns = array(
            0 => 'sl',
            1 => 'name',
            3 => 'created_at',
            4 => 'id',
        );

        $totalData = Category::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search_keywords')) && empty($request->input('filter_option'))) {
            $posts = Category::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search_keywords = $request->input('search_keywords');
            $filter_option = $request->input('filter_option');

            if ($search_keywords && $filter_option) {
                $posts =  Category::where('name', 'LIKE', "%{$search_keywords}%")
                ->where('status', $filter_option)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered =  Category::where('name', 'LIKE', "%{$search_keywords}%")
                ->where('status', $filter_option)->count();
            } else  if ($filter_option) {
                $posts =  Category::Where('status', $filter_option)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = Category::Where('status', $filter_option)->count();
            } else  if ($search_keywords) {
                $posts =  Category::where('name', 'LIKE', "%{$search_keywords}%")
                ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = Category::where('name', 'LIKE', "%{$search_keywords}%");
            }
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {
                $show =  route('category.show', $post->id);
                $edit =  route('category.edit', $post->id);

                $nestedData['sl'] = $i;
                $nestedData['name'] = $post->name;
                $nestedData['status'] = $post->status === 1 ? 'Active' : 'Inactive';
                $nestedData['created_at'] = date('j M Y h:i a', strtotime($post->created_at));
                $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                                          &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>";
                $data[] = $nestedData;
                $i++;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }






    public function getDataBc(Request $request)
    {



        $columns = array(
            0 => 'id',
            1 => 'name',
            3 => 'created_at',
            4 => 'id',
        );

        $totalData = Category::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = Category::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts =  Category::where('id', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$search}%")
            ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Category::where('id', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$search}%")
            ->count();
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $show =  route('category.show', $post->id);
                $edit =  route('category.edit', $post->id);

                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['created_at'] = date('j M Y h:i a', strtotime($post->created_at));
                $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                                          &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
