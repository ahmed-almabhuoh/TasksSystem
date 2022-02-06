@extends('cms.parent')

@section('title', 'Create Task')

@section('styles')
    {{-- Styles --}}
@endsection

@section('capital-starter-page', 'Create Task')
@section('home-starter-page', 'Home')
@section('small-starter-page', 'Task')

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
                      <h3 class="card-title">Create Task</h3>
                    </div>

                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="reset-form">
                        @csrf
                      <div class="card-body">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category" id="category">
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}"
                                            {{($its_category->id == $category->id ? 'selected' : '')}}
                                        >{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                          <label for="title">Title</label>
                          <input type="text" class="form-control" id="title" placeholder="Enter title"
                            value="{{$task->title}}"
                          >
                        </div>
                        <div class="form-group">
                            <label for="desc">Description</label>
                            <input type="text" class="form-control" id="desc" placeholder="Enter task description"
                            value="{{$task->desc}}">
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
                        <button type="button" class="btn btn-primary" onclick="update('{{$task->id}}')">Submit</button>
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
      function update (id) {
        // cms/admin/categories
        axios.put('/cms/admin/task/'+id, {
            title: document.getElementById('title').value,
            desc: document.getElementById('desc').value,
            status: document.getElementById('active').checked,
            category_id: document.getElementById('category').value,
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
