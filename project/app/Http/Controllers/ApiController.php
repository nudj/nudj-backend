<?php namespace App\Http\Controllers;


use App\Events\IncomingRequestEvent;
use App\Utility\Authenticators\TokenAuthenticator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class ApiController extends \Illuminate\Routing\Controller {

	protected $timestamp;
	protected $statusCode = 200;

	protected $defaults = ['limit' => 10];
	protected $limit;

	protected $nonTokenMethods = [
		'App\Http\Controllers\UsersController@store',
		'App\Http\Controllers\UsersController@verify'
	];

	protected $authenticator = null;

	function __construct(TokenAuthenticator $authenticator)
	{

		if(Config::get('cfg.request_log')) {
			Event::fire(new IncomingRequestEvent('Incoming Request', [
				'timestamp' => Request::server('REQUEST_TIME_FLOAT'),
				'endpoint' => Request::server('REQUEST_METHOD') . ':' . Request::route()->getPath(),
				'body' => Request::all(),
				'user' => $this->authenticator ? $this->authenticator->getDigest() : null,
			]));
		}

		if(!in_array(Request::route()->getActionName(), $this->nonTokenMethods)) {
			$this->authenticator = $authenticator;
			$this->authenticator->validate();
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

	/* Helpers
	 * --------------------------------------------------------------------------- */

	public function getPreparedId($id)
	{
		return (!$id || $id == 'me') ? $this->authenticator->getUserId() : null;
	}

	/* Responses
	 * --------------------------------------------------------------------------- */

	public function returnResponse($data, $headers = [])
	{
		if(Config::get('cfg.request_timestamp'))
			$data['timestamp'] = Request::server('REQUEST_TIME_FLOAT');

		return Response::json($data, $this->getStatusCode(), $headers);
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

		$response = [
			'data' => $transformer->transformCollection($items),
			'pagination' => [
				'total' => $items->total(),
				'count' => $items->count(),
				'next' => $items->nextPageUrl() ?: false,
				'previous' => $items->previousPageUrl() ?: false,
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