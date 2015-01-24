<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('as' => 'home', function()
{

	return View::make('home');
}));

Route::post('/', array('as' => 'home', function()
{
	$files = Input::file('files');
	$fontsMap = array();
	$filePathsStr = '';
	foreach ($files as $key => $file) {
		$fontsMap[ $file->getRealPath() ] = $key;
		$filePathsStr .= " " . $file->getRealPath();
	}
	$json = shell_exec("fontforge -script font.py$filePathsStr");
	$result = json_decode($json, true);
	if ($result['status'] = 1) {
		$fonts = array();
		foreach ($result['converted'] as $key => $name) {
			$file = $files[ $fontsMap[$key] ];
			$fonts[] = $name;
			$ext = $file->getClientOriginalExtension();
			$file->move("webfonts/$name/fonts","original.$ext");
			if (!file_exists("webfonts/$name/css")) {
				mkdir("webfonts/$name/css");
			}
			$style = View::make('fontface')->withName($name);
			file_put_contents("webfonts/$name/css/$name.css", $style);
			$example = View::make('example', array(
				'name' => $name,
				'ext' => $ext
			));
			file_put_contents("webfonts/$name/example.html", $example);
			if (file_exists("webfonts/$name/$name [cotne.com].zip")) {
				unlink("webfonts/$name/$name [cotne.com].zip");
			}
			Zipper::make("webfonts/$name/$name [cotne.com].zip")->add(glob("webfonts/$name"));
		}
		return View::make('uploaded')->withFonts($fonts);
	}else{
		return "Error\n";
	}
}));
