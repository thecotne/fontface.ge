<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Filesystem\Filesystem;

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
	 * Execute command
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
	 * Generate array of RealPath and key
	 *
	 * @param  Array $files
	 * @return Array
	 */
	protected function simpleFilesArray(Array $files)
	{
		$array = [];
		foreach ($files as $key => $file) {
			$array[ $file->getRealPath() ] = $key;
		}
		return $array;
	}

	/**
	 * Implode array keys
	 *
	 * @param  $glue string
	 * @param  $pieces Array
	 * @return string
	 */
	protected function implodeArrayKeys($glue, Array $pieces)
	{
		return implode($glue, array_keys($array));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request, Zipper $Zipper, Filesystem $fs)
	{
		$files = $request->file('files');
		$fontsMap = $this->simpleFilesArray($files);

		$spaceSeperatedFilePaths = implode(' ', array_keys($fontsMap));

		$result = $this->executeCommand(base_path(), "fontforge -script font.py $spaceSeperatedFilePaths");

		if ($result->status == 1) {
			$fonts = [];
			foreach ($result->converted as $key => $name) {
				$file = $files[ $fontsMap[$key] ];
				$fonts[] = $name;
				$ext = $file->getClientOriginalExtension();
				$file->move("public/webfonts/$name/fonts","original.$ext");

				if ( ! $fs->exists("public/webfonts/$name/css")) {
					$fs->makeDirectory("public/webfonts/$name/css");
				}
				$style = view('fontface')->withName($name);

				$fs->put("public/webfonts/$name/css/$name.css", $style);
				$example = view('example', [
					'name' => $name,
					'ext' => $ext
				]);
				$fs->put("public/webfonts/$name/example.html", $example);

				if ($fs->exists("public/webfonts/$name/$name [cotne.com].zip")) {
					$fs->delete("public/webfonts/$name/$name [cotne.com].zip");
				}
				$Zipper->make("public/webfonts/$name/$name [cotne.com].zip");
				$Zipper->add("public/webfonts/$name");
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
