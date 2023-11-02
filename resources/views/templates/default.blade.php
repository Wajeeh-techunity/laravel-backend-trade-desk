@extends('layouts.app')

@section('page-title', $pageContent->mata_title??'')


@section('meta-keywords')
    {{$pageContent->mata_keywords??''}}
@stop

@section('meta-description')
    {{$pageContent->meta_description??''}}

@stop
@section('content')
    <section class="inner_page_breadcrumb knBnr" style="background: url('{{asset('uploads/files/'.$pageContent->banner_image)}}')">
        <div class="container">
            <div class="breadcrumb_content text-center">
                <h4 class="breadcrumb_title">{{$pageContent->title??'' }} </h4>
            </div>
        </div>
    </section>

    <!-- Our Team -->
    <section class="main_sec exPg tradePg bgc-f7">
        <div class="container">

            <div class="text-center pb30">
                <p>{!! $pageContent->content??'' !!}</p>
            </div>

            @if(isset($pageContent->content2) && !empty($pageContent->content2))
                @forelse(unserialize($pageContent->content2) as $content)
                    <div class="pst">
                        {!! $content??'' !!}
                    </div>
                @empty
                @endforelse
            @endif

            <div class="row">
                @if(isset($pageContent->other_images) && !empty($pageContent->other_images))
                    @forelse(unserialize($pageContent->other_images) as $image)
                        <div class="col-sm-6">
                            <div class="pst">
                                <figure><img src="{{asset('uploads/files/'.$image)}}"></figure>
                            </div>
                        </div>
                    @empty
                    @endforelse
                @endif
            </div>

        </div>


    </section>

@endsection
