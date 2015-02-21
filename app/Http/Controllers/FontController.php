<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

use Chumper\Zipper\Zipper;

class FontController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('font.create');
	}

	/**
	 * execute command
	 *
	 * @param  $directory path to execute command in
	 * @param  $command
	 * @return results Object
	 */
	protected function executeCommand($directory, $command) {
		$result = shell_exec('cd "'. $directory .'" && '. $command);
		return json_decode($result);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request, Zipper $Zipper)
	{
		$files = $request->file('files');
		$fontsMap = [];
		$filePathsStr = '';
		foreach ($files as $key => $file) {
			$fontsMap[ $file->getRealPath() ] = $key;
			$filePathsStr .= " " . $file->getRealPath();
		}

		$result = $this->executeCommand(base_path(), "fontforge -script font.py$filePathsStr");

		if ($result->status == 1) {
			$fonts = array();
			foreach ($result->converted as $key => $name) {
				$file = $files[ $fontsMap[$key] ];
				$fonts[] = $name;
				$ext = $file->getClientOriginalExtension();
				$file->move("public/webfonts/$name/fonts","original.$ext");
				if (!file_exists("public/webfonts/$name/css")) {
					mkdir("public/webfonts/$name/css");
				}
				$style = view('fontface')->withName($name);
				file_put_contents("public/webfonts/$name/css/$name.css", $style);
				$example = view('example', array(
					'name' => $name,
					'ext' => $ext
				));
				file_put_contents("public/webfonts/$name/example.html", $example);
				if (file_exists("public/webfonts/$name/$name [cotne.com].zip")) {
					unlink("public/webfonts/$name/$name [cotne.com].zip");
				}
				$Zipper->make("public/webfonts/$name/$name [cotne.com].zip");
				$Zipper->add(glob("public/webfonts/$name"));
			}
			return view('uploaded')->withFonts($fonts);
		}else{
			return "Error\n";
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
