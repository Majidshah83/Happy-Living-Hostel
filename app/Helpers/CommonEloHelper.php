<?php

namespace App\Helpers;
use Auth;
use CommonMcConfigHelper;

use Illuminate\Support\Facades\Schema;
// use App\Models\CommonModel;

class CommonEloHelper
{
    
    //////////////////////////////////// START => GET ROW FUNCTIONS ////////////////////////////////////

    // Start => public static function get_table_row($table_name=false, $row_id=false)
    public static function get_table_row($table_name=false, $row_id=false){

        // Prepare Eloquent Object
        $real_obj = CommonMcConfigHelper::get_elo_obj($table_name);
        if(!$real_obj) return 'Common model config not set.';

        // Query result
        return $real_obj->findOrFail($row_id);

    } // End => public static function get_table_row($table_name=false, $row_id=false)

    // Start => public static function get_table_row_where_arr($table_name=false, $where_arr=array(), $order_by=array())
    public static function get_table_row_where_arr($table_name=false, $where_arr=array(), $order_by=array()){

        // Prepare Eloquent Object
        $real_obj = CommonMcConfigHelper::get_elo_obj($table_name);
        if(!$real_obj) return 'Common model config not set.';

        if(!empty($where_arr)){
            
            foreach($where_arr as $db_col_name => $value){
                
                $real_obj = $real_obj->where($db_col_name, $value); 
                
            } // foreach($where_arr as $where_clause)

        } // if(!empty($where_arr))

        if(!empty($order_by)){

            $column = key($order_by);
            $value = reset($order_by);

            $real_obj = $real_obj->orderBy($column, $value);

        } // if(!empty($order_by))

        return $real_obj->first();

    } // End => public static function get_table_row_where_arr($table_name=false, $where_arr=array(), $order_by=array())

    // Start => public static function get_table_row_where_arr_str($table_name=false, $where_arr=array(), $order_by=array())
    public static function get_table_row_where_arr_str($table_name=false, $where_arr=array(), $where_str=false, $order_by=array()){

        // Prepare Eloquent Object
        $real_obj = CommonMcConfigHelper::get_elo_obj($table_name);
        if(!$real_obj) return 'Common model config not set.';

        if(!empty($where_arr)){
            
            foreach($where_arr as $db_col_name => $value){
                
                $real_obj = $real_obj->where($db_col_name, $value);

            } // foreach($where_arr as $where_clause)

        } // if(!empty($where_arr))

        if(!empty($where_str)){

            $real_obj = $real_obj->whereRaw($where_str);

        } // if(!empty($where_str))

        if(!empty($order_by)){

            $column = key($order_by);
            $value = reset($order_by);

            $real_obj = $real_obj->orderBy($column, $value);

        } // if(!empty($order_by))

        return $real_obj->first();

    } // End => public static function get_table_row_where_arr_str($table_name=false, $where_arr=array(), $order_by=array())

    //////////////////////////////////// END => GET ROW FUNCTIONS /////////////////////////////////////
    //_______________________________________________________________________________________________//

    //////////////////////////////////// START => GET RESULT FUNCTIONS ////////////////////////////////////

    // Start => public static function get_table_result($table_name=false)
    public static function get_table_result($table_name=false){

        // Prepare Eloquent Object
        $real_obj = CommonMcConfigHelper::get_elo_obj($table_name);
        if(!$real_obj) return 'Common model config not set.';

        // Query result
        return $real_obj->get();

    } // End => public static function get_table_result($table_name=false)

    // Start => public static function get_table_result_where_arr($table_name=false, $where_arr=array(), $order_by=array(), $limit_arr=array())
    public static function get_table_result_where_arr($table_name=false, $where_arr=array(), $order_by=array(), $limit_arr=array()){

        // Prepare Eloquent Object
        $real_obj = CommonMcConfigHelper::get_elo_obj($table_name);
        if(!$real_obj) return 'Common model config not set.';

        if(!empty($where_arr)){
            
            foreach($where_arr as $db_col_name => $value){
                
                $real_obj = $real_obj->where($db_col_name, $value);

            } // foreach($where_arr as $where_clause)

        } // if(!empty($where_arr))

        if(!empty($order_by)){

            $column = key($order_by);
            $value = reset($order_by);

            $real_obj = $real_obj->orderBy($column, $value);

        } // if(!empty($order_by))

        if(!empty($limit_arr)){

            if(!empty($limit_arr['offset'])){

                $real_obj = $real_obj->offset($limit_arr['offset']);

            } // if(!empty($limit_arr['offset']))

            if(!empty($limit_arr['limit'])){
                $real_obj = $real_obj->limit($limit_arr['limit']);
            } // if(!empty($limit_arr['limit']))

        } // if(!empty($limit_arr))

        // Query result
        return $real_obj->get();

    } // End => public static function get_table_result_where_arr($table_name=false, $where_arr=array(), $order_by=array(), $limit_arr=array())

