@extends('layouts.site.master')

@section('page-title')
	Site Search | Noble Folks
@stop

@section('content')
<!-- Home Page Here -->
	<section class="my-playlist">
		<div class="container">
			<div class="myDash">
				
				<div class="playlist-tabs" role="tabpanel">
						<!--<center>
							<h2>Thank you! Your payment has been processed..</h2>
							<h2>Go to the MC.company and ROAM!!</h2>
						</center>-->
						<h2>Search Result</h2>
						<!-- Tab panes -->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="music">
								<div class="musics-mc">
									<ul>
									@if( (isset($videosdata) && count($videosdata) > 0) || isset($audiosdata) && count($audiosdata))
										@if(isset($videosdata) && count($videosdata) > 0)
											@foreach($videosdata as $videodata)
												<li>
													<a href='{!! URL::to("video/".$videodata["id"]) !!}'>{!! $videodata['title'] !!}</a>
												</li>
											@endforeach
										@endif
										@if(isset($audiosdata) && count($audiosdata) > 0)
											@foreach($audiosdata as $audiodata)
												<li>
													<a href='{!! URL::to("audio/".$audiodata["id"]) !!}'>{!! $audiodata['title'] !!}</a>
												</li>
											@endforeach
										@endif
									@else
										<li>Record not found!</li>
									@endif
									</ul>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="films">
								
								
							</div>
						</div>
					</div>	
				<!--  -->
			</div>
		</div>
	</section>

@endsection




