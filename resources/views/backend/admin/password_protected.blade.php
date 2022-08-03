@extends('backend.admin.master')
@section('title', 'Banners Section')
@section('content')
    <div class="container">
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Banners</h4>
            </div>
            <div class="page-rightheader ml-auto d-lg-flex d-none">
                <a href="javascript:;" class="btn btn-primary add-edit-banner" data-hash-id=""><i class="fa fa-plus mr-2"></i> Add New Banner </a>
            </div>
        </div>
  
        <!--End Page header-->
        <div class="row row-deck">
            <div class="col-xl-12 col-lg-12 col-md-12">
               <form action="password_protected_submit" method="get" accept-charset="utf-8">
                   <div class="col-md-12">
                    <div class="form-group">
                       <label class="form-label">Enter Password<span class="text-red">*</span></label>
                       <input type="text" class="form-control" id="title" name="title"  required />
                    </div>
                 </div>
                 <div class="col-md-12">
                    <div class="form-group">
                     <button> Submit</button>                   
                    </div>
                 </div>
               </form>
            </div>
        </div>
        <!--End row-->
    </div>

    <!-- end app-content-->

@stop

@section('scripts')

@stop
