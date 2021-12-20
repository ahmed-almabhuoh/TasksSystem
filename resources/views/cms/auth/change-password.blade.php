@extends('cms.parent')

@section('title', 'Change Password')

@section('styles')
    {{-- Styles --}}
@endsection

@section('capital-starter-page', 'Change Password')
@section('home-starter-page', 'Home')
@section('small-starter-page', 'change-password')

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
                      <h3 class="card-title">Change Password</h3>
                    </div>

                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="reset-form">
                        @csrf
                      <div class="card-body">
                        <div class="form-group">
                          <label for="current_password">Current Password</label>
                          <input type="password" class="form-control" id="current_password" placeholder="Enter Current Password">
                        </div>
                        <div class="form-group">
                          <label for="new_password">New Password</label>
                          <input type="password" class="form-control" id="new_password" placeholder="Enter New Password">
                        </div>
                        <div class="form-group">
                          <label for="new_password_confirmation">Re-new Password</label>
                          <input type="password" class="form-control" id="new_password_confirmation" placeholder="Re-enter New Password">
                        </div>
                      </div>
                      <!-- /.card-body -->
      
                      <div class="card-footer">
                        <button type="button" class="btn btn-primary" onclick="updatePassword()">Update Password</button>
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
      function updatePassword () {
        // cms/admin/categories
        axios.put('/cms/admin/update-password', {
          current_password: document.getElementById('current_password').value,
          new_password: document.getElementById('new_password').value,
          new_password_confirmation: document.getElementById('new_password_confirmation').value,
        })
          .then(function (response) {
            // handle success
            console.log(response);
            toastr.success(response.data.message);
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
