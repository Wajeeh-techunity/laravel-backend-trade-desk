{{-- * Template Name : Registration * --}}
@extends('layouts.site.master')
@section('page-title')
    {!! isset($pageContent->meta_title) ? $pageContent->meta_title : 'Noble Folks  | Sign Up' !!}
@stop
@section('meta-keywords')
    {!! isset($pageContent->meta_keywords) ? $pageContent->meta_keywords : 'Noble Folks  | Sign Up' !!}
@stop
@section('meta-description')
    {!! isset($pageContent->meta_description) ? $pageContent->meta_description : 'Noble Folks  | Sign Up' !!}
@stop
@section('content')
@if(isset($logged_users->user_type) && ($logged_users->user_type == "Elite" || $logged_users->user_type == "Knight"))
	<script>window.location="{{ route('account-management/user_type') }}";</script>
@endif
<!-- Sub Header Start -->
  <section class="sub-header">
    <div class="container">
      <div class="page-title">
        <h1>Sign Up</h1>
      </div>
      <div class="breadcrumb">
        <li><a href="index.html">Home</a></li>
        <li>Sign Up</li>
      </div>
    </div>
  </section>
  <!-- Sub Header End -->
  <!-- Contact Section Start -->
  <section  class="section contact-sec">
    <div class="container">
      <div class="row contact-wrap">
        <div class="col-md-5 col-auto signup-sec">
          <h2>Send Us a Message</h2>
          <p>Create your account by filling the form bellow</p>
          {!! Form::open(['route' => 'signup.query', 'method' => 'POST', 'class' => 'contactForm', 'id' => 'contact-form']) !!}
            <div class="row">
				<div class="contact-top">
					@if (count($errors) > 0)
						<div class="alert alert-danger clearfix">{!! implode('<br>', $errors->all()) !!}</div>
					@endif
					@if (Session::has('errors2'))
						<div class="alert alert-danger clearfix">{!! Session::get('errors2') !!}</div>
					@endif
					@if(Session::has('alert-success'))
						<p class="alert alert-success">{{ Session::get('alert-success') }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
					@endif
					
				</div>
                <div class="col-md-12">
                    <div class="form-group">
                      {!!Form::text('full_name', (isset($_REQUEST['full_name'])) ? $_REQUEST['full_name'] : Input::old('full_name'), ['required'=>'required','placeholder' => 'Full Name','class'=>'form-control']) !!}
                      <div class="validation"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                      {!!Form::text('email', (isset($_REQUEST['email'])) ? $_REQUEST['email'] : Input::old('email'), ['required'=>'required','placeholder' => 'Email','class'=>'form-control']) !!}
                      <div class="validation"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                      <input required="" placeholder="Password*" id="input_password" class="form-control" name="password" type="password" value="{{ (isset($_REQUEST['password'])) ? $_REQUEST['password'] : Input::old('password') }}">
                      <small>(password must have minimum 8 characters and should contain one upper case letter)</small>
					  <div class="validation"></div>
                    </div>
                </div>
				<div class="col-md-12">
                    <div class="form-group">
                      <input required="" placeholder="Confirm Password*" id="password_confirm" class="form-control required" name="password_confirm" type="password" value="{{ (isset($_REQUEST['password_confirm'])) ? $_REQUEST['password_confirm'] : Input::old('password_confirm') }}">
					  <div class="validation"></div>
                    </div>
                </div> 
				<div class="col-md-12">
					<div class="form-group">
						<h5>Date of Birth</h5>
						{!!Form::date('dob', (isset($_REQUEST['dob'])) ? $_REQUEST['dob'] : Input::old('dob'), ['placeholder' => 'DOB','class'=>'form-control']) !!}
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<h5>Mobile Number</h5>
						{!!Form::text('phone_number', (isset($_REQUEST['phone_number'])) ? $_REQUEST['phone_number'] : Input::old('phone_number'), ['required'=>'required','placeholder' => 'Mobile Number','class'=>'form-control numbers-only']) !!}
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<h5>Work Phone Number</h5>
						{!!Form::text('phone', (isset($_REQUEST['phone'])) ? $_REQUEST['phone'] : Input::old('phone'), ['required'=>'required','placeholder' => 'Work Phone Number','class'=>'form-control numbers-only']) !!}
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<h5>Country</h5>
						<select data-placeholder="Choose a Country" class="form-control required" id="mcountry" name="country_id">
							<option value="">Select Country</option>
						  @foreach($selectCountries as $id=>$country )
							<option value="{!! $id !!}" @if($id == $cuntryid) selected="selected" @endif>{!! $country !!}</option>
						  @endforeach
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<h5>State</h5>
						{!! Form::select('state_id', $selectStates,Input::old('state_id'),array('class' => 'form-control states required', 'id'=>'mstates')) !!}
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<h5>City</h5>
						{!! Form::select('city_id', $selectCities,Input::old('city_id'),array('class' => 'form-control states required', 'id'=>'mcities')) !!}
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<h5>Zip Code</h5>
						{!!Form::text('zipcode', (isset($_REQUEST['zipcode'])) ? $_REQUEST['zipcode'] : Input::old('zipcode'), ['required'=>'required','placeholder' => 'Zip Code','class'=>'form-control']) !!}
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<h5>Choose a Membership </h5>
						<div class="radio radio-inline">
							<input type="radio" id="Elite" @if(Input::old('user_type') == "Elite") checked="checked" @endif checked="checked" @if(isset($_REQUEST['user_type']) && $_REQUEST['user_type'] == 'Elite') checked="checked" @endif value="Elite" name="user_type" >
							<label for="Elite">Elite</label>
						</div>
						<div class="radio radio-inline">
							<input type="radio" id="Knight" @if(Input::old('user_type') == "Knight") checked="checked" @endif value="Knight" name="user_type" @if(isset($_REQUEST['user_type']) && $_REQUEST['user_type'] == 'Knight') checked="checked" @endif>
							<label for="Knight">Knight</label>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<h5>Join a Group</h5>
						<div class="radio radio-inline">
							<input type="radio" id="Quarter" value="Quarter" name="period" @if(Input::old('period') == "Quarter") checked="checked" @endif @if(isset($_REQUEST['period']) && $_REQUEST['period'] == 'Quarter') checked="checked" @endif checked="checked">
							<label for="Quarter">Quarter</label>
						</div>
						<div class="radio radio-inline">
							<input type="radio" id="Bi-Annual" value="Bi-Annual" name="period" @if(Input::old('period') == "Bi-Annual") checked="checked" @endif @if(isset($_REQUEST['period']) && $_REQUEST['period'] == 'Bi-Annual') checked="checked" @endif>
							<label for="Bi-Annual">Bi-Annual</label>
						</div>
						<div class="radio radio-inline">
							<input type="radio" id="Annual" value="Annual" name="period" @if(Input::old('period') == "Annual") checked="checked" @endif @if(isset($_REQUEST['period']) && $_REQUEST['period'] == 'Annual') checked="checked" @endif>
							<label for="Annual">Annual</label>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group m-t-20">
						{!! Form::select('package_type',['Bronze' => 'Bronze', 'Silver' => 'Silver','Gold' => 'Gold','Platinum' => 'Platinum'] ,(isset($_REQUEST['package_type'])) ? $_REQUEST['package_type'] : Input::old('package_type'), array('class' => 'form-control', 'required' => 'required', 'placeholder'=>'Select a Package'))!!}
					</div>
			    </div>
                
				<!--<div class="col-md-12">
					<div class="form-group m-t-20">
						<label>Payment Method</label>
						<select class="form-control" id="payment_method">
							<option value="paypal">Pay By PayPal and Sign Up</option>
							<option value="cc">Pay By Credit Card and Sign Up</option>
						</select>
					</div>
				</div>-->
            </div>
			<div class="credit_payment_method col-md-12">
				<div class="row">
					<div class="col col-md-12">
						<label>Card Holder Name</label>
						<input id="card_name" name="card_fname" type="text" placeholder="Card Holder Name" class="form-control creditCardRequired" />
					</div>
				</div>
				<div class="row">
					<div class="col col-md-12">
						<label>Card Number</label>
						<input id="card_number" onkeypress="return validateNumber(event);" name="card_number" type="text" maxlength='16' placeholder="Credit Card Number" class="form-control creditCardRequired numbers-only" />
					</div>
				</div>
				<div class="row">
					<div class="col col-md-6 join-period">
						<label>Expiry Month</label>
						{!! Form::select('expiration_month', $months,'01',array('class' => 'form-control creditCardRequired', 'id'=>'expiration_month')) !!}
					</div>
					<div class="col col-md-6">
						<label>Expiry Year</label>
						{!! Form::select('expiration_year', $years,'21',array('class' => 'form-control creditCardRequired', 'id'=>'expiration_year')) !!}
					</div>
				</div>
				<div class="row">
					<div class="col col-md-12 join-period">
						<label>CVV</label>
						<input id="card_cvv" name="card_cvv" type="text" placeholder="CVV" class="form-control creditCardRequired number" />
					</div>
				</div>
				
			</div>
			<div class="col-md-12"><br>
				<div class="form-group">
					<label><input type="checkbox" name="terms" value="1" required="required" class="required"> <span><a href="{{ URL::to('terms-condition') }}" target="_blank">Terms & Conditions. *</a></span></label>
					<div class="validation"></div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
				  {!! app('captcha')->display($attributes = [], $lang = null); !!}
				</div>
			</div>
			<div class="row">
				<div class="col-md-12"><br>
					<div class="form-group">
						<button type="submit" name="submit" class="btn btn-default btn-block" required="required">Sign Up</button>
					</div>
				</div>
			</div>
			<!--<div class="row form-group paypal_payment_method">
				<div class="col-md-12">
					<script src="https://www.paypalobjects.com/api/checkout.js"></script>
					<div id="paypal-button-container" ></div>
				</div>
			</div>-->
            
            <p>Already have an account? <a href="{{ route('member-login') }}">Sign In</a> </p>
          {!! Form::close() !!}
        </div>
      </div>
      <!--/.row-->
    </div>
  </section>
  <!-- Contact Section End -->
<script>
	// Render the PayPal button

	paypal.Button.render({

		// Set your environment

		env: 'sandbox', // sandbox | production

		// Specify the style of the button

		style: {
			label: 'pay',
			size:  'medium',    // small | medium | large | responsive
			shape: 'pill',     // pill | rect
			color: 'gold'      // gold | blue | silver | black
		},

		// PayPal Client IDs - replace with your own
		// Create a PayPal app: https://developer.paypal.com/developer/applications/create

		client: {
			//sandbox:    'AYqhsNAw76IW2kQphEx_hEfuljSEkW4z2OpW4BKtRRYzSvXNV9k9JB6-UA7HbFVn87tGR9fcNoNlXOk0',
			sandbox:    'ARqI3BPHTGG61r3BLMKFB_yB_aBX9sDKGcfBnKDrLC3szT6egbl7VCzVS2zhnHM6h_lqgN_Al-GGx4ji',
			//production: 'EKefL-nyO_c7GgxYOzOSmWZ6JhmQSXBmHjxnFlaSUTBg98X1T3Hx5IO1Kego0iFCcc3JQeRuthj4dgA-'
			production: 'ASMraOBXvVtaQWPzPnc1R_sSbSBq1cBMoUOY1b1kNYUw6_PogjlcTGakR7uHQd9H6N4ZKVdgvxAWU7aF'
		},

		payment: function(data, actions) {
			return actions.payment.create({
				payment: {
					transactions: [
						{
							amount: { total: $('#total_amount').val(), currency: 'USD' }
						}
					]
				}
			});
		},
		onAuthorize: function(data, actions) {
			return actions.payment.execute().then(function() {
				$('#paypal_payment_id').val(data['paymentID']);
				$('#paypal_payer_id').val(data['payerID']);
				$('#payment-form').submit();
				console.log(data['payerID']);
				console.log(data['orderID']);
				console.log(data['paymentID']);
				console.log(data['paymentToken']);
				console.log(data);
				window.alert('Payment Complete!');
			});
		}
	}, '#paypal-button-container');

</script>
@endsection





