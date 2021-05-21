# Azure Filesystem Driver

This plugin adds a Filesystem driver for Azure Blob Storage.

It adds a custom Service Provider for Azure and adds the
`thixpin/azure-blob-storage` composer package.

## Using the Azure driver

Simply add another `disk` in `filesystems.php`.

You will need your Azure Blob account name, API key and container name.

```php
'disks' => [
    'azure' => [
        'driver' => 'azure',
        'account' => 'my-azure-account',
        'key' => 'my-api-key',
        'container' => 'my-container-name'
        'blob_service_url' => 'my-blob-service-url',
    ]
]
```

You can create as many disks as you want.

This is the flock from 
```https://github.com/pvaass/octobercms-azurefiledriver```