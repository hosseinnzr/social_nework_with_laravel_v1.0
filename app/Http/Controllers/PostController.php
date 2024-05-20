<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{   
    public function UpdateUserPostNumber(){
        
    }

    public function home(Request $request){
        if(auth::check()){

            $user_following = explode(",", Auth::user()->following);
            $user_follower = explode(",", Auth::user()->followers);

            $signin_user_id = Auth::id();

            $new_users = User::all()->sortByDesc('id')->whereNotIn('id', $user_following)->whereNotIn('id', $user_follower)->where('id', '!=', $signin_user_id)->take(5);

            $posts = Post::latest()->where('delete', 0)->whereIn('UID', $user_following)->get();

            if(isset($request->tag)){
                $result = array();
                foreach ($posts as $post) {
                    $post_array = explode(',', $post['tag']);
                    if ((in_array($request->tag, $post_array)) != false){
                        array_push($result, $post);
                    }
                    $posts=$result;
                } 
            }
            
                
            foreach ($posts as $post) {
                $user = User::where('id', $post->UID)->select('id', 'user_name', 'profile_pic')->first();
                $post['user_id'] = $user['id'];
                $post['user_name'] = $user['user_name'];
                $post['user_profile_pic'] = $user['profile_pic'];
            }

            $follower_user = User::whereIn('id', $user_follower)->select('user_name', 'first_name', 'last_name', 'profile_pic')->get();
            $following_user = User::whereIn('id', $user_following)->select('user_name', 'first_name', 'last_name', 'profile_pic')->get();

            return view('home', [
                'posts' => $posts,
                'follower_user' => $follower_user,
                'following_user' => $following_user,
                'new_users' => $new_users
            ]);    
            
        } else {
            notify()->error('you not signIn');
            return redirect()->route('signIn');
        }
    }


    public function postRoute(Request $request){
        if(isset($request->id)){
            $post = Post::findOrFail($request->id);

            if(Auth::user()->id != $post['UID']){
                notify()->error('you do not have access');
                return back();
            }else{
                return view('post', ['post' => $post]);
            }

        }else{
            return view('post');
        }
    }
    
    public function create(Request $request){
            
        if (Auth::check()) {

            $inputs = $request->only([
                'post_picture',
                'UID',
                'title',
                'post',
                'tag',
            ]);

            if ($request->hasFile('post_picture')) {
                $image = ($request->file('post_picture'));
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('post-picture'), $imageName);
                $inputs['post_picture'] = '/post-picture/'.$imageName;
            }

            $inputs['UID'] = Auth::id();
            $post = Post::create($inputs);

            // update user post number
            $signin_user_post_number = Post::where('delete', 0)->where('UID', Auth::id())->count();
            $user = User::findOrFail(Auth::id());
            $user->post_number = $signin_user_post_number;
            $user->save();

            notify()->success('Add post successfully!');
          
            return redirect()->route('post', ['id'=> $post->id])
              ->with('success', true);

        }else{
            return redirect()->route('/signIn');
        }
    }

    
    public function update(Request $request){

        if (isset($request->id)) {
            $inputs = $request->only([
                'post_picture',
                'title',
                'post',
                'tag',
            ]);

            if ($request->hasFile('post_picture')) {
                $image = ($request->file('post_picture'));
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('post-picture'), $imageName);
                $inputs['post_picture'] = '/post-picture/'.$imageName;
            }

            $post = Post::findOrFail($request->id);
            $post->update($inputs);

            notify()->success('update post successfully!');
          
            return redirect()
                ->route('post', ['id'=> $post->id])
                ->with('success', true);

        }else{
            return redirect()->route('/signIn');
        }

    }

    public function delete(Request $request){
        $post = Post::findOrFail($request->id);
        $post->update(['delete' => true]);

        // update user post number
        $signin_user_post_number = Post::where('delete', 0)->where('UID', Auth::id())->count();
        $user = User::findOrFail(Auth::id());
        $user->post_number = $signin_user_post_number;
        $user->save();
        
        return redirect()->back();
    }

    public function like(Request $request){

        $id = $request->postId;
        $is_liked = false;
        $user_liked_id = auth::id();

        $post = Post::findOrFail($id);
        $post_like = $post->like;

        $post_liked_array = explode(",", $post_like);

        foreach($post_liked_array as $like_number){

            if ($user_liked_id == $like_number){
                $post_liked_array = array_diff($post_liked_array, array($like_number));
                $like = implode(",", $post_liked_array);
                $is_liked = true;
                break;
            }
        }

        if(!$is_liked){
            if ($post->like != NULL) {
                $like = $post->like . ',' . $user_liked_id;
            } else {
                $like = $post->like . $user_liked_id;   
            }
        }

        // save like
        $post->like = $like;
        $post->save();

            if ($post->like == ""){
                $like_number = 0;
            }else{
                $like_number = count(explode(",", $post->like));
            }
        
        // save like_number
        $post->like_number = $like_number;
        $post->save();

        return response()->json(['massage'=> $like_number]);

        // return back();

    }
}
