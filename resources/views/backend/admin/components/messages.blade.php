@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
        <span>{!! Session::get('success') !!}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (Session::has('successEmail'))
    <div class="alert alert-success alert-dismissible fade show" id="alert-success-email" role="alert">
        <span>{!! Session::get('successEmail') !!}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" id="alert-danger" role="alert">
        <span>{!! Session::get('error') !!}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (Session::has('warn'))
    <div class="alert alert-danger alert-dismissible fade show" id="alert-warn" role="alert">
        <span>{!! Session::get('warn') !!}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (Session::has('warnEmail'))
    <div class="alert alert-danger alert-dismissible fade show" id="alert-warn-email" role="alert">
        <span>{!! Session::get('warnEmail') !!}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger" id="">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


