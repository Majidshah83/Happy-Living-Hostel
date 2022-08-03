<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\CommonModel;

use Session;

class McCommonOperationController extends Controller
{

    //change status start here    
    public function change_status(Request $request){

        $crud_name = $request->crud_name;

        if($request->has('item_id') && !empty($request->item_id)){

            $item_id = $request->item_id;

            $table = $crud_name;

            $fillable =  Schema::getColumnListing($table);

            $common_obj = new CommonModel();

            $real_obj = $common_obj->set_config($table, $fillable);

            if(!$real_obj) return 'Common model config not set.';

            $item_details = $real_obj->findOrFail($item_id);
            $item_details->status = $request->status;
            $item_details->save();

            Session::flash('success','Status updated successfully');  
            return response()->success('Status updated successfully!');

        } //if($request->has('item_id') && !empty($request->item_id))

    } //public function change_status(Request $request){

    public function change_order(Request $request){

        $crud_name = 'kod_'.$request->crud_name;

        if($request->has('item_id') && !empty($request->item_id)){

            $item_id = $request->item_id;

            $table = $crud_name;

            $fillable =  Schema::getColumnListing($table);

            $common_obj = new CommonModel();

            $real_obj = $common_obj->set_config($table, $fillable);

            if(!$real_obj) return 'Common model config not set.';

            $item_details = $real_obj->findOrFail($item_id);
            $item_details->display_order = $request->display_order;
            $item_details->save();

            Session::flash('success','Display order updated successfully');  
            return response()->success('Display order updated successfully!');

        } //if($request->has('item_id') && !empty($request->item_id))

    }   //public function change_order(Request $request){
    
    // Start => public function get_table_row(Request $request)
    public function get_table_row(Request $request){

        $table = $request->table_name;

        $fillable =  Schema::getColumnListing($table);

        $common_obj = new CommonModel();

        $real_obj = $common_obj->set_config($table, $fillable);

        if(!$real_obj) return 'Common model config not set.';

        $item_details = $real_obj->findOrFail($request->item_id);

        $message = '';
        return response()->success($message, $item_details);
        
    } // End => public function get_table_row(Request $request)

}
