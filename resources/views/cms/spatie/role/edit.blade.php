@extends('cms.parent')

@section('title', 'Upadte City')

@section('styles')
    {{-- Styles --}}
@endsection

@section('capital-starter-page', 'Upadte City')
@section('home-starter-page', 'Home')
@section('small-starter-page', 'cities')

@section('content')
    {{-- Content Code --}}
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
              <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                  <!-- general form elements -->
                  <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Upadte City</h3>
                    </div>
                    @if ($errors->any())
                      <div class="card-body">
                        <div class="alert alert-danger alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <h5><i class="icon fas fa-ban"></i> Validation Errors!</h5>
                          @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                          @endforeach
                        </div>
                      </div>
                    @endif

                    @if (session()->has('message'))
                      <div class="card-body">
                        <div class="alert alert-success alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <h5><i class="icon fas fa-check"></i> Alert!</h5>
                          {{session()->get('message')}}
                        </div>
                      </div>
                    @endif
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" action="{{route('cities.update', $city->id)}}">
                        @csrf
                        @method('PUT')
                      <div class="card-body">
                        {{-- {{old('name', $city->name)}} --}}
                        <div class="form-group">
                          <label for="name">Name</label>
                          <input type="text" class="form-control" id="name" name="name" placeholder="Enter name"
                          value="@if(old('name')) {{old('name')}} @else {{$city->name}} @endif">
                          {{-- {{$city->name}} --}}
                        </div>
                      </div>
                      {{old('name')}}
                      <!-- /.card-body -->
      
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                    </form>
                  </div>
                  <!-- /.card -->
      
            </div><!-- /.container-fluid -->
          </section>
          <!-- /.content -->
@endsection

@section('scripts')
    {{-- Scripts --}}
@endsection

@section('company-name', 'your-company-name')

@section('version', 'System-version')
