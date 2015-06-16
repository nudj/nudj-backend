<?php namespace App\Utility;

use League\Flysystem\Exception;
use OpenCloud\Rackspace;

class CloudHelper
{

    protected $client;

    public function __construct($auth = array())
    {

        try {
            $client = new Rackspace(Rackspace::UK_IDENTITY_ENDPOINT, [
                'username' => $auth['username'],
                'apiKey' => $auth['apiKey']
            ]);

            $this->client = $client->objectStoreService('cloudFiles', $auth['location'], 'publicURL');

        } catch (Exception $e) {
            throw new ApiException(new ApiExceptionType::$RACKSPACE_ERROR);
        }
    }

    public function save($filename, $source, $container)
    {

        if(is_array($container))
            $container = implode('/', $container);

        try {
            $container = $this->client->getContainer($container);
        } catch (Exception $e) {
            throw new ApiException(new ApiExceptionType::$RACKSPACE_ERROR);
        }

        try {
            $file = $container->uploadObject($filename, file_get_contents($source));
        } catch (Exception $e) {
            throw new ApiException(new ApiExceptionType::$RACKSPACE_ERROR);
        }

        return $file->getName();
    }

}