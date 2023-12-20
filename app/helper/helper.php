<?php
/**
 * Created by PhpStorm.
 * User: seyyed reza
 * Date: 11/24/2019
 * Time: 10:47 AM
 */


function ReturnSuccess($data=null){
    if($data !==null){
        return  [
            'status'=>'success',
            'data'=>$data
        ];
    }else{
        return  [
            'status'=>'success'
        ];

    }
}

function ReturnError($msg=null,$code=null){
    if($msg !== null){
        return  [
            'status'=>'error',
            'code'=>$code,
            'msg'=>$msg
        ];
    }else{
        return  [
            'status'=>'error',
            'code'=>$code,
            'msg'=>"خطایی وجود دارد"
        ];

    }
}


function addUserId($request=null){
    if(!$request){
        $request = new \Illuminate\Http\Request();
    }
    $request->merge(['decryptedUserId'=>\Illuminate\Support\Facades\Session::get('user_id')]);

    return $request;
}
