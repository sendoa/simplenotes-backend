<?php

class NotesController extends \BaseController
{
	/**
	 * Create a new note
	 *
	 * @return Response
	 */
	public function create()
	{
		$id          = Str::random(20);
		$userId      = Input::get('user_id');
		$textContent = Input::get('text_content');

		// Error checking
		$validator = Validator::make(
			Input::all(),
			array(
				'user_id'      => 'required|exists:users,id',
				'text_content' => 'required',
				'image'        => 'mimes:jpeg,png'
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

		// Upload the image (if present)
		$errors       = array();
		$newFileName = null;
		if (Input::hasFile('image')) {
			$extension    = Input::file('image')->getClientOriginalExtension();
			$originalName = Str::slug(Input::file('image')->getClientOriginalName());
			$newFileName  = Str::random(5) . '-' . $originalName . '.' . $extension;
			Input::file('image')->move(public_path() . '/uploads', $newFileName);
		}

		// Save the new note
		$newNote               = new Note();
		$newNote->id           = $id;
		$newNote->user_id      = $userId;
		$newNote->text_content = $textContent;
		$newNote->image_name   = $newFileName;
		$result = $newNote->save();

		if ($result) {
			$response = array(
				'result' => 'OK',
				'code'   => '200'
			);
			return Response::json($response, 200);
		} else {
			$response = array(
				'error_message' => 'Server error when saving the note to the database',
				'code'          => '500'
			);
			return Response::json($response, 500);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		$note = Note::find($id);
		if (empty($note)) {
			$response = array(
				'error_message' => "Note with id '{$id}' doesn't exist",
				'code'          => '400'
			);
			return Response::json($response, 400);
		}

		// Remove image
		if (!empty($note->image_name)) {
			$imageFilePath = public_path() . '/uploads/' . $note->image_name;
			File::delete($imageFilePath);
		}

		// Remove database entry
		$note->delete();

		// Response
		$response = array(
			'result' => 'OK',
			'code'   => '200'
		);
		return Response::json($response, 200);
	}
}