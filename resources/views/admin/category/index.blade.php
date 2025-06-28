@extends('admin.layouts.default') 

@section('title')
Categories list
@endsection


@section('content')

        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Categories</h3></div>

              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Categories</li>
                </ol>
              </div>
              
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              
                <div class="card mb-4">
                  <div class="card-header"><a href="{{ route('admin.categories.create') }}" class="btn btn-primary"> Add category </a></div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th style="width: 10px">ID</th>
                          <th>Title</th>
                          <th style="width: 150px">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($categories as $category) 
                        <tr class="align-middle">
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->title }}</td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('admin.categories.edit', ['category' => $category->id]) }}" class="btn btn-primary"> <i class="bi bi-pencil"> </i> </a>
                                <form action="{{ route('admin.categories.destroy', ['category' => $category->id]) }}" method="POST">
                                  @csrf
                                  @method('DELETE')
                                  <button class="btn btn-danger" onclick="return confirm('Are you sure?')"> <i class="bi bi-trash"> </i> </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach 
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer clearfix">
                    {{ $categories->links() }}
                    <!-- <ul class="pagination pagination-sm m-0 float-end">
                      <li class="page-item"><a class="page-link" href="#">«</a></li>
                      <li class="page-item"><a class="page-link" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item"><a class="page-link" href="#">»</a></li>
                    </ul> -->
                  </div>
                </div>

            </div>
            <!--end::Row-->
            <!--begin::Row-->
            
            <!-- /.row (main row) -->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
@endsection

      