<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use Image;
use Illuminate\Support\Facades\Auth;
class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('api');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  
    public function index()
    {
        //
        return Post::latest()->paginate(10);
       // return ;
        $user= Post::with('user')->get();
        //$posts=Post::all();

        //return response()->json($posts);
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
        //$user= User::all();

        $this->validate($request,[
            'title'=>'required|string|min:3',
            'description'=>'required|string|min:3',
            
        ]);
        $strpos = strpos($request->photo,';');
        $sub=substr($request->photo,0,$strpos);
        $ex=explode('/',$sub)[1];
        $name=time().".".$ex; 
        $img = Image::make($request->photo)->resize(200, 200);
        $upload_path=public_path()."/uploadimage/";
        $img->save($upload_path.$name);

       /* return Post::create([
            //'user_id'=>auth('api')->user(),
            'user_id'=>$request->user(),
            'title'=>$request['title'],
            'description'=>$request['description'],
            'photo'=>$request['name']       
        ]);*/
        $post = new Post();
        $post->user_id= 1;
        $post->title=$request->title;
        $post->description=$request->description;
        $post->photo=$name;

        $post->save();
       
    }

    public function profile()
    {
        //
        return auth('api')->user();
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $post = Post::findOrFail($id);
        $this->validate($request,[
            'title'=>'required|string|min:3',
            'description'=>'required|string|min:3',
        ]);
        
            $currentImage = $post->photo;
            if($request->photo!=$post->photo)
            {
                $strpos = strpos($request->photo,';');
                $sub=substr($request->photo,0,$strpos);
                $ex=explode('/',$sub)[1];
                $name=time().".".$ex; 
                $img = Image::make($request->photo)->resize(200, 200);
                $upload_path=public_path()."/uploadimage/";
                $image=$upload_path.$post->photo;
                $img->save($upload_path.$name);

                if(file_exists($image)){
                    @unlink($image);
                }   
            }
            else
            {
                $name = $post->photo;
            }

                //$post = new Post();
                $post->user_id=auth('api')->user();
                $post->title=$request->title;
                $post->description=$request->description;
                $post->photo=$name;

                $post->save();
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::findOrFail($id);
        //delete
        $image_path= public_path()."/uploadimage/";
        $image =$image_path.$post->photo;
        if(file_exists($image))
        {
            @unlink($image);
        }
        $post->delete();
        return ['message'=>'post deleted'];
    }
}
