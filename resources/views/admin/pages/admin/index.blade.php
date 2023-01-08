@extends('admin.layouts.master')

@section('title') admin @endsection
@section('css')
<link rel="stylesheet" href="{{ URL::asset('/assets/admin/pages/admin/style.css')}}" rel="stylesheet" type="text/css" >
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Admin Profile @endslot
        @slot('title') Dashboard @endslot
    @endcomponent
    <div class="content-wrapper">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <form class="custom-validation" action="" id="custom-form">
                        @csrf
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="picture-container">
                                    <div class="picture">
                                        <img src="{{ isset($user->avatar) ? asset('/uploads/avatar').'/'.($user->id).'/'.($user->avatar):asset('/images/admin/user-profile.jpg') }}" class="picture-src" id="wizardPicturePreview" title="">
                                        <input type="file" id="wizard-picture" name="file" class="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">NAME</label>
                                            <input type="text" class="form-control" name="name" value="{{$user->name}}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" name="email" value="{{$user->email}}" required>
                                        </div>
                                        
                                    </div>  
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Phone</label>
                                            <input type="text" class="form-control" name="phone" value="{{$user->phone}}">
                                        </div>
                                    </div> 
                                    <div class="mb-3 text-end">
                                        <button type="submite" class="btn btn-primary">Save</button>
                                    </div>
                                </div> 
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/admin/pages/admin/index.js') }}"></script>
    <script>
        store = "{{route('admin.store.profile')}}"
    </script>
@endsection
