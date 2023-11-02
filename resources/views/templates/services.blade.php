{{-- * Template Name : Services * --}}
@extends('layouts.site.master')

@section('page-title')
    {!! isset($pageContent->meta_title) ? $pageContent->meta_title : 'Noble Folks  | Services' !!}
@stop

@section('meta-keywords')
    {!! isset($pageContent->meta_keywords) ? $pageContent->meta_keywords : 'Noble Folks  | Services' !!}
@stop

@section('meta-description')
    {!! isset($pageContent->meta_description) ? $pageContent->meta_description : 'Noble Folks  | Services' !!}
@stop

@section('content')
<!-- Sub Header Start -->
<section class="sub-header">
   <div class="container">
      <div class="page-title">
         <h1>{!! $pageContent->title !!}</h1>
      </div>
      <div class="breadcrumb">
         <li><a href="{{ URL::to('/') }}">Home</a></li>
         <li>{!! $pageContent->title !!}</li>
      </div>
   </div>
</section>
<!-- Sub Header End -->
<!-- Pricing Sec Start -->
  <section class="section wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">

    <div class="container">

      <div class="services-sec">

          

          <div class="col-md-6 no-padding">

              <div class="service-box">

                  <div class="bs-wizard-step">

                    <div class="bs-wizard-info text-center">

                      <h3>Elite</h3>

                      <p>Elite membership is for those who wants to save for profit. Select this option and decide how long you need your money back by joining a Group from the three choices available. Next, select a package by choosing the dollar amount you are committed to invest upfront.</p>

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

                          <a href="#" class="bs-wizard-dot"> <img src="images/invest-icon.png" alt=""> </a>

                          <label>Invest</label>

                      </div>

                      <div class="col-xs-4 bs-wizard-step complete">

                        <div class="progress"><div class="progress-bar"></div></div>

                        <a href="#" class="bs-wizard-dot"> <img src="images/profit-icon.png" alt=""> </a>

                        <label>Profit</label>

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

                      <p>Knight membership is for those who prefer to borrow. Select this option and decide how long you can pay back on monthly basis by joining a Group from the three choices available. Next, select the dollar amount you need. These dollar amount is multiplied by the number of months applicable to the package duration.</p>

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

  <!-- Main Services End -->
  <!-- Pricing Table Knight Start -->
	@include('includes.packages', ['active_packages' => $active_packages])
  <!-- Pricing Pricing Table Elite End -->
<!-- Fees Section End -->
@endsection





