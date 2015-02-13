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

	$basePath = base_path();
	$json = shell_exec("fontforge -script \"{$basePath}/font.py\"$filePathsStr");
	$result = json_decode($json, true);

	if ($result['status'] = 1) {
		$fonts = array();
		foreach ($result['converted'] as $key => $name) {
			$file = $files[ $fontsMap[$key] ];
			$fonts[] = $name;
			$ext = $file->getClientOriginalExtension();
			$file->move("public/webfonts/$name/fonts","original.$ext");
			if (!file_exists("public/webfonts/$name/css")) {
				mkdir("public/webfonts/$name/css");
			}
			$style = View::make('fontface')->withName($name);
			file_put_contents("public/webfonts/$name/css/$name.css", $style);
			$example = View::make('example', array(
				'name' => $name,
				'ext' => $ext
			));
			file_put_contents("public/webfonts/$name/example.html", $example);
			if (file_exists("public/webfonts/$name/$name [cotne.com].zip")) {
				unlink("public/webfonts/$name/$name [cotne.com].zip");
			}
			Zipper::make("public/webfonts/$name/$name [cotne.com].zip")->add(glob("public/webfonts/$name"));
		}
		return View::make('uploaded')->withFonts($fonts);
	}else{
		return "Error\n";
	}
}));
