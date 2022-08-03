@extends('backend.admin.master')
@section('title', 'Faq Categories')
@section('content')
    <div class="container">
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Faq Category</h4>
            </div>
            <div class="page-rightheader ml-auto d-lg-flex d-none">

                <a href="javascript:;" class="btn btn-primary add-edit-faq-category" data-hash-id=""><i class="fa fa-plus mr-2"></i> Add New FAQ Category </a>

            </div>
        </div>
        <!--Row-->
        @include('backend.admin.components.messages')
        <!--Row-->
        <!--End Page header-->
        <div class="row row-deck">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List Faq Category</h3>
                        <div class="card-options">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="faq-datatable" class="table table-striped table-bordered text-nowrap" style="width:100%">
                                <thead>
                                    <tr class="bold">
                                        <th class="border-bottom-0" width="13%">Title</th>
                                        <th class="border-bottom-0" width="6%">Status</th>
                                        <th class="text-center border-bottom-0" width="1%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($FaqCategory as $category)
                                        <tr>
                                            <td>
                                                {{ $category->title }}
                                            </td>
                                            <td>

                                                 @include('backend.admin.components.status', ['item_details' => !empty($category) ? $category : '' , 'resource' => 'faq_categories' ])

                                            </td>

                                            <td class="text-center">
                                                <button type="button" title="edit" class="btn btn-success btn-sm add-edit-faq-category" data-hash-id="{{ $category->hash_id }}"><i class="fa fa-edit"></i></button>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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

            $('.add-edit-faq-category').click(function(){

                var hash_id = $(this).attr('data-hash-id');

                var request_url = (hash_id != '') ? 'faq-category/'+hash_id+'/edit' : 'faq-category/create' ;

                $.ajax({

                    type: "GET",


                    url: request_url,

                    // processData: false,
                    // contentType: false,

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    /*data: {

                        'hash_id' : hash_id,

                    },*/

                    beforeSend: function(result) {

                        // $("#loading").css("display","block");

                        $('#crud_errors_div').addClass('d-none');
                        $('#crud_errors_ul').html('');

                    },
                    success: function(response) {

                        // $("#loading").css("display","none");

                        // swal(response);

                        var popup_title = '';

                        if(hash_id == ''){

                            popup_title = 'Add New FAQ';

                        } else {

                            popup_title = 'Edit FAQ';

                        } // if(hash_id == '')

                        $('#mc-popup-dialog').addClass('modal-lg');

                        // Set Heading
                        $('#general_bootstrap_ajax_popup_heading').html(popup_title);

                        // Set Body
                        $('#crud_contents').html(response);

                        // Set Footer
                        // $('#general_bootstrap_ajax_popup_footer').prepend('');

                        $('#general_bootstrap_ajax_popup').modal({
                            backdrop: 'static',
                            keyboard: false
                        });

                    }, // success
                    error: function(xhr, status, error) {
                        mcShowErrorsGet(xhr, status, error)
                    }

                }); // $.ajax

            }); // click => .add-edit-banner

            $('#faq-datatable').DataTable();
            $('#description').summernote({
                  height: 100,                 // set editor height
            });
            $('#edit_description').summernote({
                  height: 100,                 // set editor height
            });
        });

        function filterData(data){
            while(data.startsWith('<p><br></p>')){
            data=data.replace('<p><br></p>','')
            }
            while(data.endsWith('<p><br></p>')){
            data=data.replace(new RegExp('<p><br></p>$'),'')
            }
            return data;
        }







    </script>
@stop
