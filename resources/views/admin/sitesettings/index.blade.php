@extends('admin.master.master')
<!-- Content Wrapper. Contains page content -->

@section('title', 'Site Settings')

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
                        <h1 class="text-center">Site Settings</h1>
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}" style="color: #6c757d"> <i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li class="breadcrumb-item active">Site Settings</li>
                        </ol>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container">
                <form role="form" action="{{route('update.sitesettings')}}" method="post" enctype="multipart/form-data" style="width: 100%">
                    @csrf
                    <input type="hidden" name="id" value="{{$site->id}}">
                    <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-info">

                            <!-- /.card-header -->
                            <div class="card-body pad">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Site Title</label>
                                    <input type="text" class="form-control" name="site_title" value="{{$site->site_title}}"  placeholder="Enter Site Title">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Site Email</label>
                                    <input type="email" class="form-control" name="site_email"  value="{{$site->site_email}}"  placeholder="Enter Site Email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Site Phone</label>
                                    <input type="text" class="form-control" name="site_phone"  value="{{$site->site_phone}}"  placeholder="Enter Site Phone">
                                </div>

                                <div class="form-group">
                                    <label>Google Analytics</label>
                                    <textarea name="google_analytics" placeholder="Place Google Analytics"
                                              style="width: 100%; height: 50px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$site->google_analytics}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Copyright Text</label>
                                    <textarea name="copyright" placeholder="Place Copyright Text"
                                              style="width: 100%; height: 50px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$site->copyright}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Footer Text</label>
                                    <textarea name="footer_text" placeholder="Place Footer Text"
                                              style="width: 100%; height: 50px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$site->footer_text}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Facebook link</label>

                                    <input type="text" name="facebook" value="{{$site->facebook}}" class="form-control" placeholder="Facebook Link">
                                </div>
                                <div class="form-group">
                                    <label>Twitter link</label>

                                    <input type="text" name="twitter" value="{{$site->twitter}}" class="form-control" placeholder="Twitter Link">
                                </div>
                                <div class="form-group">
                                    <label>LinkedIn link</label>

                                    <input type="text" name="linkedin" value="{{$site->linkedin}}" class="form-control" placeholder="LinkedIn Link">
                                </div>
                                <div class="form-group">
                                    <label>Youtube link</label>

                                    <input type="text" name="youtube" value="{{$site->youtube}}" class="form-control" placeholder="Youtube Link">
                                </div>
                                <div class="form-group">
                                    <label>Googleplus link</label>

                                    <input type="text" name="googleplus" value="{{$site->googleplus}}" class="form-control" placeholder="Googleplus Link">
                                </div>
                                <div class="form-group">
                                    <label>Instagram link</label>

                                    <input type="text" name="instagram" value="{{$site->instagram}}" class="form-control" placeholder="Instagram Link">
                                </div>

                                <div class="form-group">
                                    <label>Header Logo Image</label>
                                    <div class="input-group mb-3">
                                        <input type="text"  class="form-control" value="{{$site->logo_image}}" name="logo_image" id="headerlogo" placeholder="Click To Choose\Upload Image">
                                        <div class="input-group-append">
                                            <button data-select2-open="single-append-text" type="button" class="btn btn-default" data-target="#fileManager0" href="javascript:;" data-toggle="modal">

                                                <i class="far fa-image"></i>

                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Footer Logo Image</label>
                                    <div class="input-group mb-3">
                                        <input type="text"  class="form-control" value="{{$site->footer_logo}}" name="footer_logo" id="footerlogo" placeholder="Click To Choose\Upload Image">
                                        <div class="input-group-append">
                                            <button data-select2-open="single-append-text" type="button" class="btn btn-default" data-target="#fileManager1" href="javascript:;" data-toggle="modal">

                                                <i class="far fa-image"></i>

                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Active Messenger</label>
                                    <select class="form-control" name="messenger" style="width: 100%;">
                                        <option value="" selected="selected">Select Status</option>
                                        <option @if($site->messenger == 1) selected @endif value="1">Yes</option>
                                        <option @if($site->messenger == 0) selected @endif value="0">No</option>

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


    <div class="modal fade mymodal" id="fileManager0">

        <div class="modal-dialog" style="max-width: 65% !important;">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="position: absolute;right: 20px;font-size: 35px;">&times;</button>

                    <h4 class="modal-title">File Manager</h4>

                </div>

                <div class="modal-body" style="padding:0px; margin:0px;">

                    <iframe width="100%" height="500" src="@filemanager_get_resource(dialog.php)?field_id=headerlogo&type=2&relative_url=1&lang=en_EN&akey=@filemanager_get_key()" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>

                </div>

            </div>

        </div>

    </div>

    <div class="modal fade mymodal" id="fileManager1">

        <div class="modal-dialog" style="max-width: 65% !important;">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="position: absolute;right: 20px;font-size: 35px;">&times;</button>

                    <h4 class="modal-title">File Manager</h4>

                </div>

                <div class="modal-body" style="padding:0px; margin:0px;">

                    <iframe width="100%" height="500" src="@filemanager_get_resource(dialog.php)?field_id=footerlogo&type=2&relative_url=1&lang=en_EN&akey=@filemanager_get_key()" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>

                </div>

            </div>

        </div>

    </div>
@endsection
