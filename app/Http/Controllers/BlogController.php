<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\AppException;

class BlogController extends Controller
{

    protected function createValidator(Request $request)
    {
        $objValidator = Validator::make($request->all(), [
            'title' => ['required','string'],
            'article' => ['required']
        ]);

        return $objValidator;
    }

    public function index()
    {
        return view('pages.blogs');
    } 

    public function list(Request $request)
    {
        $data = Blog::where('title', 'LIKE','%'.$request->title.'%')->orderBy('created_at','desc')->paginate(10);

        return response()->json([
            'data' => $data
        ]);
    }


    public function update(Request $request)
    {
        $objValidator = $this->createValidator($request);
        if($objValidator->fails()){
            throw new AppException($objValidator->errors()->all());
        }
                
        $blog = Blog::updateOrCreate(
            ['id' => $request->id],
            [
                'title' => $request->title,
                'article' => $request->article
            ]
        );
 
        return response()->json([
            'data' => $blog
        ]);
    }    
    
    public function destroy($id)
    {
        $blog = Blog::where('id',$id)->first();
        $blog->delete();
        return response()->json('Blog deleted');
    }     
}
