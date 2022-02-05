@extends('cms.parent')

@section('title', 'Role & Permissions')

@section('capital-starter-page', 'All Role & Permissions')
@section('home-starter-page', 'Home')
@section('small-starter-page', 'Role & Permissions')

@section('styles')
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('cms/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Role & Permissions</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover table-bordered table-striped text-nowrap">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Guard Name</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($permissions as $permission)
                      <tr>
                        <td>{{$permission->name}}</td>
                        <td>{{$permission->guard_name}}</td>
                        <td>
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="permissions_{{$permission->id}}" onchange="assignPermission({{$role->id}}, {{$permission->id}})"
                                    @if ($permission->assigned == true)
                                        checked
                                    @endif
                                >
                                <label for="permissions_{{$permission->id}}">
                                </label>
                              </div>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('company-name', env('APP_NAME'))

@section('version', 'Version: ' . env('APP_VERSION'))


@section('scripts')
    <script>

      function assignPermission (roleId, PermissionId) {
        // cms/admin/permissions/{permission}
        axios.post('/cms/admin/role/'+roleId+'/permission', {
            permission_id: PermissionId,
        })
          .then(function (response) {
            // handle success
            console.log(response);
            toastr.success(response.data.message);
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
