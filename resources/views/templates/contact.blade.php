{{-- * Template Name : Contact * --}}
@extends('layouts.app')

@section('content')
    <section id="page-title" class="page-title bg-overlay bg-overlay-dark bg-parallax">

        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="title title-6 text-center">
                        <div class="title--heading">
                            <h1>Contact Us</h1>
                        </div>
                        <div class="clearfix"></div>
                        <ol class="breadcrumb">
                            <li><a href="{{URL::to('/')}}">Home | </a></li>
                            <li class="active">&nbsp;Contact Us</li>
                        </ol>
                    </div><!-- .title end -->
                </div><!-- .col-md-12 end -->
            </div><!-- .row end -->
        </div><!-- .container end -->
    </section><!-- #page-title end -->

    <section id="contact1" class="contact contact-1 pb-90">
        <div class="container">
            <div class="heading heading-3 mb-50 text--center">
                <h2 class="heading--title">Get in touch</h2>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                    <div class="row">
                        <form role="form" action="{{route('submit-query')}}" method="post" enctype="multipart/form-data" style="width: 100%">
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
                                <input type="text" class="form-control"  name="name" value="{{old('name')}}" id="name" placeholder="Your Name" required="">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <input type="email" class="form-control" required name="email" value="{{old('email')}}" id="email" placeholder="Email">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <input type="text" class="form-control" required name="phone" value="{{old('phone')}}" id="Phone" placeholder="Phone">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <input type="text" class="form-control" required name="subject" value="{{old('subject')}}" id="subject" placeholder="Subject">
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <textarea class="form-control" name="message" id="message" rows="2" placeholder="Request Details:" required style="height: 200px;">{{old('message')}}</textarea>
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
        </div><!-- .container end -->
    </section>


@endsection





