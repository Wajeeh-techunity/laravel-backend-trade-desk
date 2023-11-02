{{-- * Template Name : Faq * --}}
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
<!-- Sub Header Start -->

  <section class="sub-header">

    <div class="container">

      <div class="page-title">

        <h1>Q&A</h1>

      </div>

      <div class="breadcrumb">

        <li><a href="{{ URL::to('/') }}">Home</a></li>

        <li>Q&A</li>

      </div>

    </div>

  </section>

  <!-- Sub Header End -->





  <!-- Contact Section Start -->

  <section  class="section contact-sec">

    <div class="container">



      <div class="row contact-wrap">



        <div class="col-md-12">

          <h2>Question & Answers</h2>

          

          <div class="panel-group" id="accordion">
			{{-- */$i=0;/* --}}
			  @foreach($faqs as $faq){{-- */$i++;/* --}}
			  <div class="panel panel-default">
				<div class="panel-heading">
				  <h4 class="panel-title">
					<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{!! $i !!}" aria-expanded="false">
					  {!! $faq['title'] !!}
					</a>
				  </h4>
				</div>
				<div id="collapse{!! $i !!}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
				  <div class="panel-body">
					{!! $faq['content'] !!}
				  </div>
				</div>
			  </div>
			  @endforeach

            
          </div>



        </div>

       

      </div>

      <!--/.row-->



    </div>

  </section>

  <!-- Contact Section End -->
@endsection