    // Start => public static function get_table_result_where_arr_str($table_name=false, $where_arr=array(), $where_str=false, $order_by=array())
    public static function get_table_result_where_arr_str($table_name=false, $where_arr=array(), $where_str=false, $order_by=array(), $limit_arr=array()){

        // Prepare Eloquent Object
        $real_obj = CommonMcConfigHelper::get_elo_obj($table_name);
        if(!$real_obj) return 'Common model config not set.';

        if(!empty($where_arr)){
            
            foreach($where_arr as $db_col_name => $value){
                
                $real_obj = $real_obj->where($db_col_name, $value);

            } // foreach($where_arr as $where_clause)

        } // if(!empty($where_arr))

        if(!empty($where_str)){

            $real_obj = $real_obj->whereRaw($where_str);

        } // if(!empty($where_str))

        if(!empty($order_by)){

            $column = key($order_by);
            $value = reset($order_by);

            $real_obj = $real_obj->orderBy($column, $value);

        } // if(!empty($order_by))

        if(!empty($limit_arr)){

            if(!empty($limit_arr['offset'])){

                $real_obj = $real_obj->offset($limit_arr['offset']);

            } // if(!empty($limit_arr['offset']))

            if(!empty($limit_arr['limit'])){
                $real_obj = $real_obj->limit($limit_arr['limit']);
            } // if(!empty($limit_arr['limit']))

        } // if(!empty($limit_arr))

        // Query result
        return $real_obj->get();

    } // End => public static function get_table_result_where_arr_str($table_name=false, $where_arr=array(), $where_str=false, $order_by=array())

    //////////////////////////////////// END => GET RESULT FUNCTIONS //////////////////////////////////
    //_______________________________________________________________________________________________//

    //////////////////////////////////// START => INSERT FUNCTION /////////////////////////////////////

    // Start => public static function insert_table_row($table_name=false, $filtered_ins_arr=array())
    public static function insert_table_row($table_name=false, $filtered_ins_arr=array()){

        // Prepare Eloquent Object
        $real_obj = CommonMcConfigHelper::get_elo_obj($table_name);
        if(!$real_obj) return 'Common model config not set.';

        /*
        if($filtered_ins_arr){
            foreach($filtered_ins_arr as $field => $value){

                

            } // foreach($filtered_ins_arr)
        } // if($filtered_ins_arr)
        */

        // return $filtered_ins_arr;

        $fillable = Schema::getColumnListing($table_name);

        foreach($filtered_ins_arr as $key => $val){
                
            if(in_array($key, $fillable)){

                $real_obj->$key = $val;

            } // if(in_array($key, $fillable))
            
        } // foreach($request->all() as $key => $val)

        // Query result
        $row_details = $real_obj->save();
        return $row_details;

    } // End => public static function insert_table_row($table_name=false, $filtered_ins_arr=array())

    //////////////////////////////////// END => INSERT FUNCTIONS //////////////////////////////////////
    //_______________________________________________________________________________________________//

    //////////////////////////////////// START => UPDATE FUNCTIONS /////////////////////////////////////

    // Start => public static function update_table_row($table_name=false, $row_id=false, $filtered_upd_arr=array())
    public static function update_table_row($table_name=false, $row_id=false, $filtered_upd_arr=array()){

       
        // Prepare Eloquent Object
        $real_obj = CommonMcConfigHelper::get_elo_obj($table_name);
        if(!$real_obj) return 'Common model config not set.';

        $row_details = $real_obj->findOrFail($row_id);
     
        $fillable = Schema::getColumnListing($table_name);
       
        foreach($filtered_upd_arr as $key => $val){
        
            if(in_array($key, $fillable)){
               
                $row_details->$key = $val;

            } // if(in_array($key, $fillable))
            
        } // foreach($filtered_upd_arr as $key => $val)

        $row_details->save();
        return $row_details;

    } // End => public static function update_table_row($table_name=false, $row_id=false, $filtered_upd_arr=array())

