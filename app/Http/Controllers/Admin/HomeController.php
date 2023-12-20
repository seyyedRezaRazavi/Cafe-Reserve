<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\event\eventController;
use App\Http\Controllers\Api\game\gameController;
use App\Http\Controllers\Api\profile\profileController;
use App\Http\Controllers\Api\reserve\reservationController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('user_login');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $api = new profileController();
        $response = $api->getProfileData(addUserId());
        $user_data = $response['data'];

        $api = new eventController();
        $response = $api->index();
        $events = $response['data'];

        return view('users.home',['user_data'=>$user_data,'events'=>$events]);
    }

    public function profile_images(){
        $api = new profileController();
        $images = $api->getProfilePictures(addUserId());
        return view('users.profile.images',compact('images'));
    }

    public function reservation_history(){
        $api = new profileController();
        $response = $api->user_reservations(addUserId());
        //dd($response);
        return view('users.profile.reservation_history',['data'=>$response['data']]);

    }

    public function setting(){
        $user_id = Session::get('user_id');
        $user = User::findOrFail($user_id);
        return view('users.profile.setting',['user'=>$user]);
    }

    public function remove_profile_picture(){
        $user_id = Session::get('user_id');
        $user = User::findOrFail($user_id);
        $filename = $user->pic;
        $user->pic=null;
        $user->save();

        $this->delete_profile_image_from_storage($filename);


        return redirect()->route('user.profile.setting')->withStatus(__('با موفقیت حذف شد'));
    }

    public function update(Request $request){
        //dd($request->all());

        $user_id = Session::get('user_id');
        $user = User::findOrFail($user_id);

        if($request->has('pic') && !empty($request->pic)){
            $image = $request->file('pic');
            $file_name = $this->upload_profile_picture_to_storage($image,$request);
            $user->pic = $file_name;
            $user->name = $request->name;
            $user->user_name = $request->user_name;
            $user->save();

            return redirect()->route('home')->withStatus(__('پروفایل با موفقیت بروزرسانی شد.'));
        }
        $user->update($request->all());
        return redirect()->route('home')->withStatus(__('پروفایل با موفقیت بروزرسانی شد.'));
    }

    private function upload_profile_picture_to_storage($image,$request){
        $name = Str::slug($request->input('name')).'_'.time();
        $folder = '/img/users/profile/';
        $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();

        $img = Image::make($image);
        $img->save(public_path().$filePath);
        return  $name. '.' . $image->getClientOriginalExtension();
    }

    private function delete_profile_image_from_storage($filename){

        $folder = '/img/users/profile/';
        File::delete(public_path().$folder.$filename);
        return true;
    }


}
