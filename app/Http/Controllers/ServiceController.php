<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
     public function index()
      {
     $service =Service::all();
   
     return response()->json ([
        'data'=>$service
     ]) ;

    }


    
    public function store(Request $request)
    {
        $validateDate =$request->validate([
            'image_url' =>'nullable',
            'image_title'=>'nullable',
            'image_size'=>'nullable',
            'image_ext'=>'nullable',
            'image_token'=>'nullable',
            'title'=>'nullable',
            'content'=>'nullable'
           
           
    
        ]);
        $service = service:: create( $validateDate);
        return response()->json([
            'id'=>$service->id,
            'success'=> 200,
            'message'=>'message successfully',
    
        ]);
    
    }



public function update(Request $request,$id){

    $service=Service::findOrFail($id);

    $validateData=$request->validate([
         'image_url' =>'nullable',
            'image_title'=>'nullable',
            'image_size'=>'nullable',
            'image_ext'=>'nullable',
            'image_token'=>'nullable',
            'title'=>'nullable',
            'content'=>'nullable'
        
       
  
    ]);
    $service->update($validateData);
    return response()->json([
        'id'=> $service->id,
        'message'=>'details updated'
    ]);
}


        public function destroy($contactId){
        $service = Service::findOrFail($contactId);
    
         $service->delete();

        return response()->json([
            'id'=> $service->id,
            'message'=>'Services Deleted',
            'status'=>200
        ]);

    }
}
