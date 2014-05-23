<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function getLogin()
	{

		if (Sentry::check()){
			return Redirect::to('/privatePage');
		}


		return View::make('login');
	}

	public function postLogin()
	{
		$msg = "";

		try
		{

    // Login credentials
			$credentials = array(
				'email'    => Input::get('email'),
				'password' => Input::get('password'),
			);

    // Authenticate the user
			$user = Sentry::authenticate($credentials, false);
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			$msg ='Login field is required.';
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			$msg = 'Password field is required.';
		}
		catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
		{
			$msg = 'Wrong password, try again.';
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			$msg = 'User was not found.';
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
			$msg = 'User is not activated.';
		}

// The following is only required if the throttling is enabled
		catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
		{
			$msg = 'User is suspended.';
		}
		catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
		{
			$msg = 'User is banned.';
		}

		if(!empty($msg))
		{
			return Redirect::to('/login')
				->withErrors($msg)
				->withInput(Input::except('password'));				
		}

		return Redirect::to('/privatePage');
	}

	public function getPrivatePage(){
		if (!Sentry::check()){
			// not private page, redirect to login
			return Redirect::to('/login');
		}else{
			return View::make('privatePage');
		}
		
	}

	public function createUser()
	{
		if (!Sentry::check()){
			// not private page, redirect to login
			return Redirect::to('/login');
		}

		$msg = "";
		return View::make('/createUser')->with("msg",$msg);
	}

	public function storeUser(){
		
		

		if(Input::get('password') != Input::get('repeatpassword')){
			Return Redirect::to('/createUser')
			->withErrors("パスワードが一致しません")
			->withInput(Input::except('password'));
		}else{

			$err_message = "";

			try
			{

				$email = Input::get('email');
				if(!preg_match('/(.*?)@(.*?).(.*?)/', $email)){
					throw new Exception('Invalid email');
				}

				    // Create the user
				$user = Sentry::createUser(array(
					'email'       => $email,
					'password'    => Input::get('password'),
					'activated'   => true,
					'permissions' => array(
						'user.create' => 1,
						'user.delete' => 1,
						'user.view'   => 1,
						'user.update' => 1,
						),
					));
			}
			catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
			{
				$err_message = 'Login field is required.';
			}
			catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
			{
				$err_message = 'Password field is required.';
			}
			catch (Cartalyst\Sentry\Users\UserExistsException $e)
			{
				$err_message = 'User with this login already exists.';
			}
			catch(Exception $e)
			{
				$err_message = $e->getMessage();
			}

			if(!empty($err_message)){
				return Redirect::to('/createUser')
				->withErrors($err_message)
				->withInput(Input::except('password'));
			}

			Session::flash('message', 'Successfully created user!');
			return Redirect::to('/');
		}
		
	}

	public function logout()
	{
		Sentry::logout();
		return Redirect::to('/login');
	}



}
