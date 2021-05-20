<?php namespace Pvaass\AzureFileDriver\Provider;


use League\Flysystem\AzureBlobStorage\AzureBlobStorageAdapter;
use League\Flysystem\Filesystem;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\ServiceException;
use Pvaass\AzureFileDriver\Exception\AzureStorageException;

class AzureServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const REQUIRED_CONFIG = ['account', 'key', 'container'];

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
                new AzureBlobStorageAdapter($blobRestProxy, $config['container'])
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