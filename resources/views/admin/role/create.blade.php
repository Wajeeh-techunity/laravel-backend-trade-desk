@extends('admin.master.master')
<!-- Content Wrapper. Contains page content -->

@section('title', 'Create Role')

@section('head')

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="text-center">Create New Role</h1>
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}" style="color: #6c757d"> <i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li class="breadcrumb-item active">Create Role</li>
                        </ol>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form role="form" action="{{route('insert.role')}}" method="post" enctype="multipart/form-data" style="width: 100%">
                    @csrf
                    <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-info">

                            <!-- /.card-header -->
                            <div class="card-body pad">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" class="form-control" name="name" required placeholder="Enter Role Name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Slug</label>
                                    <input type="text" class="form-control" name="slug" required placeholder="Enter Role Slug">
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status" required style="width: 100%;">
                                        <option value=""  selected="selected">Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">In Active</option>

                                    </select>
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
