@extends('cms.parent')

@section('title', 'Create Adminببب')

@section('styles')
    {{-- Styles --}}
@endsection

@section('capital-starter-page', 'Create admin')
@section('home-starter-page', 'Home')
@section('small-starter-page', 'admins')

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
                      <h3 class="card-title">Create Admin</h3>
                    </div>

                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="reset-form">
                        @csrf
                      <div class="card-body">

                        <div class="form-group">
                            <label for="name">role name</label>
                            <select name="role" id="role">
                                @forelse ($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>

                                @empty

                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                          <label for="name">Name</label>
                          <input type="text" class="form-control" id="name" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                          <label for="email=">E-mail</label>
                          <input type="email" class="form-control" id="email" placeholder="Enter e-mail">
                        </div>
                        <div class="form-group">
                          <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="active" checked>
                            <label class="custom-control-label" for="active">Active</label>
                          </div>
                        </div>
                      </div>
                      <!-- /.card-body -->

                      <div class="card-footer">
                        <button type="button" class="btn btn-primary" onclick="store()">Submit</button>
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
    <script>
      function store () {
        // cms/admin/categories
        axios.post('/cms/admin/admins', {
        role_id: document.getElementById('role').value,
          name: document.getElementById('name').value,
          email: document.getElementById('email').value,
          status: document.getElementById('active').checked,
        })
          .then(function (response) {
            // handle success
            console.log(response);
            toastr.success(response.data.message);
            // document.getElementById('set-form').reset();
            document.getElementById('reset-form').reset();
          })
          .catch(function (error) {
            // handle error
            console.log(error);
            toastr.error(error.response.data.message)
          })
          .then(function () {
            // always executed
          });
      }
    </script>
@endsection

@section('company-name', 'your-company-name')

@section('version', 'System-version')
