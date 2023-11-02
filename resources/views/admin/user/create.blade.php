@extends('admin.master.master')
<!-- Content Wrapper. Contains page content -->

@section('title', 'Create User')

@section('head')
    <style>

        .select2-container--default .select2-selection--single{
            height: 40px !important;
        }
    </style>

    <link rel="stylesheet" href="{{asset('admin/adminLTE/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/adminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="text-center">Create New User</h1>
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}" style="color: #6c757d"> <i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li class="breadcrumb-item active">Create User</li>
                        </ol>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form role="form" action="{{route('insert.user')}}" method="post" enctype="multipart/form-data" style="width: 100%">
                    @csrf
                    <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-info">

                            <!-- /.card-header -->
                            <div class="card-body pad">

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control select2" required name="role_id" style="width: 100%;">
                                        <option value="" selected="selected">Select Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" class="form-control" name="name" required placeholder="Enter User Name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" name="email" required class="form-control" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Password</label>
                                    <input type="password" name="password" required class="form-control " placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status" required style="width: 100%;">
                                        <option value=""  selected="selected">Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">In Active</option>

                                    </select>
                                </div>

                                    <div class="form-group" id="permissions">
                                        <hr>
                                        <h2>Permissions</h2>
                                        <hr>


                                        <ul class="outer-ul">
                                            <li>
                                                <div class="icheck-primary ">
                                                    <input type="checkbox" id="check-all-permissions" >
                                                    <label for="checkboxPrimary1"> check all </label>
                                                </div>
                                            </li>
                                            @foreach($groupadminRoutes as $key => $route)
                                                <li class="outer-li">
                                                    <div class="icheck-primary marginleft30">
                                                        <input type="checkbox" class="group-permission" >
                                                        <label for="checkboxPrimary1"> {{$key}} </label>
                                                    </div>
                                                    <ul class="inner-ul">
                                                        @foreach($route as $value)
                                                            <li>
                                                                <div class="icheck-primary marginleft30">
                                                                    <input type="checkbox" name="permissions[]" value="{{$value}}" class="check-permission" >
                                                                    <label for="checkboxPrimary1"> {{$value}} </label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>

                                            @endforeach
                                        </ul>

                                    </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row mbtm30">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-success" style="width: 250px;">Submit</button>
                        </div>
                    </div>
                </form>

                <!-- /.col-->

            </div>
            <!-- ./row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

@section('js')
    <script src="{{asset('admin/adminLTE/plugins/select2/js/select2.full.min.js')}}"></script>

    <script>
        $(function () {

            //Initialize Select2 Elements
            $('.select2').select2()
        })
    </script>
@endsection