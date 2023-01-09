@extends('admin.layouts.master')

@section('title') Google ads @endsection
@section('css')

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') list @endslot
        @slot('title') Google Ads Hyros Management @endslot
    @endcomponent
    <div class="content-wrapper">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-filter mb-3">
                        <a href="javsciript::void(0)" class="btn btn-outline-primary waves-effect waves-light add-new" data-bs-toggle="modal"
                                                data-bs-target="#addModal"><i class="fas fa-plus"></i> Add</a>
                    </div>
                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100 datatable">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Store Name</th>
                                <th class="text-center">Account Id</th>
                                <th class="text-center">Email</th>           
                                <th class="text-center">API key</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $key=>$row)
                            <tr>
                                <td class="text-center">{{$key+1}}</td>
                                <td>{{$row->name}}</td>
                                <td class="text-center">{{$row->account_id}}</td>
                                <td class="text-center">{{$row->email}}</td>
                                <td class="text-center">{{$row->api_key}}</td>
                                <td>
                                    <div class="form-check form-switch form-switch-lg text-center">
                                        <input class="form-check-input price-status" type="checkbox" {{$row->status == 1 ? "checked" :""}} value="{{$row->id}}" >
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="javsciript::void(0)" class="btn btn-outline-primary btn-sm waves-effect waves-lightt ms-1 update_data" data-bs-toggle="modal"
                                                data-bs-target="#updateModal" data-id="{{$row->id}}"><i class="fas fa-pencil-alt"></i> Edit</button>
                                    <a href="javsciript::void(0)" class="btn btn-outline-danger btn-sm waves-effect waves-lightt ms-1 confirm_delete" data-id="{{$row->id}}" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal"><i class="mdi mdi-delete"></i> Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>   

    <!-- create modal -->
    @include('admin.pages.google_ads.add')
    <!-- update modal -->
    @include('admin.pages.google_ads.edit')
    <!-- delete modal -->
    @include('admin.pages.google_ads.delete')

@endsection
@section('script')
    <script src="{{ URL::asset('/assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/admin/pages/google-hyros/index.js') }}"></script>
    <script>
        store_url = "{{route('admin.google-hyros.store')}}"
        list_url = "{{route('admin.google-hyros.index')}}"
        status_change = "{{route('admin.google-hyros.status')}}"
        edit_url = "{{route('admin.google-hyros.edit')}}"
        update_url = "{{route('admin.google-hyros.update')}}"
        delete_url = "{{route('admin.google-hyros.delete')}}"
    </script>
@endsection