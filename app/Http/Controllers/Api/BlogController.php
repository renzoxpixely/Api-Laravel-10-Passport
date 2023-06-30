<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Exception;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$blogs = Blog::all();
        $blogs = Blog::orderBy('id','desc')->get();
        return sendResponse('Success', BlogResource::collection($blogs));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required|min:10|max:255',
            'description'    => 'required|min:20'
        ]);

        if ($validator->fails()) return sendError('Validation Error.', $validator->errors(), 422);

        try {
            $blog = Blog::create([
                'title' => $request->title,
                'description' => $request->description
            ]);
            return sendResponse('Blog create success!', new BlogResource($blog));
        } catch (Exception $e) {
            return sendError($e->getMessage(), $e->getCode());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $blog = Blog::find($id);

        if($blog)
            return sendResponse('Success', new BlogResource($blog));
        else
            return sendError('Data not found');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required|min:10|max:255',
            'description'    => 'required|min:20'
        ]);

        if ($validator->fails()) return sendError('Validation Error.', $validator->errors(), 422);

        try {
            $blog->title = $request->title;
            $blog->description = $request->description;
            $blog->save();
            return sendResponse('Blog update success!', new BlogResource($blog));
        } catch (Exception $e) {
            return sendError($e->getMessage(), $e->getCode());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $blog = Blog::find($id);
            if ($blog){
                $blog->delete();
            }
            return sendError('Blog deleted success!', []);
        } catch (Exception $e) {
            return sendError('Something wrong!', $e->getCode());
        }        
    }
}
