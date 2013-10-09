<?php
/**
 * Created by Qbikode Solutions.
 * User: sendoa
 * Date: 30/09/13
 * Time: 11:58
 */

class ApiKeysTableSeeder extends Seeder {
	public function run()
	{
		DB::table('api_keys')->delete();

		$api_key = new ApiKey();
		$api_key->id        = '55e76dc4bbae25b066cb';
		$api_key->email     = 'sendoa@gmail.com';
		$api_key->name      = 'Sendoa Portuondo';
		$api_key->active    = 1;
		$api_key->save();
	}
}