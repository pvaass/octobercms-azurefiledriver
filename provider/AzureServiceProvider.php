<?php namespace Thixpin\AzureFileDriver\Provider;


use Thixpin\Azure\BlobStorage\AzureBlobStorageAdapter;
use League\Flysystem\Filesystem;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\ServiceException;
use Thixpin\AzureFileDriver\Exception\AzureStorageException;

class AzureServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const REQUIRED_CONFIG = ['account', 'key', 'container', 'blob_service_url'];

    public function boot()
    {
        $this->addAzureDriver();
    }

    public function addAzureDriver()
    {
        \Storage::extend('azure', function ($app, $config) {
            $this->validateConfig($config);

            $endpoint = sprintf(
                'DefaultEndpointsProtocol=https;AccountName=%s;AccountKey=%s',
                $config['account'],
                $config['key']
            );

            $blobRestProxy = BlobRestProxy::createBlobService($endpoint);

            return new Filesystem(
                new AzureBlobStorageAdapter($blobRestProxy, $config['container'], $config['blob_service_url'])
            );
        });
    }

    protected function validateConfig($config)
    {
        $missingConfigs = array_diff_key(array_flip(static::REQUIRED_CONFIG), $config);
        if (sizeof($missingConfigs) > 0) {
            throw new AzureStorageException(
                'Missing required config value(s) for Azure driver: ' .
                implode(array_keys($missingConfigs), ",")
            );
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}