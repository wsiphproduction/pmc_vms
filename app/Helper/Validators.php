<?php
namespace App\Helper;

use Illuminate\Support\Facades\Validator;

use Exception;

class Validators{
    
    public function validateInputs($inputs, $rules, $model){
        $validation = Validator::make($inputs, $rules);
        if($validation->fails()){
            throw new Exception(json_encode([
                'validation_errors' => $validation->errors(),
                'model' => $model
            ]));
        }
    }
}