@if($errors->any())
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @foreach($errors->all() as $error)
            <strong>{{ $error }}</strong><br/>
        @endforeach
    </div>
@endif

@if(Session::has('flash_message'))
    <div class="alert {{ Session::get('flash_type_message') }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>{{session('flash_message')}}</strong>
    </div>
@endif