@extends('layout.app')

@section('content')
	<form class="login-form" action="{{route('login.adminsubmit')}}" method="POST">
		@csrf
		<h3 class="form-title">Login to your account</h3>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>
			Enter any username and password. 
			</span>
		</div>
		@if($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                <i data-feather="alert-circle" class="mg-r-10"></i> {{ $message }}
            </div>
            @endif

            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">Username</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Domain Account" name="username" id="username"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Password</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" id="password"/>
			</div>
		</div>
		<div class="form-actions">
			<label class="checkbox">
			<input type="checkbox" name="remember" value="1"/> Remember me </label>
			<button type="submit" class="btn blue pull-right">
			Login <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
		
		{{-- <div class="forget-password">
			<h4>Forgot your password ?</h4>
			<p>
				no worries, click <a href="javascript:;" id="forget-password">
				here </a>
				to reset your password.
			</p>
		</div>
		<div class="create-account">
			<p>
				Don't have an account?&nbsp; <a href="">Register Here</a>
			</p>
		</div> --}}
        <div class="form-actions">
            <p class="text-center" style="color:#d32424;margin-top:50px;font-size:14px;font-weight:bold;">The System is in Maintenance Mode!</a></p>
        </div>
	</form>
	<!-- END LOGIN FORM -->
	<!-- BEGIN FORGOT PASSWORD FORM -->
	{{-- <form class="forget-form" action="email/confirmation_send.php" method="get">
		<h3>Forget Password ?</h3>
		<p>
			 Enter your fullname, domain account and e-mail address below to reset your password.
		</p>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Full Name</label>
			<div class="input-icon">
				<i class="fa fa-font"></i>
				<input class="form-control placeholder-no-fix" type="text" placeholder="Last, First Middle" name="name"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Domain Account</label>
			<div class="input-icon">
				<i class="fa fa-info"></i>
				<input class="form-control placeholder-no-fix" type="text" placeholder="Domain" name="domain"/>
			</div>
		</div>
		<div class="form-group">
			<div class="input-icon">
				<i class="fa fa-envelope"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email"/>
			</div>
		</div>
		<div class="form-actions">
			<button type="button" id="back-btn" class="btn">
			<i class="m-icon-swapleft"></i> Back </button>
			<button type="submit" class="btn blue pull-right">
			Submit <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
       
	</form> --}}
@endsection