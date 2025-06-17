<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
     public function index()
      {
     $contacts =Contact::all();
   
     return response()->json ([
        'data'=>$contacts
     ]) ;

    }


    
    public function store(Request $request)
    {
        $validateDate =$request->validate([
            'address' =>'nullable',
            'email'=>'nullable',
            'phone'=>'nullable',
            'email'=>'nullable',
            'location'=>'nullable',
            'facebook'=>'nullable',
            'twitter'=>'nullable',
            'linkedin'=>'nullable',
            'pinterest'=>'nullable'
           
           
    
        ]);
        $contact = Contact:: create( $validateDate);
        return response()->json([
            'id'=>$contact->id,
            'success'=> 200,
            'message'=>'message successfully',
    
        ]);
    
    }



public function update(Request $request,$id){

    $contact=Contact::findOrFail($id);

    $validateData=$request->validate([
        'address' =>'nullable',
            'email'=>'nullable',
            'phone'=>'nullable',
            'email'=>'nullable',
            'location'=>'nullable',
            'facebook'=>'nullable',
            'twitter'=>'nullable',
            'linkedin'=>'nullable',
            'pinterest'=>'nullable'
           
        
       
  
    ]);
    $contact->update($validateData);
    return response()->json([
        'id'=> $contact->id,
        'message'=>'details updated'
    ]);
}


        public function destroy($contactId){
        $contact = Contact::findOrFail($contactId);
    
            $contact->delete();

        return response()->json([
            'id'=>$contact->id,
            'message'=>'Contact Page Sucessfully Deleted',
            'status'=>200
        ]);

    }
    
}
