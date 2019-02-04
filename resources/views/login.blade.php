
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('images/favicon.png') }}" />
	<title>{{$title}}</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{ URL::asset('kit/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">

	
	<!-- /global stylesheets -->
	

	<!-- Core JS files -->
	<script type="text/javascript" src="{{ URL::asset('kit/js/plugins/loaders/pace.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('kit/js/core/libraries/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
	<!-- /core JS files -->
	

	<!-- base CSS & JS file -->
	<link href="{{ URL::asset('css/app.css') }}" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/common.js') }}"></script>


	<link href="{{ URL::asset('kit/css/core.min.css') }}" rel="stylesheet" type="text/css">	
	<link href="{{ URL::asset('kit/css/components.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::asset('kit/css/colors.min.css') }}" rel="stylesheet" type="text/css">
	<style>
		/* Base for label styling */
		[type="checkbox"]:not(:checked),
		[type="checkbox"]:checked {
		  position: absolute;
		  left: -9999px;
		}
		[type="checkbox"]:not(:checked) + label,
		[type="checkbox"]:checked + label {
		  position: relative;
		  padding-left: 1.95em;
		  cursor: pointer;
		}

		/* checkbox aspect */
		[type="checkbox"]:not(:checked) + label:before,
		[type="checkbox"]:checked + label:before {
		  content: '';
		  position: absolute;
		  left: 0; top: 3px;
		  width: 1em; height: 1em;
		  border: 1px solid #333;
		  background: #fff;
		  /*border-radius: 4px;*/
		  box-shadow: inset 0 1px 3px rgba(0,0,0,.1);
		}
		/* checked mark aspect */
		[type="checkbox"]:not(:checked) + label:after,
		[type="checkbox"]:checked + label:after {
		    content: '\2713\0020';
		    position: absolute;
		    top: 0.4em;
		    left: 0.15em;
		    font-size: 1em;
		    line-height: 0.8;
		    color: #1E88E5;
		    transition: all .2s;
		    font-family: 'Lucida Sans Unicode', 'Arial Unicode MS', Arial;
		}
		/* checked mark aspect changes */
		[type="checkbox"]:not(:checked) + label:after {
		  opacity: 0;
		  transform: scale(0);
		}
		[type="checkbox"]:checked + label:after {
		  opacity: 1;
		  transform: scale(1);
		}
</style>
</head>

<body class="login-container">

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content">

					<!-- Simple login form -->
					<form action="{{route('CheckLogin')}}" method="POST">
						@csrf
						<div class="panel panel-body login-form">
							<div class="text-center">
								<div class="icon-object border-slate-300 text-slate-300">
									<img src="{{ URL::asset('images/favicon.png') }}" alt="">
								</div>
								<h5 class="content-group">Amax Education <small class="display-block">Enter your credentials below</small></h5>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
								 @if ($errors->has('email'))
                                    {!! $errors->first('email', '<label class="error">:message</label>') !!}	
                                @endif
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" name="password" required>
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
								 @if ($errors->has('password'))
                                    {!! $errors->first('password', '<label class="error">:message</label>') !!}	
                                @endif
							</div>

						   <div class="form-group row">
	                            <div class="col-md-6 offset-md-4">
	                                <div class="form-check">
	                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

	                                    <label class="form-check-label" for="remember">
	                                        {{ __('Remember Me') }}
	                                    </label>
	                                </div>
	                            </div>
	                        </div>

							<div class="form-group">
								<button type="submit" name="submit" class="btn bg-primary-400 btn-block">Đăng nhập <i class="icon-circle-right2 position-right"></i></button>
							</div>

						</div>
					</form>
					<!-- /simple login form -->


					<!-- Footer -->
					{{-- <div class="footer text-muted text-center">
						&copy; 2015. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
					</div> --}}
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

</body>
</html>

