<?php namespace SoeThura\AzureFileDriver;

use SoeThura\AzureFileDriver\Provider\AzureServiceProvider;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'Azure Blob Filesystem Driver',
            'description' => 'Driver for Microsoft Azure Blob Storage (Flock from pvaass\'s Azure Filesystem Driver)',
            'author' => 'SoeThura',
            'icon' => 'icon-cloud'
        ];
    }

    public function boot() {
        \App::register(AzureServiceProvider::class);
    }
}
