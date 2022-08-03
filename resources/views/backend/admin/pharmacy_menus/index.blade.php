@extends('backend.admin.master')
@section('title', 'Menus Section')
@section('content')
    <div class="container">
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title"> Menus </h4>
            </div>
            <div class="page-rightheader ml-auto d-lg-flex d-none">
                
                <a href="javascript:;" class="btn btn-primary add-edit-menu-trigger" mc-item-id=""><i class="fa fa-plus mr-2"></i> Add New Menu </a>

            </div>
        </div>
        <!--Row-->
            @include('backend.admin.components.messages')
        <!--Row-->
        <!--End Page header-->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                
                <div class="row">
                    
                    @if(!empty($pharmacy_menus))

                        @foreach($pharmacy_menus as $pharmacy_menu)

                            <div class="col-lg-12">
                                <div class="card">
                                    
                                    <div class="card-header bg-primary">

                                        <h5 class="card-title text-white">
                                            {{ $pharmacy_menu['title'] }}
                                        </h5>

                                        <div class="card-options">

                                            <div class="dropdown">
                                                    
                                                <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <i class="fa fa-cogs mr-2"></i> Settings
                                                </button>

                                                <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-73px, -152px, 0px);">

                                                    <a class="dropdown-item" href="javascript:;"> Actions </a>
                                                    <div class="dropdown-divider"></div>

                                                    <a href="javascript:;" class="dropdown-item add-edit-link-trigger" mc-item-id="" mc-menu-id="{{ $pharmacy_menu['id'] }}"> Add New Link </a>
                                            
                                                    <a href="javascript:;" class="dropdown-item add-edit-menu-trigger" mc-item-id="{{ $pharmacy_menu['id'] }}"> Edit Menu </a>

                                                    <!-- Button trigger modal -->                                                
                                                    <a href="javascript:;" class="dropdown-item" mc-item-id="{{ $pharmacy_menu['id'] }}" onClick="delete_menu(this)" > Delete Menu </a>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="card-body">

                                        @php

                                        /////////////// Verify if the pharmacy_menu has parent menu items added ///////////////

                                        $pharmacy_parent_menu_links = CommonEloHelper::get_table_result_where_arr('kod_menu_links', array('menu_id' => $pharmacy_menu['id'], 'parent_id' => NULL), array('display_order' => 'ASC'));

                                        // print_r($pharmacy_parent_menu_links);

                                        @endphp

                                        @if(count($pharmacy_parent_menu_links) > 0)

                                            <div class="table-responsive">

                                                <table class="table table-striped table-bordered text-nowrap" style="width:100%">
                                                    
                                                    <thead>

                                                        <tr class="bold">
                                                            
                                                            <th class="border-bottom-0"> Title </th>
                                                            <th class="border-bottom-0" width="10%"> Order </th>
                                                            <th class="border-bottom-0" width="12%"> Status </th>
                                                            <th class="text-center border-bottom-0" width="10%"> Action </th>

                                                        </tr>

                                                    </thead>

                                                    <tbody id="tbody">

                                                        @foreach($pharmacy_parent_menu_links as $parent_link)
                                                        
                                                            @php
                                                                
                                                                /////////////// Verify if the pharmacy_menu has parent menu items added ///////////////

                                                                $pharmacy_child_menu_links = CommonEloHelper::get_table_result_where_arr('kod_menu_links', array('menu_id' => $pharmacy_menu['id'], 'parent_id' => $parent_link['id']), array('display_order' => 'ASC'));

                                                            @endphp

                                                            <tr>
                                                                
                                                                <td>

                                                                    @if(count($pharmacy_child_menu_links) > 0)

                                                                        <strong>
                                                                            {{ $parent_link['title'] }}
                                                                        </strong>

                                                                    @else

                                                                        {{ $parent_link['title'] }}

                                                                    @endif

                                                                </td>

                                                                <td>

                                                                    @include('backend.admin.components.display_order', ['item_details' => !empty($parent_link) ? $parent_link : '' , 'resource' => 'menu_links' ])

                                                                </td>
                                                                
                                                                <td>
                                                                  
                                                                    @include('backend.admin.components.status', ['item_details' => !empty($parent_link) ? $parent_link : '' , 'resource' => 'menu_links' ])

                                                                </td>

                                                                <td>
                                                                    
                                                                    <a href="javascript:;" class="btn btn-sm btn-success mr-2 add-edit-link-trigger" mc-item-id="{{ $parent_link['id'] }}" mc-menu-id="{{ $pharmacy_menu['id'] }}"> <i class="fa fa-edit"></i> </a>

                                                                    <a href="javascript:;" class="btn btn-sm btn-danger" mc-item-id="{{ $parent_link['id'] }}" onClick="delete_menu_item(this)"> <i class="fa fa-trash"></i> </a>

                                                                </td>

                                                            </tr>

                                                            @if(count($pharmacy_child_menu_links) > 0)

                                                                @foreach($pharmacy_child_menu_links as $child_link)
                                                                    
                                                                    <tr>
                                                                        
                                                                        <td>
                                                                           
                                                                            <strong>
                                                                                {{ $parent_link['title'] }}
                                                                            </strong>

                                                                            <i class="fa fa-angle-double-right ml-2 mr-2"></i>

                                                                            {{ $child_link['title'] }}

                                                                        </td>

                                                                        <td>



                                                                        </td>
                                                                        
                                                                        <td>
                                                                          
                                                                            

                                                                        </td>

                                                                        <td>
                                                                        
                                                                            <a href="javascript:;" class="btn btn-sm btn-success mr-2 add-edit-link-trigger" mc-item-id="{{ $child_link['id'] }}" mc-menu-id="{{ $pharmacy_menu['id'] }}"> <i class="fa fa-edit"></i> </a>
                                                                        
                                                                            <a href="javascript:;" class="btn btn-sm btn-danger" mc-item-id="{{ $child_link['id'] }}" onClick="delete_menu_item(this)"> <i class="fa fa-trash"></i> </a>
                                                                        
                                                                        </td>

                                                                    </tr>

                                                                @endforeach

                                                            @endif

                                                        @endforeach

                                                    </tbody>

                                                </table>

                                            </div>

                                        @else

                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <a href="javascript:;" class="add-edit-link-trigger" mc-item-id="" mc-menu-id="{{ $pharmacy_menu['id'] }}"><i class="ti-plus mr-2"></i>Add new menu item</a>
                                                </div>
                                            </div>

                                        @endif

                                    </div>

                                </div>
                            </div> <!-- end col -->

                        @endforeach

                    @endif

                </div>

            </div>
        </div>
        <!--End row-->
    </div>

    <!-- end app-content-->

