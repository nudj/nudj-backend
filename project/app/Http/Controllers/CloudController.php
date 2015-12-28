<?php namespace App\Http\Controllers;

use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\CloudHelper;
use App\Utility\Facades\Shield;
use Illuminate\Support\Facades\Config;

class CloudController extends ApiController
{

    protected $containers = ['UserImage'];

    public function emptyAllContainers()
    {
        if (!Shield::hasRole('admin'))
            throw new ApiException(ApiExceptionType::$UNAUTHORIZED);

        $cloudHelper = new CloudHelper(Config::get('cfg.rackspace'));

        echo "Begin emptying all containers ... <br/>";

        foreach ($this->containers as $container) {

            echo "Clearing container {$container} <br/>";
            $cloudHelper->emptyContainer($container);
        }

        echo "Finished emptying containers ... <br/>";
    }

}
