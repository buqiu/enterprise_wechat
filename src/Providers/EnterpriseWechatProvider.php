<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Providers;

use Buqiu\EnterpriseWechat\Commands\CacheClearCommand;
use Buqiu\EnterpriseWechat\Commands\CustomerGenerateCommand;
use Buqiu\EnterpriseWechat\Commands\CustomerSyncCommand;
use Buqiu\EnterpriseWechat\Commands\CustomerTagSyncCommand;
use Buqiu\EnterpriseWechat\Commands\DeleteCommand;
use Buqiu\EnterpriseWechat\Commands\DepartmentSyncCommand;
use Buqiu\EnterpriseWechat\Commands\ListCommand;
use Buqiu\EnterpriseWechat\Commands\RegisterCommand;
use Buqiu\EnterpriseWechat\Commands\UpdateCommand;
use Buqiu\EnterpriseWechat\Commands\UserResignSyncCommand;
use Buqiu\EnterpriseWechat\Commands\UserSyncCommand;
use Buqiu\EnterpriseWechat\Services\EnterpriseWechatService;
use Composer\InstalledVersions;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Finder\Finder;

class EnterpriseWechatProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     */
    protected bool $defer = true;

    /**
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $this->offerPublishing();

        $this->registerCommands();

        $this->registerAbout();
    }

    /**
     * @throws BindingResolutionException
     */
    protected function offerPublishing(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        if (! function_exists('config_path')) {
            // function not available and 'publish' not relevant in Lumen
            return;
        }

        foreach (iterator_to_array(
            Finder::create()->files()->in(__DIR__.'/../../database/migrations')->depth(0)->sortByChangedTime(),
            false) as $index => $file) {
            $this->publishes([$file->getRealPath() => $this->getMigrationFileName($file->getBasename(), $index)], 'enterprise_wechat-migrations');
        }
    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     *
     * @throws BindingResolutionException
     */
    protected function getMigrationFileName(string $migrationFileName, int $index = 0): string
    {
        $timestamp = date('Y_m_d_Hi').((int) date('s') + $index);

        $filesystem = $this->app->make(Filesystem::class);

        return Collection::make([$this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR])
            ->flatMap(fn ($path) => $filesystem->glob($path.'*_'.$migrationFileName))
            ->push($this->app->databasePath()."/migrations/{$timestamp}_{$migrationFileName}")
            ->first();
    }

    public function register(): void
    {
        $this->app->singleton(EnterpriseWechatService::class, function ($app) {
            return new EnterpriseWechatService($app);
        });

        $this->app->alias(EnterpriseWechatService::class, 'enterprise_wechat');
    }

    protected function registerCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            RegisterCommand::class,
            ListCommand::class,
            UpdateCommand::class,
            DeleteCommand::class,
            CacheClearCommand::class,
            CustomerGenerateCommand::class,
            CustomerSyncCommand::class,
            CustomerTagSyncCommand::class,
            DepartmentSyncCommand::class,
            UserSyncCommand::class,
            UserResignSyncCommand::class,
        ]);
    }

    protected function registerAbout(): void
    {
        if (! class_exists(InstalledVersions::class) || ! class_exists(AboutCommand::class)) {
            return;
        }

        AboutCommand::add('Enterprise Wechat', static fn () => [
            'Version' => InstalledVersions::getPrettyVersion('buqiu/enterprise_wechat'),
        ]);
    }
}
