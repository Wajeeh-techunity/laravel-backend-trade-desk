@extends('admin.master.master')
<!-- Content Wrapper. Contains page content -->

@section('title', 'Menus')

@section('head')


    <style>

        .delete_menu,
        .edit_menu{
            float: right;
            width: 30px;
            text-align: center;
            cursor: pointer;
        }

        .dd-action{
            position: absolute;
            top: 5px;
            right: 0;
        }

        .marginBtm5{
            margin-bottom: 5px !important;
        }

        .add-new-menu{
            border-right: 1px solid #33333361; padding: 0px 40px
        }

        /**
         * Nestable
         */

        .dd {display: block;
            margin: 0;
            padding: 0;
            width: 50%;
            margin-left: 20px;
            list-style: none;
            font-size: 13px;
            line-height: 20px;
        }

        .dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
        .dd-list .dd-list { padding-left: 30px; }
        .dd-collapsed .dd-list { display: none; }

        .dd-item,
        .dd-empty,
        .dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }

        .dd-handle { display: block; height: 30px; margin: 10px 0; cursor: move; padding: 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
            background: #fafafa;
            background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
            background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
            background:         linear-gradient(top, #fafafa 0%, #eee 100%);
            -webkit-border-radius: 3px;
            border-radius: 3px;
            box-sizing: border-box; -moz-box-sizing: border-box;
        }
        .dd-handle:hover { color: #2ea8e5; background: #fff; }

        .dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
        .dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
        .dd-item > button[data-action="collapse"]:before { content: '-'; }

        .dd-placeholder,
        .dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
        .dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
            background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
            -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
            -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
            linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-size: 60px 60px;
            background-position: 0 0, 30px 30px;
        }

        .dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
        .dd-dragel > .dd-item .dd-handle { margin-top: 0; }
        .dd-dragel .dd-handle {
            -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
            box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
        }

        /**
         * Nestable Extras
         */

        .nestable-lists { display: block; clear: both; padding: 30px 0; width: 100%; border: 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; }

        #nestable-menu { padding: 0; margin: 20px 0; }

        #nestable-output,
        #nestable2-output { width: 100%; height: 7em; font-size: 0.75em; line-height: 1.333333em; font-family: Consolas, monospace; padding: 5px; box-sizing: border-box; -moz-box-sizing: border-box; }

        #nestable2 .dd-handle {
            color: #fff;
            border: 1px solid #999;
            background: #bbb;
            background: -webkit-linear-gradient(top, #bbb 0%, #999 100%);
            background:    -moz-linear-gradient(top, #bbb 0%, #999 100%);
            background:         linear-gradient(top, #bbb 0%, #999 100%);
        }
        #nestable2 .dd-handle:hover { background: #bbb; }
        #nestable2 .dd-item > button:before { color: #fff; }


        .dd-hover > .dd-handle { background: #2ea8e5 !important; }

        /**
         * Nestable Draggable Handles
         */
    </style>
@endsection



@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="text-center">Manage Menu</h1>
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}" style="color: #6c757d"> <i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li class="breadcrumb-item active">Menu</li>
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
                            {{--<div class="card-header">--}}
                                {{--<a href="{{route('create.menu')}}" class="btn btn-success"><i class="fas fa-plus-square"> Add New Menu</i></a>--}}

                                {{--<button class="btn btn-danger" id="delete" style="margin-left:10px"><i class="fas fa-trash"> </i> Delete Selected</button>--}}
                            {{--</div>--}}


                            <!-- /.card-header -->
                            <div class="card-body">

                                <div id="menubar" class="row">
                                    <div class="col-md-3 add-new-menu" >
                                        <form type="GET" action="{{route('menus')}}" >
                                            <div class="form-group marginBtm5">
                                                <label>Menu Type</label>
                                                <select class="form-control" id="menu_type" name="menu_type" required style="width: 100%;">
                                                    <option @if($menu_type == 'header') selected="selected" @endif value="header">Header</option>
                                                    <option @if($menu_type == 'footer') selected="selected" @endif value="footer">Footer</option>

                                                </select>
                                            </div>
                                        </form>

                                        <hr>
                                        <form role="form" action="{{route('insert.menu')}}" id="menu-form" method="post" enctype="multipart/form-data" style="width: 100%">
                                            @csrf
                                            <input type="hidden" name="menu_location" value="{{$menu_type}}">
                                        <div class="form-group marginBtm5">
                                            <label for="exampleInputEmail1">Name</label>
                                            <input type="text" class="form-control" name="name" id="name" required placeholder="Enter Menu Name">
                                        </div>
                                        {{--<div class="form-group">--}}
                                            {{--<label>Parent</label>--}}
                                            {{--<select class="form-control" name="parent_id" style="width: 100%;">--}}
                                                {{--<option value=""  selected="selected">Select Parent</option>--}}
                                                {{--@foreach($parent_menus as $menu)--}}
                                                    {{--<option value="{{$menu->id}}">{{$menu->name}}</option>--}}
                                                {{--@endforeach--}}

                                            {{--</select>--}}
                                        {{--</div>--}}
                                        <div class="form-group marginBtm5">
                                            <label>Page</label>
                                            <select class="form-control" name="page_id" id="page_id" style="width: 100%;">
                                                <option value=""  selected="selected">Select Page</option>
                                                @foreach($pages as $page)
                                                    <option value="{{$page->id}}">{{$page->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group marginBtm5">
                                            <label for="exampleInputPassword1">Other URL</label>
                                            <input type="text" class="form-control" name="other_url" id="other_url" placeholder="Enter Other URL">
                                        </div>

                                        <div class="form-group mbtm30">
                                            <label>Status</label>
                                            <select class="form-control" name="status" id="status" required style="width: 100%;">
                                                <option value=""  selected="selected">Select Status</option>
                                                <option value="1">Active</option>
                                                <option value="0">In Active</option>

                                            </select>
                                        </div>
                                        <div class="row mbtm30">
                                            <div class="col-md-12 text-right">
                                                <button class="btn btn-success">Submit</button>
                                            </div>
                                        </div>

                                        </form>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <h2 class="text-center">you can drag each menu to sort menu position </h2>
                                            </div>
                                            <div class="col-md-2 text-right">
                                                <button class="btn btn-small btn-success" id="save-menu-settings">Save</button>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="dd" id="nestable">
                                            <ol class="dd-list">
                                                @foreach($menus as $menu)
                                                    <li class="dd-item" data-id="{{$menu->id}}">
                                                        <div class="dd-handle">{{$menu->name}}</div>
                                                        <div class="dd-action"><span class="delete_menu" data-id="{{$menu->id}}"><i class="fas fa-times"></i></span><span class="edit_menu" data-data="{{$menu}}"><i class="fas fa-edit"></i></span></div>
                                                        @if($menu->findChildMenus->count() > 0)
                                                            <ol class="dd-list">
                                                                @foreach($menu->findChildMenus as $child)
                                                                    <li class="dd-item" data-id="{{$child->id}}">
                                                                        <div class="dd-handle">{{$child->name}}</div>
                                                                        <div class="dd-action"><span class="delete_menu" data-id="{{$child->id}}"><i class="fas fa-times"></i></span><span class="edit_menu" data-data="{{$child}}"><i class="fas fa-edit"></i></span></div>
                                                                        @if($child->findChildMenus->count() > 0)
                                                                            <ol class="dd-list">
                                                                                @foreach($child->findChildMenus as $child1)
                                                                                    <li class="dd-item" data-id="{{$child1->id}}">
                                                                                        <div class="dd-handle">{{$child1->name}}</div>
                                                                                        <div class="dd-action"><span class="delete_menu" data-id="{{$child1->id}}"><i class="fas fa-times"></i></span><span class="edit_menu" data-data="{{$child1}}"><i class="fas fa-edit"></i></span></div>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ol>
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ol>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ol>
                                        </div>

                                        <input id="nestable-output" type="hidden" />
                                    </div>

                                </div>

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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{asset('admin/js/jquery.nestable.js')}}"></script>

    <script>

        $( function() {
            $( "#sortable" ).sortable();
            $( ".inner-sortable" ).sortable();
            $( "#sortable" ).disableSelection();
            $( ".inner-sortable" ).disableSelection();
        } );

        $(document).on('click','.delete_menu', function(e){

            var ids = [];
            ids.push($(this).attr('data-id'));
            removeByIds(ids,'{{route('delete.menu')}}');
        })

        $(document).on('click','.edit_menu', function(e){

            var data = $(this).data('data');
            console.log(data);

            $('#menu-form').attr('action','{{route('update.menu')}}');
            $('#menu-form').find('#id').remove();
            $('#menu-form').append('<input type="hidden" name="id" id="id" value="'+data.id+'">');

            $('#name').val(data.name);
            $('#page_id').val(data.page_id);
            $('#other_url').val(data.other_url);
            $('#status').val(data.status);

        })

        $(document).ready(function()
        {

            var updateOutput = function(e)
            {
                var list   = e.length ? e : $(e.target),
                        output = list.data('output');
                if (window.JSON) {
                    output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
                } else {
                    output.val('JSON browser support required for this demo.');
                }
            };

            // activate Nestable for list 1
            $('#nestable').nestable({
                group: 1
            })
                    .on('change', updateOutput);

            // output initial serialised data
            updateOutput($('#nestable').data('output', $('#nestable-output')));

            $('#nestable-menu').on('click', function(e)
            {
                var target = $(e.target),
                        action = target.data('action');
                if (action === 'expand-all') {
                    $('.dd').nestable('expandAll');
                }
                if (action === 'collapse-all') {
                    $('.dd').nestable('collapseAll');
                }
            });

            $('#nestable3').nestable();

        });

        $(document).on('click','#save-menu-settings',function (e) {
            var json = $.parseJSON($('#nestable-output').val());

            var data = {
                positions:json
            }
            $.ajax({
                type: 'post',
                url: '{{route('update.menu.position')}}',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },
                success: function (response) {

                    if (response) {

                        location.reload();
                    }
                },

            });

        })


        $(document).on('change','#menu_type',function (e) {
            $(this).parents('form').submit();
        })
    </script>
@endsection