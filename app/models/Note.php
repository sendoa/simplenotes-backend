<?php
/**
 * Created by Qbikode Solutions.
 * User: sendoa
 * Date: 30/09/13
 * Time: 11:34
 */

class Note extends Eloquent
{
	public function user()
	{
		return $this->belongsTo('User');
	}

	public function toArray()
	{
		$resultArray = parent::toArray();

		if (isset($this->image_name)) {
			$resultArray['image_URL'] = URL::to('uploads') . '/' . $this->image_name;
		} else {
			$resultArray['image_URL'] = null;
		}

		// User's additional info
		$resultArray['user_data'] = User::find($this->user_id)->toArray();

		return $resultArray;
	}
}