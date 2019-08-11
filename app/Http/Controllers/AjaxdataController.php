<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Society;
use Datatables;
use Validator;


class AjaxdataController extends Controller
{
    function  index(){
        return view('society.ajaxdata');
    }
    function getdata(){
        $societies=Society::select('music_name','singer','link','time');
        return Datatables::of($societies)->make(true);
    }
    function postdata(Request $request){
        $validation=Validator::make($request->all(),[
            'music_name'=>'required',
            'singer'=>'required',
            'link'=>'required',
            'time'=>'required'
        ]);
        $error_array=array();
        $success_output='';
        if($validation->fails()){
            foreach ($validation->messages()->getMessages() as $field_name =>$message){
                $error_array[]=$message;
            }
        }else{
            if($request->get('action_button')=="insert"){
                $societies=new Society([
                    'music_name'=>$request->get('music_name'),
                    'singer'=>$request->get('singer'),
                    'link'=>$request->get('link'),
                    'time'=>$request->get('time'),
                ]);
                $societies->save();
                $success_output='<div class="alert alert-success">Data has been inserted</div>';
            }
        }
        $output=array(
            'error'=>$error_array,
            'success'=>$success_output
        );
        echo json_encode($output);
    }
}
