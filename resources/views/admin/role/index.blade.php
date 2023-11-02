@extends('admin.master.master')
<!-- Content Wrapper. Contains page content -->

@section('title', 'Roles')

@section('head')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('admin/adminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/adminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection



@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="text-center">Manage Roles</h1>
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}" style="color: #6c757d"> <i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li class="breadcrumb-item active">Roles</li>
                        </ol>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{route('create.role')}}" class="btn btn-success"><i class="fas fa-plus-square"> Add New Role</i></a>

                                <button class="btn btn-danger" id="delete" style="margin-left:10px"><i class="fas fa-trash"> </i> Delete Selected</button>
                            </div>


                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered ">
                                    <thead>
                                    <tr>
                                        <th style="width: 1px;" class="text-center ">
                                             <input type="checkbox" id="allChk" />
                                        </th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                   @foreach($roles as $role)
                                        <tr>
                                            <td class="text-center singleCheck">
                                                <input type="checkbox" name="selected" class="singleChk"  value="{{$role->id}}" />
                                            </td>
                                            <td>{{$role->name}}</td>
                                            <td>{{$role->slug}}</td>
                                            <td>@if($role->status == 1) <span class="badge badge-success"> Active </span>@else  <span class="badge badge-danger"> In Active </span> @endif</td>
                                            <td>{{$role->created_at}}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{route('edit.role', ['id' => $role->id])}}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                    <button class="btn btn-danger delete_role" data-id="{{$role->id}}"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                   @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')


    <!-- DataTables -->
    <script src="{{asset('admin/adminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin/adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('admin/adminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('admin/adminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
                "columnDefs": [
                    { orderable: false, targets: 0 }
                ]
            });

        })



        $(document).on('click','.delete_role', function(e){

            var ids = [];
            ids.push($(this).attr('data-id'));
            removeByIds(ids,'{{route('delete.role')}}');
        })


        $(document).on('click','#delete', function(e){

            var ids = [];

            $('#example1 tbody').find('.singleChk').each(function(e){
                if ($(this).prop('checked')==true){
                    ids.push($(this).val());
                }
            })

            if(ids == '' || ids == 'undefiend')
            {
                alert('select any row or rows to delete');
            }
            removeByIds(ids,'{{route('delete.role')}}');
        })
    </script>
@endsection