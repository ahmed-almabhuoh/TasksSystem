@extends('cms.parent')

@section('title', 'Create Role')

@section('styles')
    {{-- Styles --}}
@endsection

@section('capital-starter-page', 'Create Role')
@section('home-starter-page', 'Home')
@section('small-starter-page', 'Role')

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
                      <h3 class="card-title">Create Role</h3>
                    </div>

                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="reset-form">
                        @csrf
                        <div class="drop" style="margin: 15px;margin-top: 30px; margin-left: 30px;">
                            <label for="role">Choose a guard:</label>
                            <select name="guards" id="guards">
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                      <div class="card-body">
                        <div class="form-group">
                          <label for="name">Name</label>
                          <input type="text" class="form-control" id="name" placeholder="Enter name">
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
        axios.post('/cms/admin/role', {
          name: document.getElementById('name').value,
          guard_name: document.getElementById('guards').value,
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
