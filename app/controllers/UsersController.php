<?php

class UsersController extends \BaseController {

	/**
	 * Get the notes from the user
	 *
	 * @param $id
	 *
	 * @return Response
	 */
	public function getNotes($id)
	{
		$user = User::find($id);
		if (empty($user)) {
			$response = array(
				'error_message' => 'The user doesn\'t exist',
				'code'          => '0404'
			);
			return Response::json($response, 404);
		}

		return Response::json($user->notes()->orderBy('created_at', 'desc')->get(), 200);
	}

	/**
	 * Check user's credentials
	 *
	 * @return Response
	 */
	public function login()
	{
		$email    = Input::get('email');
		$password = Input::get('password');

		if (Auth::attempt(array('email' => $email, 'password' => $password))) {
			$response = array(
				'result'    => 'OK',
				'code'      => '200',
				'user_data' => Auth::user()->toArray()
			);
			return Response::json($response, 200);
		} else {
			$response = array(
				'error_message' => 'Incorrect credentials',
				'code'          => '401'
			);
			return Response::json($response, 200);
		}
	}

	/**
	 * User crestion
	 *
	 * @return Response
	 */
	public function create()
	{
		$id       = Str::random(20);
		$email    = Input::get('email');
		$password = Input::get('password');
		$name     = Input::get('name');
		$lastname = Input::get('lastname');

		// Error checking
		$validator = Validator::make(
			Input::all(),
			array(
				'email'    => 'required|email|unique:users,email',
				'password' => 'required',
				'name'     => 'required',
				'lastname' => 'required'
			)
		);

		if ($validator->fails()) {
			$response = array(
				'error_message' => 'Error processing data',
				'code'          => '400',
				'errors'        => $validator->messages()->toArray()
			);
			return Response::json($response, 400);
		}

		// Save user
		$user           = new User();
		$user->id       = $id;
		$user->email    = $email;
		$user->password = Hash::make($password);
		$user->name     = $name;
		$user->lastname = $lastname;
		$result         = $user->save();

		if ($result) {
			$response = array(
				'result'    => 'OK',
				'code'      => '200',
				'user_data' => User::find($id)->toArray()
			);
			return Response::json($response, 200);
		} else {
			$response = array(
				'error_message' => 'Server error when saving new user to the database',
				'code'          => '500'
			);
			return Response::json($response, 500);
		}
	}

}