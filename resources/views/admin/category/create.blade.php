@extends('admin.layouts.default') 

@section('title')
New Category
@endsection


@section('content')

        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">New Category</h3></div>

              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                  <li class="breadcrumb-item active" aria-current="page">New Category</li>
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
              
               <div class="card card-warning card-outline mb-4">
                  <!--begin::Header-->
                  <div class="card-header"><div class="card-title">New Category</div></div>
                  <!--end::Header-->
                  <!--begin::Form-->
                  
                  
                  <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    <!--begin::Body-->
                    <div class="card-body">

                      <div class="row mb-3">
                        <label for="title" class="col-sm-2 col-form-label required">Category name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="meta_desc" class="col-sm-2 col-form-label">Meta description</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="meta_desc" name="meta_desc" value="{{ old('meta_desc') }}">
                        </div>
                      </div>
      
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-warning">Create</button>
                    </div>
                    <!--end::Footer-->
                  </form>
                  <!--end::Form-->


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

      