{{-- * Template Name : Sign-Up * --}}
@extends('layouts.app')

@section('content')

    <section id="page-title" class="page-title bg-overlay bg-overlay-dark bg-parallax">

        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="title title-6 text-center">
                        <div class="title--heading">
                            <h1>Sign Up</h1>
                        </div>
                        <div class="clearfix"></div>
                        <ol class="breadcrumb">
                            <li><a href="{{URL::to('/')}}">Home | </a></li>
                            <li class="active">&nbsp; Sign Up</li>
                        </ol>
                    </div><!-- .title end -->
                </div><!-- .col-md-12 end -->
            </div><!-- .row end -->
        </div><!-- .container end -->
    </section><!-- #page-title end -->


    <!-- Blog Grid
    ======================================= -->
    <section id="blog" class="container pt-90 pb-60">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                <div class="row">
                    <form role="form" action="{{route('signup')}}" method="post" enctype="multipart/form-data" style="width: 100%">
                        @csrf
                        @if ($errors->any())
                            <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            </div>
                        @endif
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <input type="text" class="form-control"  name="name" id="name" placeholder="Your Name" value="{{old('name')}}" required="">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <input type="email" class="form-control" required name="email" id="email" value="{{old('email')}}" placeholder="Email">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <input type="password" class="form-control" required name="password" id="password"  placeholder="Password">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <input type="password" class="form-control" required name="password_confirmation" id="c-password" placeholder="Confirm Password">
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}" style="margin-top: 20px;">

                            {!! app('captcha')->display() !!}
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                            @endif

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <button type="submit" class="btn btn-primary btn-block"> Submit Request </button>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="contact-result" style="padding-top: 20px; ">
                                @if(session()->has('success-mesg'))
                                    <div class="alert alert-success">{{session()->get('success-mesg')}} </div>
                                @endif
                            </div>
                        </div>
                    </form>
                    <!-- form end -->
                </div>
            </div>
        </div><!-- .row end -->
    </section>
@endsection
