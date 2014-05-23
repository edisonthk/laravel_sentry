@include("header")

<h1>ユーザ新規</h1>

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

{{ Form::open(array('url' => '/storeUser')) }}

	<div class="form-group">
		{{ Form::label('email', 'Email') }}
		{{ Form::text('email', Input::old('email'), array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('password', 'Password') }}
		{{ Form::password('password', null , array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('repeatpassword', 'Repeat Password') }}
		{{ Form::password('repeatpassword', null , array('class' => 'form-control')) }}
	</div>

	{{ Form::submit('Create new users!', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

</div>
</body>
</html>