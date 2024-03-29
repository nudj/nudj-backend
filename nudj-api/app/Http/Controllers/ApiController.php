<?php namespace App\Http\Controllers;

use App\Events\IncomingRequestEvent;
use App\Events\ReturnResponseEvent;
use App\Utility\Facades\Shield;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;

class ApiController extends \Illuminate\Routing\Controller {

	protected $timestamp;
	protected $statusCode = 200;

	protected $defaults = ['limit' => 10];
	protected $limit;

	protected $nonTokenMethods = [
		'App\Http\Controllers\UsersController@store',
		'App\Http\Controllers\UsersController@verify',
		'App\Http\Controllers\UsersController@exists',
		'App\Http\Controllers\CountriesController@index',
		'App\Http\Controllers\ServicesController@test'
	];

	function __construct()
	{

		if(env('LOGGING')) {
			Event::fire(new IncomingRequestEvent());
		}

		if(!in_array(Request::route()->getActionName(), $this->nonTokenMethods)) {
			Shield::validate();
		}

		$this->limit = Request::get('limit') ?: $this->defaults['limit'];

	}

	public function getStatusCode()
	{
		return $this->statusCode;
	}

	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;

		return $this;
	}

	
	// ---------------------------------------------------------------------------
	// uuid: 641f86e1-5fd6-412e-92e3-38603cd8ceb0
	// Note: This function returns the id of the current user.
    // The given parameter $id could be null of equal to 'me'
    // In either case, the current user id needs to be extracted by Shield::getUserId()
	public function getPreparedId($id)
	{
		return (!$id || $id == 'me') ? Shield::getUserId() : $id;
	}

	
	// ---------------------------------------------------------------------------

	public function returnResponse($data, $headers = [])
	{

		if(env('LOGGING')) {
			Event::fire(new ReturnResponseEvent($data));
		}

		if(Config::get('cfg.request_timestamp'))
			$data['timestamp'] = Request::server('REQUEST_TIME_FLOAT');

		return Response::json($data, $this->getStatusCode(), $headers);
	}

	public function respondWithId($id, $status = true, $data = null)
	{
		return $this->respondWithStatus($status, ['id' => $id]);
	}

	public function respondWithStatus($status = true, $data = null)
	{
		$response['status'] = (bool) $status;

		if($data)
			$response['data'] = $data;

		return $this->returnResponse($response);
	}

	public function respondWithItem($item, $transformer)
	{
		return $this->returnResponse([
			'data' => $transformer->transform($item)
		]);
	}

	public function respondWithItems($items, $transformer)
	{
		return $this->returnResponse([
			'data' => $transformer->transformCollection($items),
			'count' => count($items)
		]);
	}

	public function respondWithPagination(Paginator $items, $transformer)
	{
		$items->appends(Request::all())->render();

		$baseUrl = URL::to('/');

		$response = [
			'data' => $transformer->transformCollection($items),
			'pagination' => [
				'total'    => $items->total(),
				'count'    => $items->count(),
				'next'     => $items->nextPageUrl() ? str_replace($baseUrl,'',$items->nextPageUrl()) : false,
				'previous' => $items->previousPageUrl() ? str_replace($baseUrl,'',$items->previousPageUrl()) : false,
			]
		];

		return $this->returnResponse($response);
	}

	public function respondWithError($message = null)
	{
		return $this->returnResponse([
			"error" => [
				"message"     => $message,
				"status_code" => $this->getStatusCode()
			]
		]);
	}

}