<?php
namespace App\traits;

trait generalTrait {
    public function UploadPhoto($image,$folder)
    {
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images/'.$folder),$imageName);
        return $imageName;
    }

    public function returnError($status=400 , $msg='Error',$validator=null ){
        return response()->json([
            'status'=>false,
            'msg'=>$msg,
            'details'=>$validator ? $validator :(object)[],
        ],$status);
    }

    public function returnSuccessMessage($msg="" , $status=200)
    {
        return response()->json([
            'status'=>true,
            'msg'=>$msg
        ],$status);
    }

    public function returnData($key , $value, $status=200)
    {
        return response()->json([
            'status'=>true,
            $key=>$value
        ],$status);
    }


    public function returnValidationError($validator,$msg='validation Error' ,$status=403){
        $jsonError=(object)[];
        foreach($validator->errors()->toArray() as $k=> $vs){
            foreach($vs as $val ){
                $jsonError->{$k} = $val;
            }
        }
        return $this->returnError($status,$msg,$jsonError);
    }
}


?>
