<!DOCTYPE html>
<html>
<head>
	<title>Look! I'm CRUDding</title>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
</head>
<body>
	<div>
		<h1>ログインフォーム</h1>

		<!-- if there are creation errors, they will show here -->
		{{ HTML::ul($errors->all()) }}

		{{ Form::open(array('url' => '/login')) }}

		<div class="form-group">
			{{ Form::label('email', 'Email') }}
			{{ Form::text('email', Input::old('email'), array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('password', 'Password') }}
			{{ Form::password('password', null , array('class' => 'form-control')) }}
		</div>

		{{ Form::submit('ログイン', array('class' => 'btn btn-primary')) }}

		{{ Form::close() }}

	</div>
</body>
</html>