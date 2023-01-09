@extends('admin.layouts.master')

@section('title') airline @endsection
@section('css')

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') list @endslot
        @slot('title') Shipify Management @endslot
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
                                <th class="text-center">Store Url</th>           
                                <th class="text-center">Access Token</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $key=>$row)
                            <tr>
                                <td class="text-center">{{$key+1}}</td>
                                <td>{{$row->name}}</td>
                                <td class="text-center">{{$row->url}}</td>
                                <td class="text-center">{{$row->access_token}}</td>
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
<div id="addModal" class="modal fade" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="addModalLabel">Add Shopify</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form class="custom-validation" action="" id="add-modal">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Store Name</label>
                                <div>
                                    <input type="text" class="form-control" name="store_name" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Store Url</label>
                                <div>
                                    <input type="text" class="form-control" name="store_url" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Access Token</label>
                                <div>
                                    <input type="text" class="form-control" name="access_token" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light add_button">Save</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal --> 
<!-- update modal -->
<div id="updateModal" class="modal fade" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="updateModalLabel">Update Shopify</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form class="custom-validation" action="" id="update-modal">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <input type="hidden" class="form-control update-id" name="id" value="" required />
                                <label class="form-label">Store Name</label>
                                <div>
                                    <input type="text" class="form-control store-name" name="store_name" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Store Url</label>
                                <div>
                                    <input type="text" class="form-control store-url" name="store_url" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Access Token</label>
                                <div>
                                    <input type="text" class="form-control access-token" name="access_token" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light add_button">Save</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal --> 
<!-- delete modal -->
<div id="deleteModal" class="modal fade" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="deleteModalLabel">Are you sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete these records? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect"
                    data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect waves-light delete_button">Delete</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/admin/pages/shopify/index.js') }}"></script>
    <script>
        store_url = "{{route('admin.shopify.store')}}"
        list_url = "{{route('admin.shopify.index')}}"
        status_change = "{{route('admin.shopify.status')}}"
        edit_url = "{{route('admin.shopify.edit')}}"
        update_url = "{{route('admin.shopify.update')}}"
        delete_url = "{{route('admin.shopify.delete')}}"
    </script>
@endsection