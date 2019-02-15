<?php

namespace Nbs\Theme\Providers;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;
use Superbalist\Flysystem\GoogleStorage\GoogleStorageAdapter;

class GoogleStorageServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $factory = $this->app->make('filesystem');

        $factory->extend('gcs', function ($app, $config) {
            $storageClient = new StorageClient([
                'projectId' => $config['project_id'],
                'keyFilePath' => base_path($config['key_file']),
            ]);
            $bucket = $storageClient->bucket($config['bucket']);
            $pathPrefix = $config['path_prefix'];
            $storageApiUri = $config['storage_api_uri'];

            $adapter = new GoogleStorageAdapter($storageClient, $bucket, $pathPrefix, $storageApiUri);

            return $this->createFilesystem($adapter, $config);
        });
    }

    /**
     * Create a Filesystem instance with the given adapter.
     *
     * @param  \League\Flysystem\AdapterInterface $adapter
     * @param  array $config
     * @return Filesystem
     */
    protected function createFilesystem(AdapterInterface $adapter, array $config)
    {
        $config = Arr::only($config, [
            'visibility',
            'disable_asserts',
            'url'
        ]);

        return new Filesystem($adapter, count($config) > 0 ? $config : null);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }
}
