{{-- * Template Name : TEsting * --}}
@extends('layouts.site.master')

@section('page-title')
    {!! isset($pageContent->meta_title) ? $pageContent->meta_title : 'Noble Folks' !!}
@stop

@section('meta-keywords')
    {!! isset($pageContent->meta_keywords) ? $pageContent->meta_keywords : 'Noble Folks' !!}
@stop

@section('meta-description')
    {!! isset($pageContent->meta_description) ? $pageContent->meta_description : 'Noble Folks' !!}
@stop
@section('content')
<style>
.signup-box .form-group .form-control { height: 40px!important; margin: 8px 0px!important; font-size: 11px!important; }
</style>
<section id="main-banner" class="no-margin">
      <div class="contnet-wrap">
          <div class="container">
            <div class="row">
              <div class="col-lg-7 col-md-7 col-sm-6">
                <div class="banner-content">
                  <h6 class="wow fadeInUp" data-wow-duration="600ms" data-wow-delay="300ms">{!! $pageContent->section_1_heading_1 !!}</h6>
                  <h2 class="wow fadeInUp" data-wow-duration="600ms" data-wow-delay="600ms">{!! $pageContent->section_1_heading_2 !!}</h2>
                  <a href="{!! $pageContent->section_1_link_1 !!}" class="btn btn-default wow fadeInUp" data-wow-duration="600ms" data-wow-delay="800ms">Get Packagese</a>
                </div>
              </div>
              <!-- /.navbar-collapse -->
			  @if(isset($logged_users->id) && $logged_users->id > 0)
				  
			  @else
              <div class="col-lg-4 col-md-5 col-sm-6 pull-right wow fadeInRight" data-wow-duration="800ms" data-wow-delay="600ms">
                <div class="signup-box">
                    <h3>Get Started</h3>
					{!! Form::open(['route' => 'signup.query', 'method' => 'GET', 'class' => 'signup-form', 'id' => 'contact-form']) !!} 
                      <div class="form-group">
                        <input type="text" name="full_name" class="form-control" id="full_name" placeholder="Full Name" value="{!! Input::old('full_name') !!}" required>
                      </div>
                      <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" value="{!! Input::old('email') !!}" required>
                      </div>
					  <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="{!! Input::old('password') !!}" required>
                      </div>
					  <div class="form-group">
                        <input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="Confirm Password" value="{!! Input::old('password_confirm') !!}" required>
                      </div>
                      <div class="form-group">
                          <h5>Choose a Membership </h5>
                          <div class="radio radio-inline">
                              <input type="radio" id="Elite" @if(Input::old('user_type') == "Elite") checked="checked" @endif checked="checked" value="Elite" name="user_type" >
                              <label for="Elite">Elite</label>
                          </div>
                          <div class="radio radio-inline">
                              <input type="radio" id="Knight" @if(Input::old('user_type') == "Knight") checked="checked" @endif value="Knight" name="user_type" >
                              <label for="Knight">Knight</label>
                          </div>
                      </div>
                      <div class="form-group">
                          <h5>Join a Group</h5>
                          <div class="radio radio-inline">
                              <input type="radio" id="Quarter" value="Quarter" name="period" @if(Input::old('period') == "Quarter") checked="checked" @endif checked="checked">
                              <label for="Quarter">Quarter</label>
                          </div>
                          <div class="radio radio-inline">
                              <input type="radio" id="Bi-Annual" value="Bi-Annual" name="period" @if(Input::old('period') == "Bi-Annual") checked="checked" @endif>
                              <label for="Bi-Annual">Bi-Annual</label>
                          </div>
                          <div class="radio radio-inline">
                              <input type="radio" id="Annual" value="Annual" name="period" @if(Input::old('period') == "Annual") checked="checked" @endif>
                              <label for="Annual">Annual</label>
                          </div>
                      </div>
                      <div class="form-group m-t-20">
						{!! Form::select('package_type',['Bronze' => 'Bronze', 'Silver' => 'Silver','Gold' => 'Gold','Platinum' => 'Platinum'] ,null, array('class' => 'form-control', 'required' => 'required', 'placeholder'=>'Select a Package'))!!}
                      </div>
					  <!--<div class="form-group m-t-20">
						{!! app('captcha')->display($attributes = [], $lang = null); !!}
                      </div>-->
                      <button type="submit" name="submit" class="btn btn-default btn-block" >SIGN UP</button>
                    {!! Form::close() !!}
                </div>
              </div>
			  @endif
              <!-- /.signup-box -->
            </div>
          </div>
      </div>
      <!--/.contnet-wrap-->
  </section>
  <!-- Banner End -->
  <!-- Main Services Start -->
  <section class="section wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
    <div class="container">
      <div class="services-sec">
          <div class="col-md-6 no-padding">
              <div class="service-box">
                  <div class="bs-wizard-step">
                    <div class="bs-wizard-info text-center">
                      <h3>Elite</h3>
                      <p>{!! $siteSettingData[0]->elite_text !!}</p>
                    </div>
                  </div>
                  <div class="row bs-wizard">
                     <div class="col-xs-4 bs-wizard-step complete">
                        <div class="progress"><div class="progress-bar"></div></div>
                        <a href="#" class="bs-wizard-dot"> <img src="{!! URL::to('uploads/source/'.$siteSettingData[0]->elite_sign_up_icon) !!}" alt=""> </a>
                        <label>{!! $siteSettingData[0]->elite_sign_up_icon_text !!}</label>
                      </div>
                      <div class="col-xs-4 bs-wizard-step complete">
                          <div class="progress"><div class="progress-bar"></div></div>
                          <a href="#" class="bs-wizard-dot"> <img src="{!! URL::to('uploads/source/'.$siteSettingData[0]->elite_invest_icon) !!}" alt=""> </a>
                          <label>{!! $siteSettingData[0]->elite_invest_icon_text !!}</label>
                      </div>
                      <div class="col-xs-4 bs-wizard-step complete">
                        <div class="progress"><div class="progress-bar"></div></div>
                        <a href="#" class="bs-wizard-dot"> <img src="{!! URL::to('uploads/source/'.$siteSettingData[0]->elite_profit_icon) !!}" alt=""> </a>
                        <label>{!! $siteSettingData[0]->elite_profit_icon_text !!}</label>
                      </div>
                  </div>
                  <div class="bs-wizard-info text-center">
                    <a href="#" name="submit" class="btn btn-default">Get Membership</a>
                  </div>
              </div>
          </div>
          <!-- /.Elite-box -->
          <div class="col-md-6 no-padding">
              <div class="service-box">
                  <div class="bs-wizard-step">
                    <div class="bs-wizard-info text-center">
                      <h3>Knights</h3>
                      <p>{!! $siteSettingData[0]->knights_text !!}</p>
                    </div>
                  </div>
                  <div class="row bs-wizard">
                     <div class="col-xs-4 bs-wizard-step complete">
                        <div class="progress"><div class="progress-bar"></div></div>
                        <a href="#" class="bs-wizard-dot"> <img src="{!! URL::to('uploads/source/'.$siteSettingData[0]->knight_sign_up_icon) !!}" alt=""> </a>
                        <label>{!! $siteSettingData[0]->knight_sign_up_icon_text !!}</label>
                      </div>
                      <div class="col-xs-4 bs-wizard-step complete">
                          <div class="progress"><div class="progress-bar"></div></div>
                          <a href="#" class="bs-wizard-dot"> <img src="{!! URL::to('uploads/source/'.$siteSettingData[0]->knight_withdraw_icon) !!}" alt=""> </a>
							<label>{!! $siteSettingData[0]->knight_withdraw_icon_text !!}</label>
                      </div>
                      <div class="col-xs-4 bs-wizard-step complete">
                        <div class="progress"><div class="progress-bar"></div></div>
                        <a href="#" class="bs-wizard-dot"> <img src="{!! URL::to('uploads/source/'.$siteSettingData[0]->knight_installments_icon) !!}" alt=""> </a>
                        <label>{!! $siteSettingData[0]->knight_installments_icon_text !!}</label>
                      </div>
                  </div>
                  <div class="bs-wizard-info text-center">
                    <a href="#" name="submit" class="btn btn-default">Get Membership</a>
                  </div>
              </div>
          </div>
          <!-- /.Knights-box -->
      </div>
      <!-- /.services-sec-->
    </div>
  </section>
  @include('includes.packages', ['active_packages' => $active_packages])
  <section class="section callto-action">
    <div class="container">
      <div class="row">
        <div class="col-md-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
            <a href="#" data-toggle="modal" data-target="#video-modal"><img src="images/paly-icon.png" class="img-responsive" alt=""></a>
        </div>
      </div>
    </div>
  </section>
  <!-- Call To Action End -->
  <!-- Video Modal Start -->
	<div id="video-modal" class="modal fade" role="dialog" tabindex="-1"> 
	  <div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-body">
			  <button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i> </button>
			  <iframe width="100%" height="400" src="{!! $pageContent->page_video !!}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		  </div>
		</div>
	  </div>
	</div>
  <!-- Video Modal End -->
@stop    