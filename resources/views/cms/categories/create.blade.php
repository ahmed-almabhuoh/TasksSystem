@extends('cms.parent')

@section('title', 'Create Category')

@section('styles')
    {{-- Styles --}}
@endsection

@section('capital-starter-page', 'Create Category')
@section('home-starter-page', 'Home')
@section('small-starter-page', 'categories')

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
                            <h3 class="card-title">Create Category</h3>
                        </div>

                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="reset-form" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter name">
                                </div>
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control" id="image">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="active">
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
        // function store() {
        //     // cms/admin/categories
        //     axios.post('/cms/admin/categories', {
        //             name: document.getElementById('name').value,
        //             image: document.getElementById('image').image,
        //             status: document.getElementById('active').checked,
        //         })
        //         .then(function(response) {
        //             // handle success
        //             console.log(response);
        //             toastr.success(response.data.message);
        //             // document.getElementById('set-form').reset();
        //             document.getElementById('reset-form').reset();
        //         })
        //         .catch(function(error) {
        //             // handle error
        //             console.log(error);
        //             toastr.error(error.response.data.message)
        //         })
        //         .then(function() {
        //             // always executed
        //         });
        // }
        function store() {

            // THIS IS THE FORM DATA NOT A URL INCODED
            let formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('status', document.getElementById('active').checked ? 1 : 0);
            formData.append('image', document.getElementById('image').files[0]);

            axios.post('/cms/admin/categories', formData)
                .then(function(response) {
                    // handle success
                    console.log(response);
                    toastr.success(response.data.message);
                    // document.getElementById('set-form').reset();
                    document.getElementById('reset-form').reset();
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    toastr.error(error.response.data.message)
                })
                .then(function() {
                    // always executed
                });
        }
    </script>
@endsection

@section('company-name', 'your-company-name')

@section('version', 'System-version')
