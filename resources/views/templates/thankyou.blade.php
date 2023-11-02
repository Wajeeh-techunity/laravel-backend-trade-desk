@extends('layouts.site.master')

@section('page-title')
	Thank You | Noble Folks
@stop

@section('content')
<!-- Home Page Here -->
	<section class="my-playlist">
		<div class="container">
			<div class="myDash">
				
				<div class="playlist-tabs" role="tabpanel">
						<center>
							<h2>Thank you! Your payment has been processed..</h2>
							<h2>Go to the MC.company and ROAM!!</h2>
						</center>
						<!-- Tab panes -->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="music">
								<div class="musics-mc">
									
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
<!-- End Home Page -->
<!-- End Footer -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> <!-- Jquery -->
	<script type="text/javascript">
		$(document).ready(function(){
			setTimeout(function(){ 
				window.location="{!! URL::to('/'); !!}"; 
			}, 4000);
		});
	</script>

@endsection




