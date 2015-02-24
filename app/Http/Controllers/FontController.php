<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Filesystem\Filesystem;

use Chumper\Zipper\Zipper;

use App\Font;

class FontController extends Controller {

	public function __construct(){
		chdir(base_path());
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Font $fonts, Filesystem $fs)
	{
		return view('font/index')->withFonts($fonts->all());
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

	protected $fontsDirectory = 'public/webfonts';

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Font $font, Request $request, Zipper $Zipper, Filesystem $fs)
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
				$fileExtension = $file->getClientOriginalExtension();
				$file->move($this->fontsDirectory ."/$name/fonts","_$name.$fileExtension");

				if ( ! $fs->exists($this->fontsDirectory ."/$name/css")) {
					$fs->makeDirectory($this->fontsDirectory ."/$name/css");
				}
				$style = view('fontface')->withName($name);

				$fs->put($this->fontsDirectory ."/$name/css/$name.css", $style);
				$example = view('example', [
					'name' => $name,
					'fileExtension' => $fileExtension
				]);
				$fs->put($this->fontsDirectory ."/$name/example.html", $example);

				if ($fs->exists($this->fontsDirectory ."/$name/$name [fontface.ge].zip")) {
					$fs->delete($this->fontsDirectory ."/$name/$name [fontface.ge].zip");
				}
				$Zipper->make($this->fontsDirectory ."/$name/$name [fontface.ge].zip");
				$Zipper->add($this->fontsDirectory ."/$name");

				if ( ! $font->where('fontFamily', $name)->first()) {
					$font->fontFamily = $name;
					$font->save();
				}

			}
			return view('uploaded')->withFonts($fonts);
		}else{
			return "Error\n";
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Font $font
	 * @return Response
	 */
	public function show(Font $font, Filesystem $fs)
	{
		return view('uploaded')->withFonts([$font->fontFamily]);
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
