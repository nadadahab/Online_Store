<?php namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;


trait ControllerHelperTrait
{
    public function validation($request,$rules)
    {
      $validator=Validator::make($request->all(),$rules);

      if($validator->fails())
      {
          $errors=$validator->errors()->messages();
          return $errors;
      }
    }

    public function apiResponse($data=null,$errors=null,$code=200,$msg)
    {
     return response()->json(['data' => $data,'errors' => $errors , 'code' => $code ,'msg' =>$msg]);
    }

}