@stop

@section('scripts')

    <script type="text/javascript">
        
        $(document).ready(function(){

            $('.add-edit-menu-trigger').click(function() {

                var _token = $('meta[name="csrf-token"]').attr('content');

                var _this = this;
                var item_id = $(_this).attr('mc-item-id');

                $.ajax({

                    type: "POST",
                    url: "/pharmacy_menus/add_edit_menu",
                    data: {
                        'item_id': item_id,
                        _token: _token
                    },

                    beforeSend: function(result) {
                        //$("#overlay").removeClass("hidden");
                    },
                    success: function(response) {

                        
                        $("#loading").css("display","none");

                        // swal(response);

                        var popup_title = '';

                        if (item_id == '') {

                            // Add New
                            popup_title = 'Add New Menu';

                        } else {

                            // Edit
                            popup_title = 'Edit Menu';

                        } // if(item_id == '')

                        $('#mc-popup-dialog').addClass('modal-lg');

                        // Set Heading
                        $('#general_bootstrap_ajax_popup_heading').html(popup_title);

                        // Set Body
                        $('#general_bootstrap_ajax_popup_body').html(response);

                        // Set Footer
                        // $('#general_bootstrap_ajax_popup_footer').prepend('');

                        $('#general_bootstrap_ajax_popup').modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                        /*
                        if ($(_this).attr('mc-edit-btn') == "edit") {
                            $('#mc_frm_submit_btn').attr('edit_button', 'yes');
                        } // if($(_this).attr('mc-edit-btn') == "edit")
                        */

                    } // success

                }); // $.ajax

            }); // click => add-edit-menu-trigger

            $('.add-edit-link-trigger').click(function() {

                var _token = $('meta[name="csrf-token"]').attr('content');
                var _this = this;
                
                var item_id = $(_this).attr('mc-item-id');
                var menu_id = $(_this).attr('mc-menu-id');

                $.ajax({

                    type: "POST",
                    url: "/pharmacy_menus/add_edit_menu_link",
                    data: {
                        'item_id': item_id,
                        'menu_id': menu_id,
                        _token: _token
                    },

                    beforeSend: function(result) {
                        //$("#overlay").removeClass("hidden");
                    },
                    success: function(response) {

                        
                        $("#loading").css("display","none");

                        // swal(response);

                        var popup_title = '';

                        if (item_id == '') {

                            // Add New
                            popup_title = 'Add New Menu Item';

                        } else {

                            // Edit
                            popup_title = 'Edit Menu Item';

                        } // if(item_id == '')

                        $('#mc-popup-dialog').addClass('modal-lg');

                        // Set Heading
                        $('#general_bootstrap_ajax_popup_heading').html(popup_title);

                        // Set Body
                        $('#general_bootstrap_ajax_popup_body').html(response);

                        // Set Footer
                        $('#general_bootstrap_ajax_popup_footer').prepend('');

                        $('#general_bootstrap_ajax_popup').modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                        /*
                        if ($(_this).attr('mc-edit-btn') == "edit") {
                            $('#mc_frm_submit_btn').attr('edit_button', 'yes');
                        } // if($(_this).attr('mc-edit-btn') == "edit")
                        */

                    } // success

                }); // $.ajax

            }); // click => add-edit-link-trigger

        }); // ready

        // Start => function delete_menu(e)
        function delete_menu(e){
            
            var item_id = $(e).attr('mc-item-id');

            // alert(item_id);

            swal({

                title: "Are you sure?",
                text: "Are you sure you want to delete this menu?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false

            },
            function() {

                $.ajax({

                    type: "DELETE",
                    url: "/pharmacy_menus/delete/" + item_id,
                    data: {
                        'item_id': item_id
                    },
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    beforeSend: function(result) {
                        $("#overlay").removeClass("hidden");
                    },
                    success: function(response) {
                        
                        // swal("Deleted!", "Pharmacy menu successfully deleted.", "success");
                        
                        // mc_notify('success', response.message);
                        
                        location.reload()

                    },
                    error: function(request, status, error) {
                        // mc_notify('danger', response.responseText);
                    }


                }); // $.ajax

            });

        } // End => function delete_menu(e)

        // Start => function delete_menu_item(e)
        function delete_menu_item(e){
            
            var item_id = $(e).attr('mc-item-id');

            // alert(item_id);

            swal({

                title: "Are you sure?",
                text: "Are you sure you want to delete this menu item?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false

            },
            function() {

                $.ajax({

                    type: "DELETE",
                    url: "/pharmacy_menus/delete_menu_link_process/" + item_id,
                    data: {
                        'item_id': item_id
                    },
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    beforeSend: function(result) {
                        $("#overlay").removeClass("hidden");
                    },
                    success: function(response) {
                        
                        // swal("Deleted!", "Pharmacy menu item successfully deleted.", "success");
                        
                        // mc_notify('success', response.message);
                        
                        location.reload()

                    },
                    error: function(request, status, error) {
                        // mc_notify('danger', response.responseText);
                    }


                }); // $.ajax

            });

        } // End => function delete_menu_item(e)

    </script>
    
@stop
