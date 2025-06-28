@extends('admin.layouts.default') 

@section('title')
Trash
@endsection


@section('content')

        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Trash</h3></div>

              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.posts.index') }}">Posts</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Trash</li>
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
                 
                  
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th style="width: 10px">ID</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Deleted at</th>
                          <th style="width: 150px">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($posts as $post) 
                        <tr class="align-middle">
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->category->title }}</td>
                            <td>{{ $post->deleted_at }}</td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('admin.posts.trash.restore', ['post' => $post->id]) }}" class="btn btn-warning"> <i class="bi bi-arrow-counterclockwise"> </i> </a>
                                <form action="{{ route('admin.posts.trash.remove', ['post' => $post->id]) }}" method="POST">
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
                    {{ $posts->links() }}
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

      