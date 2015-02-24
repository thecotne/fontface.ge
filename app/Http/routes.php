<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::bind('font', function($fontFamily)
{
	$font = App\Font::where('fontFamily', $fontFamily)->first();
	if ($font) {
		return $font;
	} else {
		throw new NotFoundHttpException;
	}
});

Route::get('/', array('as' => 'home', function()
{
	return View::make('home');
}));

Route::resource('font', 'FontController');
