# Azure Filesystem Driver

This plugin adds a Filesystem driver for Azure Blob Storage.

## Using the Azure driver

Simply add another `disk` in `filesystems.php`.

You will need your Azure Blob account name, API key and container name.

```
'disks' => [
    'azure' => [
        'driver' => 'azure',
        'account' => 'my-azure-account',
        'key' => 'my-api-key',
        'container' => 'my-container-name'
    ]
]
```

You can create as many disks as you want.