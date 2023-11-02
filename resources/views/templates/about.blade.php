{{-- * Template Name : About * --}}
@extends('layouts.site.master')

@section('page-title')
    {!! isset($pageContent->meta_title) ? $pageContent->meta_title : 'Noble Folks  | About Us' !!}
@stop

@section('meta-keywords')
    {!! isset($pageContent->meta_keywords) ? $pageContent->meta_keywords : 'Noble Folks  | About Us' !!}
@stop

@section('meta-description')
    {!! isset($pageContent->meta_description) ? $pageContent->meta_description : 'Noble Folks  | About Us' !!}
@stop

@section('content')
<!-- Sub Header Start -->

  <section class="sub-header">

    <div class="container">

      <div class="page-title">

        <h1>About Us</h1>

      </div>

      <div class="breadcrumb">

        <li><a href="{{ URL::to('/') }}">Home</a></li>

        <li>About Us</li>

      </div>

    </div>

  </section>

  <!-- Sub Header End -->





  <!-- Content Section Start -->

  <section class="section servcies-sec">

    <div class="container">

     

      <div class="row">

          <div class="col-md-7 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">

              <h2>{!! $pageContent->title !!}</h2>

              {!! $pageContent->content !!}

          </div>

          <div class="col-md-5 wow fadeInDown about-img" data-wow-duration="1000ms" data-wow-delay="600ms">

            <img src="{!! URL::to('uploads/source/'.$pageContent->image) !!}" alt="" class="img-responsive">

            <a href="#" data-toggle="modal" data-target="#video-modal"><img src="images/paly-icon.png" class="img-responsive" alt=""></a>

          </div>

      </div>

    </div>

  </section>

  <!-- Content Section End -->
  <!-- Main Services Start -->
  <section class="section wow fadeInDown back bg-gray" data-wow-duration="1000ms" data-wow-delay="300ms">
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

                        <a href="#" class="bs-wizard-dot"> <img src="images/signup-icon.png" alt=""> </a>

                        <label>Sign Up</label>

                      </div>

                      <div class="col-xs-4 bs-wizard-step complete">

                          <div class="progress"><div class="progress-bar"></div></div>

                          <a href="#" class="bs-wizard-dot"> <img src="images/withdraw-icon.png" alt=""> </a>

                          <label>Withdraw</label>

                      </div>

                      <div class="col-xs-4 bs-wizard-step complete">

                        <div class="progress"><div class="progress-bar"></div></div>

                        <a href="#" class="bs-wizard-dot"> <img src="images/installment-icon.png" alt=""> </a>

                        <label>Installments</label>

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
  <!-- Main Services End -->
@endsection