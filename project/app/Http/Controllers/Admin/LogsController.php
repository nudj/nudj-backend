<?php namespace App\Http\Controllers\Admin;



use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class LogsController extends AdminController {


	public function __construct()
	{

	}

	public function index()
	{
		$this->middleware('auth');
		return view('admin/page/logs');
	}

	public function getLines()
	{
			if(!Request::ajax())
				return['success' => false];

			$lines = Input::get('lines') ?: 1;
			$adaptive = Input::get('adaptive') ?: true;
			$type = Input::get('type') ?: 'requests';
			$date = Input::get('date') ?: date('Y-m-d');

			$filePath = storage_path('logs/' . $type . '-' . $date . '.log');

			// exec('findstr /c: "id" ' . $filePath, $return);

			// Open file
			$f = @fopen($filePath, "rb");

			if ($f === false)
				return['success' => false];

			// Sets buffer size
			if (!$adaptive)
				$buffer = 4096;
			else
				$buffer = ($lines < 2 ? 64 : ($lines < 10 ? 512 : 4096));

			// Jump to last character
			fseek($f, -1, SEEK_END);

			// Read it and adjust line number if necessary
			// (Otherwise the result would be wrong if file doesn't end with a blank line)
			if (fread($f, 1) != "\n")
				$lines -= 1;

			// Start reading
			$output = '';
			$chunk = '';

			// While we would like more
			while (ftell($f) > 0 && $lines >= 0) {

				// Figure out how far back we should jump
				$seek = min(ftell($f), $buffer);

				// Do the jump (backwards, relative to where we are)
				fseek($f, -$seek, SEEK_CUR);

				// Read a chunk and prepend it to our output
				$output = ($chunk = fread($f, $seek)) . $output;

				// Jump back to where we started reading
				fseek($f, -mb_strlen($chunk, '8bit'), SEEK_CUR);

				// Decrease our line counter
				$lines -= substr_count($chunk, "\n");

			}

			// While we have too many lines
			// (Because of buffer size we might have read too many)
			while ($lines++ < 0) {

				// Find first newline and remove all text before that
				$output = substr($output, strpos($output, "\n") + 1);

			}

			// Close file and return
			fclose($f);

			$result = explode("\n", trim($output));
			$result = array_map(function($arr) {
				return json_decode($arr);
			}, $result);

			return Response::json($result);
	}


}