    // Start => public static function update_table_where_arr($table_name=false, $where_arr=false, $filtered_upd_arr=array())
    public static function update_table_where_arr($table_name=false, $where_arr=false, $filtered_upd_arr=array()){

        // Prepare Eloquent Object
        $real_obj = CommonMcConfigHelper::get_elo_obj($table_name);
        if(!$real_obj) return 'Common model config not set.';

        if(!empty($where_arr)){
            
            foreach($where_arr as $db_col_name => $value){
                
                $real_obj = $real_obj->where($db_col_name, $value);

            } // foreach($where_arr as $where_clause)

        } // if(!empty($where_arr))

        // Query result
        return $real_obj->update($filtered_upd_arr);

    } // End => public static function update_table_where_arr($table_name=false, $where_arr=false, $filtered_upd_arr=array())

    //////////////////////////////////// END => UPDATE FUNCTIONS //////////////////////////////////////
    //_______________________________________________________________________________________________//

    //////////////////////////////////// START => DELETE FUNCTIONS /////////////////////////////////////

    // Start => public static function delete_table_row($table_name=false, $row_id=false)
    public static function delete_table_row($table_name=false, $row_id=false){

        // Prepare Eloquent Object
        $real_obj = CommonMcConfigHelper::get_elo_obj($table_name);
        if(!$real_obj) return 'Common model config not set.';

        // Query result
        $row_details = $real_obj->findOrFail($row_id);
        return $row_details->delete();

    } // End => public static function delete_table_row($table_name=false, $row_id=false)

    // Start => public static function delete_table_where_arr($table_name=false, $where_arr=false)
    public static function delete_table_where_arr($table_name=false, $where_arr=false){

        // Prepare Eloquent Object
        $real_obj = CommonMcConfigHelper::get_elo_obj($table_name);
        if(!$real_obj) return 'Common model config not set.';

        if(!empty($where_arr)){
            
            foreach($where_arr as $db_col_name => $value){
                
                $real_obj = $real_obj->where($db_col_name, $value);

            } // foreach($where_arr as $where_clause)

        } // if(!empty($where_arr))

        // Query result
        return $real_obj->delete();

    } // End => public static function delete_table_where_arr($table_name=false, $where_arr=false)


     // Start =>   public static function get_table_result_with_request($table_name=false, $where_arr=array(), $order_by=array(), $request){
     public static function get_table_result_with_request($modelName=false, $where_arr=array(), $order_by=array(), $request){

        // Prepare Eloquent Object
        // $real_obj = CommonMcConfigHelper::get_elo_obj($table_name);

           // Include related data (relations)
        $include =$request->get('include');
        if (!empty($include)) {
            
            // $include_decoded = json_decode($request->include, true);
            $real_obj = $modelName::with($include);

        } else {
            
            $real_obj = $modelName::select('*');

        } // if (!empty($include)) 

        if(!empty($where_arr)){
            
            foreach($where_arr as $db_col_name => $value){
                
                $real_obj = $real_obj->where($db_col_name, $value);

            } // foreach($where_arr as $where_clause)

        } // if(!empty($where_arr))

        if(!empty($order_by)){

            $column = key($order_by);
            $value = reset($order_by);

            $real_obj = $real_obj->orderBy($column, $value);

        } // if(!empty($order_by))

        if($request->has('cdt_per_page') &&  !empty($request->cdt_per_page)){

            $limit = $request->get('cdt_per_page');
            $limit = $limit ? (int) $limit : 50 ;
            
            $results = $real_obj->paginate($limit);

        } else {
            
            $results = $real_obj->paginate(50);

        } //if($request->has('cdt_per_page') &&  !empty($request->cdt_per_page)){
        
        $results->withPath('javascript:;');

        return $results;

    } // End =>    public static function get_table_result_with_request($table_name=false, $where_arr=array(), $order_by=array(), $request){


    //////////////////////////////////// END => DELETE FUNCTIONS //////////////////////////////////////

}