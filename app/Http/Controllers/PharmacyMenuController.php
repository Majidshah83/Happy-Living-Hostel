<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Models\PharmacyMenuStaticPage;
// use App\Models\PharmacyMenuPosition;
// use App\Models\PharmacyMenu;

use Illuminate\Support\Str;

use CommonCustomHelper;
use CommonEloHelper;

use App\Models\PharmacyMenu;

// Custom Validation Rules
// use App\Rules\ValidateTitlesRule;

use Session;

class PharmacyMenuController extends Controller{

    public function __construct(){

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function get()
    {   

        $pharmacy_menus = CommonEloHelper::get_table_result_where_arr('kod_menus', array(), array('display_order' => 'ASC'));
        // CommonCustomHelper::print_this_arr($pharmacy_menus); return '';

        return view('backend.admin.pharmacy_menus.index',['pharmacy_menus' => $pharmacy_menus]);
    }

    // Start => public function add_edit_menu(Request $request)
    public function add_edit_menu(Request $request){

        $row_details = array();
        if($request->has('item_id') && !empty($request->item_id)){
            $row_details = CommonEloHelper::get_table_row('kod_menus', $request->item_id);
        } // if($request->has('item_id') && !empty($request->item_id))

        return view('backend.admin.pharmacy_menus.add_edit_menu_modal', ['row_details' => $row_details]);

    } // End => public function add_edit_menu(Request $request)

    // Start => public function add_edit_menu_process(Request $request)
    public function add_edit_menu_process(Request $request){

        // return $request->all();

        if( $request->has('row_id') && !empty($request->row_id) ){
            
            // Update Process
            $success = CommonEloHelper::update_table_row('kod_menus', $request->row_id, $request->all());

            // Response message
            $message = 'Pharmacy menu has been updated successfully';

        } else {

            // Insert Process
            $success = CommonEloHelper::insert_table_row('kod_menus', $request->all());

            // Response message
            $message = 'Pharmacy menu has been created successfully';

        } // if( $request->has('row_id') && !empty($request->row_id) )

        if($success){

            Session::flash('success', $message);
            return response()->success($message);

        } else {

            Session::flash('success','Oops! Somethings went wrong, please try again later.');
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        } // if($success)

    } // End => public function add_edit_menu_process(Request $request)

    // Start => public function delete_process($row_id=false)
    public function delete_process($row_id=false){

        // [ 1 ] - Remove all the menu items of this menu
        $success = CommonEloHelper::delete_table_where_arr('kod_menu_links', array('menu_id' => $row_id) );

        // [ 2 ] - Remove the menu
        $success = CommonEloHelper::delete_table_row('kod_menus', $row_id);

        // Response message
        $message = 'Pharmacy menu has been deleted successfully';

        if($success){

            Session::flash('success', $message);
            return response()->success($message);

        } else {

            Session::flash('success','Oops! Somethings went wrong, please try again later.'); 
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        } // if($success)

    } // End => public function delete_process($row_id=false)

    ////////////// MENU LINKS //////////////

    // Start => public function add_edit_menu_link(Request $request)
    public function add_edit_menu_link(Request $request){

        $row_details = array();
        if($request->has('item_id') && !empty($request->item_id)){
            $row_details = CommonEloHelper::get_table_row('kod_menu_links', $request->item_id);
        } // if($request->has('item_id') && !empty($request->item_id))

        $menu_id = $request->menu_id;

        return view('backend.admin.pharmacy_menus.add_edit_menu_link_modal', ['row_details' => $row_details, 'menu_id' => $menu_id]);

    } // End => public function add_edit_menu_link(Request $request)

    // Start => public function add_edit_menu_link_process(Request $request)
    public function add_edit_menu_link_process(Request $request){

        // Prepare ins/upd array
        $ins_upd_arr = $request->all();

        $ins_upd_arr['parent_id'] = (!empty($request->parent_id)) ? $request->parent_id : NULL ;

        // Check if service, page or static page is selected => if yes then => set reference_id according and type according

        if($request->reference_type == 'SERVICE'){

            // Reference type service is selected
            $ins_upd_arr['reference_id'] = $request->service_id;

        } else if($request->reference_type == 'PAGE'){

            // Reference type page is selected
            $ins_upd_arr['reference_id'] = $request->page_id;

        } else if($request->reference_type == 'STATIC_PAGE'){

            // Reference type static page is selected
            $ins_upd_arr['reference_id'] = $request->static_page_id;

        } else if($request->reference_type == 'URL'){

            // Reference type url is selected
            $ins_upd_arr['reference_id'] = NULL;

            // Check if new tab is checked
            $ins_upd_arr['new_tab'] = ($request->has('new_tab') && !empty($request->new_tab)) ? '1' : '0' ;

        } // if($request->reference_type == 'SERVICE')

        if( $request->has('row_id') && !empty($request->row_id) ){
            
            // Update Process
            $success = CommonEloHelper::update_table_row('kod_menu_links', $request->row_id, $ins_upd_arr);

            // Response message
            $message = 'Menu item has been updated successfully';

        } else {

            // Insert Process
            $success = CommonEloHelper::insert_table_row('kod_menu_links', $ins_upd_arr);

            // Response message
            $message = 'Menu item has been created successfully';

        } // if( $request->has('row_id') && !empty($request->row_id) )

        if($success){

            Session::flash('success', $message);
            return response()->success($message);

        } else {

            Session::flash('success','Oops! Somethings went wrong, please try again later.');
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        } // if($success)

    } // End => public function add_edit_menu_link_process(Request $request)

    // Start => public function delete_menu_link_process($row_id=false)
    public function delete_menu_link_process($row_id=false){

        // [ 1 ] - Check if menu link is parent and has its child links => if yes then => Remove all the child links of this parent menu link

        $has_child_links = CommonEloHelper::get_table_result_where_arr('kod_menu_links', array('parent_id' => $row_id) );

        // If has child links
        if(!empty($has_child_links)){

            ////////////// Has child links //////////////

            // Remove child links
            $success = CommonEloHelper::delete_table_where_arr('kod_menu_links', array('parent_id' => $row_id) );

        } // if(!empty($has_child_links))

        // [ 2 ] - Remove the menu link
        $success = CommonEloHelper::delete_table_row('kod_menu_links', $row_id);

        // Response message
        $message = 'Pharmacy menu item has been deleted successfully';

        if($success){

            Session::flash('success', $message);
            return response()->success($message);

        } else {

            Session::flash('success','Oops! Somethings went wrong, please try again later.');
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        } // if($success)

    } // End => public function delete_menu_link_process($row_id=false)

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // Start => public function store(Request $request)
    public function store(Request $request){

        // $form_config = CommonMcConfigHelper::get_form_config();
        $form_config_regex_arr = $form_config['regex_arr'];
        $validate_titles = $form_config_regex_arr['validate_titles']; // "/^[a-zA-Z0-9\s()'-]+$/";
        $validate_grade = $form_config_regex_arr['validate_grade']; // '/[a-zA-Z0-9\s+-]+$/';
        $validate_textareas = $form_config_regex_arr['validate_textareas']; // '/[a-zA-Z0-9\s().,-]+$/';
        $combined_address = $form_config_regex_arr['combined_address']; // "/^[a-zA-Z0-9\s()'.,-]*$/";
        $validate_url_slug = $form_config_regex_arr['validate_url_slug']; // "/^[a-zA-Z0-9-\s']*$/";
        
        // return $request->thumbnail; exit;
        if($request->has('item_id') && !empty($request->item_id)){


            $id = $request->item_id;

            $request->validate([

                'title' => ['required','max:100', 'regex:'.$form_config_regex_arr['pharmacy_validate_titles']],

            ]);

            $Pharmacy_service = PharmacyService::findOrFail($id);

            $updatable = ['meta_keywords','title','pharmacy_id','intro', 'description', 'thumbnail', 'image', 'category', 'position', 'display_order', 'status', 'slug', 'meta_title', 'key_words', 'meta_description', 'fa_icon', 'external_service_url', 'open_url_new_tab'];

            foreach($request->all() as $key => $val){
                
                if($key != 'image' && $key != 'thumbnail' && $key != 'item_id' && $key != 'remove_image'  && $key !=  'remove_thumbnail'){
                    
                    $Pharmacy_service->$key = $val;

                } // if($key != 'image' && $key != 'thumbnail')
                
            } // foreach($request->all() as $key => $val)

            $slug = "";

            if($request->has('slug') && !empty($request->slug)){
                    
                $slug  = Str::of($request->slug)->slug('-');
            
            } // if($request->has('slug') && !empty($request->slug))
            

            if(PharmacyService::where('slug',$request->slug)->where('pharmacy_id',session()->get('pharmacy_id'))->where('id','!=', $id)->count() > 0){
            
                $message='Slug Aready exist.';
                return $this->error($message);
    
            } //if(PharmacyService::where('slug',$request->slug)->count()){
                
            $Pharmacy_service->slug = $slug;



            //remove file through API  start here

            if(!empty($request->has('remove_image'))){
                    
                $folder_structure = array(

                    'services',
                    'image'
                );
        
                if($Pharmacy_service->image != null && !empty($Pharmacy_service->image)){
        
                    $file_upload = $this->CommonFileService->delete_single_api($request, $folder_structure, $Pharmacy_service->image);           
                   
                } // if($item_details->$image_field_name != null && !empty($item_details->$image_field_name)){
            
                $Pharmacy_service->image = '';

            } // if(!empty($request->has('remove_image'))){

            //remove file through API  start here

            //upload file from API start here
            if(!empty($request->hasFile('image'))){
        
                $folder_structure = array(

                    'services',
                    'image' 
                );

                $file_name = 'image-'.$Pharmacy_service->id.'.'.$request->file('image')->getClientOriginalExtension();

                $Pharmacy_service->image = $file_name;
                
                $this->CommonFileService->save_single_file_api($request, 'image', $folder_structure, $file_name);
                
            } // if(!empty($request->hasFile('image')))
            
            ////upload file from API start here

            //remove thumbnail through API  start here

            if(!empty($request->has('remove_thumbnail'))){
                    
                $folder_structure = array(

                    'services',
                    'thumbnail'
                );
        
                if($Pharmacy_service->thumbnail != null && !empty($Pharmacy_service->thumbnail)){
        
                    $file_upload = $this->CommonFileService->delete_single_api($request, $folder_structure, $Pharmacy_service->thumbnail);           
                   
                } // if($item_details->$image_field_name != null && !empty($item_details->$image_field_name)){
            
                    $Pharmacy_service->thumbnail = '';   
            }//if(!empty($request->has('remove_image'))){

            //remove thumbnail through API  start here

            //upload thumbnail from API start here
            if(!empty($request->hasFile('thumbnail'))){
        
                $folder_structure = array(

                    'services',
                    'thumbnail' 
                );

                $file_name = 'thumbnail-'.$Pharmacy_service->id.'.'.$request->file('thumbnail')->getClientOriginalExtension();
                $Pharmacy_service->thumbnail = $file_name;
                $this->CommonFileService->save_single_file_api($request, 'thumbnail', $folder_structure, $file_name);
                
            }
            
            //// upload thumbnail from API start here

            if($request->open_url_new_tab == 'on'){
                
                $Pharmacy_service->open_url_new_tab = '1';

            } else {

                $Pharmacy_service->open_url_new_tab = '0';

            } // if($request->open_url_new_tab == 'on')

          


            $Pharmacy_service->save();
            $message='Pharmacy Service has been updated successfully';
            return $this->success($Pharmacy_service, 200, $message);
            
        } // if($request->has('item_id') && !empty($request->item_id))

        

        $Pharmacy_service = new PharmacyService();
        $input = $request->all();

        //slug generator

        $slug = "";

        if($request->has('title') && !empty($request->title)){
                
            $slug= Str::of($request->title)->slug('-');

            if(PharmacyService::where('slug',$slug)->where('pharmacy_id',session()->get('pharmacy_id'))->count() > 0){
            
                $message='Title Aready exist.';
                return $this->error($message);
               
            } //if(PharmacyService::where('slug',$request->slug)->count()){
                
            $input['slug'] = $slug;
        } // if($request->has('slug') && !empty($request->slug))

        $request->validate([

            'title' => ['required', 'regex:'.$validate_titles],
            'intro' => ['required', 'regex:'.$validate_titles],
            'description' => ['required']
        
            // 'image' => 'required|mimes:jpg,png,jpeg,gif|max:500000',
            // 'thumbnail' => 'required|mimes:jpg,png,jpeg,gif|max:500000'

        ]);

        
        if($request->open_url_new_tab == 'on'){
            
            $input['open_url_new_tab'] = '1';

        } else {
            $input['open_url_new_tab'] = '0';
        } // if($request->open_url_new_tab == 'on')


        
        
        
        $Pharmacy_service = PharmacyService::create($input);




        //test start here

        if(!empty($request->hasFile('image'))){
            

            $folder_structure = array(

                'services',
                'image' 
            );

            $file_name = 'image-'.$Pharmacy_service->id.'.'.$request->file('image')->getClientOriginalExtension();
            $Pharmacy_service->image = $file_name;
             $this->CommonFileService->save_single_file_api($request, 'image', $folder_structure, $file_name);
            
        } // if(!empty($request->hasFile('image')))

        if(!empty($request->hasFile('thumbnail'))){
    
            $folder_structure = array(

                'services',
                'thumbnail' 
            );

            $file_name = 'thumbnail-'.$Pharmacy_service->id.'.'.$request->file('thumbnail')->getClientOriginalExtension();
            
            $Pharmacy_service->thumbnail = $file_name;

            $this->CommonFileService->save_single_file_api($request, 'thumbnail', $folder_structure, $file_name);

        } // if(!empty($request->hasFile('thumbnail')))

        $Pharmacy_service->save();  
    
        $message='Service has been created successfully';
        return $this->success($Pharmacy_service, 200, $message);

    } // End => public function store(Request $request)

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request,$id)
    {
        
        $Pharmacy_service = PharmacyService::findOrFail( $id);
        if($Pharmacy_service->image != null && !empty($Pharmacy_service->image)){


                    
                $folder_structure = array(

                    'services',
                    'image'
                );
        
                if($Pharmacy_service->image != null && !empty($Pharmacy_service->image)){
        
                    $file_upload = $this->CommonFileService->delete_single_api($request, $folder_structure, $Pharmacy_service->image);           
                   
                } // if($item_details->$image_field_name != null && !empty($item_details->$image_field_name)){
            


        }

        if($Pharmacy_service->thumbnail != null && !empty($Pharmacy_service->thumbnail)){

                    
                $folder_structure = array(

                    'services',
                    'thumbnail'
                );
        
                if($Pharmacy_service->thumbnail != null && !empty($Pharmacy_service->thumbnail)){
        
                    $file_upload = $this->CommonFileService->delete_single_api($request, $folder_structure, $Pharmacy_service->thumbnail);           
                   
                } // if($item_details->$image_field_name != null && !empty($item_details->$image_field_name)){
            
        }

        $Pharmacy_service->delete();
        $message='Service design has been deleted successfully';
        return $this->success('no data', 200, $message);

    }

    // Start => public function addEditForm(Request $request)
    public function addEditForm(Request $request){


        if($request->has('item_id') && !empty($request->item_id)){
            
            // Edit
            $row_details = PharmacyService::findOrFail($request->item_id);
            return view('pharmacy_service.add_edit_modal', ['row_details' => $row_details]);
            
        } else {

            return view('pharmacy_service.add_edit_modal');

        } // if($request->has('item_id') && !empty($request->item_id))

    } // End => public function addEditForm(Request $request)


    public function change_status(Request $request){

        $PharmacyService = PharmacyService::findOrFail($request->item_id);
        $PharmacyService->status = $request->status;  
        $PharmacyService->save();
        $message = "Pharmacy status has been changed.";
        return $this->success('no data',200,$message);

    }


    public function change_order(Request $request){

        $PharmacyService = PharmacyService::findOrFail($request->item_id);
        $PharmacyService->display_order = $request->order;  
        $PharmacyService->save();
        $message = "Pharmacy status has been changed.";
        return $this->success('no data',200,$message);

    }


    

}
