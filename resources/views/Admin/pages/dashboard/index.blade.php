@extends('admin.layouts.master')
@section('title') Dashboard @endsection
@section('page-title') Dashboard @endsection
@section('css')
    <!-- <link href="{{ URL::asset('/assets/admin/pages/vehicle/style.css') }}" rel="stylesheet" type="text/css" /> -->
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Dashboards @endslot
        @slot('title') Saas @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="media">
                                <div class="me-3">
                                    <img src="{{ URL::asset('/assets/images/users/avatar-1.jpg') }}" alt=""
                                        class="avatar-md rounded-circle img-thumbnail">
                                </div>
                                <div class="media-body align-self-center">
                                    <div class="text-muted">
                                        <p class="mb-2">Welcome to Dashboard</p>
                                        <h5 class="mb-1">ZRich Media</h5>
                                        <p class="mb-0">Marketing / CEO</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 align-self-center">
                            <div class="text-lg-center mt-4 mt-lg-0">
                                <div class="row">
                                    <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">Total Projects</p>
                                            <h5 class="mb-0">48</h5>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">Projects</p>
                                            <h5 class="mb-0">40</h5>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">Clients</p>
                                            <h5 class="mb-0">18</h5>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 d-none d-lg-block">
                            <div class="clearfix mt-4 mt-lg-0">
                                <div class="dropdown float-end">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bxs-cog align-middle me-1"></i> Setting
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-xl-4">
            <div class="card bg-primary bg-soft">
                <div>
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">Welcome Back !</h5>
                                <p>ZRich Dashboard</p>

                                <ul class="ps-3 mb-0">
                                    <li class="py-1">Google AD</li>
                                    <li class="py-1">FaceBook AD</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="{{ URL::asset('/assets/images/profile-img.png') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                        <i class="bx bx-copy-alt"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-14 mb-0">Orders</h5>
                            </div>
                            <div class="text-muted mt-4">
                                <h4>1,452 <i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>
                                <div class="d-flex">
                                    <span class="badge badge-soft-success font-size-12"> + 0.2% </span> <span
                                        class="ms-2 text-truncate">From previous period</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                        <i class="bx bx-archive-in"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-14 mb-0">Revenue</h5>
                            </div>
                            <div class="text-muted mt-4">
                                <h4>$ 28,452 <i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>
                                <div class="d-flex">
                                    <span class="badge badge-soft-success font-size-12"> + 0.2% </span> <span
                                        class="ms-2 text-truncate">From previous period</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                        <i class="bx bx-purchase-tag-alt"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-14 mb-0">Average Price</h5>
                            </div>
                            <div class="text-muted mt-4">
                                <h4>$ 16.2 <i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>

                                <div class="d-flex">
                                    <span class="badge badge-soft-warning font-size-12"> 0% </span> <span
                                        class="ms-2 text-truncate">From previous period</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-end">
                            <div class="input-group input-group-sm">
                                <select class="form-select form-select-sm">
                                    <option value="JA" selected>Jan</option>
                                    <option value="DE">Dec</option>
                                    <option value="NO">Nov</option>
                                    <option value="OC">Oct</option>
                                </select>
                                <label class="input-group-text">Month</label>
                            </div>
                        </div>
                        <h4 class="card-title mb-4">Earning</h4>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="text-muted">
                                <div class="mb-4">
                                    <p>This month</p>
                                    <h4>$2453.35</h4>
                                    <div><span class="badge badge-soft-success font-size-12 me-1"> + 0.2% </span> From
                                        previous period</div>
                                </div>

                                <div>
                                    <a href="#" class="btn btn-primary waves-effect waves-light btn-sm">View Details <i
                                            class="mdi mdi-chevron-right ms-1"></i></a>
                                </div>

                                <div class="mt-4">
                                    <p class="mb-2">Last month</p>
                                    <h5>$2281.04</h5>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div id="line-chart" class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Sales Analytics</h4>

                    <div>
                        <div id="donut-chart" class="apex-charts"></div>
                    </div>

                    <div class="text-center text-muted">
                        <div class="row">
                            <div class="col-4">
                                <div class="mt-4">
                                    <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-primary me-1"></i> Product A
                                    </p>
                                    <h5>$ 2,132</h5>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mt-4">
                                    <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-success me-1"></i> Product B
                                    </p>
                                    <h5>$ 1,763</h5>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mt-4">
                                    <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-danger me-1"></i> Product C
                                    </p>
                                    <h5>$ 973</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-end">
                            <div class="input-group input-group-sm">
                                <select class="form-select form-select-sm">
                                    <option value="JA" selected>Jan</option>
                                    <option value="DE">Dec</option>
                                    <option value="NO">Nov</option>
                                    <option value="OC">Oct</option>
                                </select>
                                <label class="input-group-text">Month</label>
                            </div>
                        </div>
                        <h4 class="card-title mb-4">Top Selling product</h4>
                    </div>

                    <div class="text-muted text-center">
                        <p class="mb-2">Product A</p>
                        <h4>$ 6385</h4>
                        <p class="mt-4 mb-0"><span class="badge badge-soft-success font-size-11 me-2"> 0.6% <i
                                    class="mdi mdi-arrow-up"></i> </span> From previous period</p>
                    </div>

                    <div class="table-responsive mt-4">
                        <table class="table align-middle mb-0">
                            <tbody>
                                <tr>
                                    <td>
                                        <h5 class="font-size-14 mb-1">Product A</h5>
                                        <p class="text-muted mb-0">Neque quis est</p>
                                    </td>

                                    <td>
                                        <div id="radialchart-1" class="apex-charts"></div>
                                    </td>
                                    <td>
                                        <p class="text-muted mb-1">Sales</p>
                                        <h5 class="mb-0">37 %</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 class="font-size-14 mb-1">Product B</h5>
                                        <p class="text-muted mb-0">Quis autem iure</p>
                                    </td>

                                    <td>
                                        <div id="radialchart-2" class="apex-charts"></div>
                                    </td>
                                    <td>
                                        <p class="text-muted mb-1">Sales</p>
                                        <h5 class="mb-0">72 %</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 class="font-size-14 mb-1">Product C</h5>
                                        <p class="text-muted mb-0">Sed aliquam mauris.</p>
                                    </td>

                                    <td>
                                        <div id="radialchart-3" class="apex-charts"></div>
                                    </td>
                                    <td>
                                        <p class="text-muted mb-1">Sales</p>
                                        <h5 class="mb-0">54 %</h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-start">
                        <h5 class="card-title me-2">Visitors</h5>
                        <div class="ms-auto">
                            <div class="toolbar button-items text-end">
                                <button type="button" class="btn btn-light btn-sm">
                                    ALL
                                </button>
                                <button type="button" class="btn btn-light btn-sm">
                                    1M
                                </button>
                                <button type="button" class="btn btn-light btn-sm">
                                    6M
                                </button>
                                <button type="button" class="btn btn-light btn-sm active">
                                    1Y
                                </button>

                            </div>
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-lg-4">
                            <div class="mt-4">
                                <p class="text-muted mb-1">Today</p>
                                <h5>1024</h5>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mt-4">
                                <p class="text-muted mb-1">This Month</p>
                                <h5>12356 <span class="text-success font-size-13">0.2 % <i
                                            class="mdi mdi-arrow-up ms-1"></i></span></h5>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mt-4">
                                <p class="text-muted mb-1">This Year</p>
                                <h5>102354 <span class="text-success font-size-13">0.1 % <i
                                            class="mdi mdi-arrow-up ms-1"></i></span></h5>
                            </div>
                        </div>
                    </div>

                    <hr class="mb-4">

                    <div class="apex-charts" id="area-chart" dir="ltr"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Saas dashboard init -->
    <script src="{{ URL::asset('/assets/js/pages/saas-dashboard.init.js') }}"></script>
@endsection