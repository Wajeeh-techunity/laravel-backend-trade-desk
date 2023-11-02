@extends('admin.master.master')
<!-- Content Wrapper. Contains page content -->

@section('title', 'Update User')

@section('head')
    <style>
        .marginleft30{
            margin-left: 30px !important;
        }
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
                        <h1 class="text-center">Update User</h1>
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}" style="color: #6c757d"> <i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
                        </ol>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form role="form" action="{{route('update.user')}}" method="post" enctype="multipart/form-data" style="width: 100%">
                    @csrf
                    <input type="hidden" name="id" value="{{$user->id}}">
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
                                                    <option @if($user->role_id == $role->id) selected @endif value="{{$role->id}}">{{$role->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Name</label>
                                            <input type="text" class="form-control" name="name" value="{{$user->name??''}}" required placeholder="Enter User Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email</label>
                                            <input type="email" name="email" required class="form-control" value="{{$user->email??''}}" placeholder="Email">
                                        </div>

                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status" required style="width: 100%;">
                                                <option value="">Select Status</option>
                                                <option @if($user->status == 1) selected @endif value="1">Active</option>
                                                <option @if($user->status == 0) selected @endif value="0">In Active</option>

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
                                                @php
                                                    $user_permissions = [];
                                                    if(isset($user->permissions))
                                                    {
                                                         $user_permissions = json_decode($user->permissions);
                                                    }

                                                @endphp
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
                                                                        <input type="checkbox" name="permissions[]" @if(in_array($value, $user_permissions)) checked @endif  value="{{$value}}" class="check-permission" >
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
        $(document).ready(function (e) {
            $('.outer-li').each(function () {

                var checked = $(this).find('.check-permission:checked').length;
                var total = $(this).find('.check-permission').length;

                if(checked != 0 && checked == total)
                {
                    $(this).find('.group-permission').prop('checked',true);
                }
            })
        })
    </script>
@endsection
