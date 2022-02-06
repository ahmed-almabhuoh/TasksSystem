@extends('cms.parent')

@section('title', 'Categories')

@section('capital-starter-page', 'Categories')
@section('home-starter-page', 'Home')
@section('small-starter-page', 'categories')

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Categories</h3>

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
                      <th>NO.</th>
                      <th>Name</th>
                      <th>Active</th>
                      <th>Created At</th>
                      <th>Updated At</th>
                      <th>Settings</th>
                    </tr>
                  </thead>
                  <tbody>
                      @php
                          $no = 0;
                      @endphp
                    @foreach ($categories as $category)
                      <tr>
                          @php
                              ++$no;
                          @endphp
                        <td>{{$no}}</td>
                        <td>{{$category->name}}</td>
                        {{-- <td>@if({{$category->active}}) {{"Active"}} @else {{"Disabled"}} @endif</td> --}}
                        <td><span class="badge @if($category->active) bg-success @else bg-danger @endif">{{$category->status  }}</span></td>
                        <td>{{$category->created_at}}</td>
                        <td>{{$category->updated_at}}</td>
                        <td>
                          <div class="btn-group">
                            @can('Update-Category')
                                <a href="{{route('categories.edit', $category->id)}}" class="btn btn-info">
                                <i class="fas fa-pen"></i>
                                </a>
                            @endcan

                            @can('Delete-Category')
                                <a href="#" class="btn btn-danger" onclick="confirmDestroy({{$category->id}}, this)">
                                <i class="fas fa-trash"></i>
                                </a>
                            @endcan
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
    {{-- HERE SCRIPTS --}}
    <script>
      function confirmDestroy(id, refrance) {
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            destoy(id, refrance);
          }
        });
      }

      function destoy (id, refrance) {
        // cms/admin/categories/{category}
        axios.delete('/cms/admin/categories/' + id)
          .then(function (response) {
            // handle success
            console.log(response);
            refrance.closest('tr').remove();
            showDeletingMessage(response.data);
          })
          .catch(function (error) {
            // handle error
            console.log(error);
            showDeletingMessage(error.response.data);
          })
          .then(function () {
            // always executed
          });
      }

      function showDeletingMessage (data) {
        Swal.fire({
          icon: 'success',
          title: 'Your work has been saved',
          showConfirmButton: false,
          timer: 2000
        });
      }
    </script>
@endsection
