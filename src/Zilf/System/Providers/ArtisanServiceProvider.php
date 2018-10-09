<?php

namespace Zilf\System\Providers;

use Zilf\Console\Commands\ServeCommand;
use Zilf\Console\Scheduling\Schedule;
use Zilf\Support\ServiceProvider;
use Illuminate\Queue\Console\TableCommand;
use Illuminate\Auth\Console\AuthMakeCommand;
use Illuminate\Foundation\Console\UpCommand;
use Illuminate\Foundation\Console\DownCommand;
use Illuminate\Auth\Console\ClearResetsCommand;
use Illuminate\Cache\Console\CacheTableCommand;
use Illuminate\Foundation\Console\PresetCommand;
use Illuminate\Queue\Console\FailedTableCommand;
use Illuminate\Foundation\Console\AppNameCommand;
use Zilf\Console\Commands\JobMakeCommand;
use Illuminate\Database\Console\Seeds\SeedCommand;
use Illuminate\Foundation\Console\MailMakeCommand;
use Illuminate\Foundation\Console\OptimizeCommand;
use Illuminate\Foundation\Console\RuleMakeCommand;
use Illuminate\Foundation\Console\TestMakeCommand;
use Illuminate\Foundation\Console\EventMakeCommand;
use Illuminate\Foundation\Console\ModelMakeCommand;
use Illuminate\Foundation\Console\RouteListCommand;
use Illuminate\Foundation\Console\ViewClearCommand;
use Illuminate\Session\Console\SessionTableCommand;
use Illuminate\Foundation\Console\PolicyMakeCommand;
use Illuminate\Foundation\Console\RouteCacheCommand;
use Illuminate\Foundation\Console\RouteClearCommand;
use Zilf\Console\Scheduling\ScheduleRunCommand;
use Illuminate\Foundation\Console\ConfigCacheCommand;
use Illuminate\Foundation\Console\ConfigClearCommand;
use Illuminate\Foundation\Console\ConsoleMakeCommand;
use Illuminate\Foundation\Console\EnvironmentCommand;
use Illuminate\Foundation\Console\KeyGenerateCommand;
use Illuminate\Foundation\Console\RequestMakeCommand;
use Illuminate\Foundation\Console\StorageLinkCommand;
use Illuminate\Routing\Console\ControllerMakeCommand;
use Illuminate\Routing\Console\MiddlewareMakeCommand;
use Illuminate\Foundation\Console\ListenerMakeCommand;
use Illuminate\Foundation\Console\ProviderMakeCommand;
use Illuminate\Foundation\Console\ResourceMakeCommand;
use Illuminate\Foundation\Console\ClearCompiledCommand;
use Illuminate\Foundation\Console\EventGenerateCommand;
use Illuminate\Foundation\Console\ExceptionMakeCommand;
use Illuminate\Foundation\Console\VendorPublishCommand;
use Zilf\Console\Scheduling\ScheduleFinishCommand;
use Illuminate\Database\Console\Seeds\SeederMakeCommand;
use Illuminate\Foundation\Console\PackageDiscoverCommand;
use Illuminate\Database\Console\Migrations\MigrateCommand;
use Illuminate\Foundation\Console\NotificationMakeCommand;
use Illuminate\Database\Console\Factories\FactoryMakeCommand;
use Zilf\Queue\Console\WorkCommand as QueueWorkCommand;
use Illuminate\Database\Console\Migrations\MigrateMakeCommand;
use Illuminate\Notifications\Console\NotificationTableCommand;
use Zilf\Cache\Console\ClearCommand as CacheClearCommand;
use Zilf\Cache\Console\ForgetCommand as CacheForgetCommand;

use Zilf\Queue\Console\RetryCommand as QueueRetryCommand;
use Zilf\Queue\Console\ListenCommand as QueueListenCommand;
use Zilf\Queue\Console\RestartCommand as QueueRestartCommand;
use Zilf\Queue\Console\ListFailedCommand as ListFailedQueueCommand;
use Zilf\Queue\Console\FlushFailedCommand as FlushFailedQueueCommand;
use Zilf\Queue\Console\ForgetFailedCommand as ForgetFailedQueueCommand;

use Illuminate\Database\Console\Migrations\FreshCommand as MigrateFreshCommand;
use Illuminate\Database\Console\Migrations\ResetCommand as MigrateResetCommand;
use Illuminate\Database\Console\Migrations\StatusCommand as MigrateStatusCommand;
use Illuminate\Database\Console\Migrations\InstallCommand as MigrateInstallCommand;
use Illuminate\Database\Console\Migrations\RefreshCommand as MigrateRefreshCommand;
use Illuminate\Database\Console\Migrations\RollbackCommand as MigrateRollbackCommand;
use Zilf\System\Zilf;

class ArtisanServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        'serve' =>  'command.serve',
        'CacheClear' =>  'command.cache.clear',
        'JobMake' => 'command.job.make',
        'QueueFailed' => 'command.queue.failed',
        'QueueFlush' => 'command.queue.flush',
        'QueueForget' => 'command.queue.forget',
        'QueueListen' => 'command.queue.listen',
        'QueueRestart' => 'command.queue.restart',
        'QueueRetry' => 'command.queue.retry',
        'QueueWork' => 'command.queue.work',
        'ScheduleFinish' => ScheduleFinishCommand::class,
        'ScheduleRun' => ScheduleRunCommand::class,
        /*'CacheForget' => 'command.cache.forget',
        'ClearCompiled' => 'command.clear-compiled',
        'ClearResets' => 'command.auth.resets.clear',
        'ConfigCache' => 'command.config.cache',
        'ConfigClear' => 'command.config.clear',
        'Down' => 'command.down',
        'Environment' => 'command.environment',
        'KeyGenerate' => 'command.key.generate',
        'Migrate' => 'command.migrate',
        'MigrateFresh' => 'command.migrate.fresh',
        'MigrateInstall' => 'command.migrate.install',
        'MigrateRefresh' => 'command.migrate.refresh',
        'MigrateReset' => 'command.migrate.reset',
        'MigrateRollback' => 'command.migrate.rollback',
        'MigrateStatus' => 'command.migrate.status',
        'Optimize' => 'command.optimize',
        'PackageDiscover' => 'command.package.discover',
        'Preset' => 'command.preset',
        'QueueFailed' => 'command.queue.failed',
        'QueueFlush' => 'command.queue.flush',
        'QueueForget' => 'command.queue.forget',
        'QueueListen' => 'command.queue.listen',
        'QueueRestart' => 'command.queue.restart',
        'QueueRetry' => 'command.queue.retry',
        'QueueWork' => 'command.queue.work',
        'RouteCache' => 'command.route.cache',
        'RouteClear' => 'command.route.clear',
        'RouteList' => 'command.route.list',
        'Seed' => 'command.seed',
        'StorageLink' => 'command.storage.link',
        'Up' => 'command.up',
        'ViewClear' => 'command.view.clear',*/
    ];

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $devCommands = [

        /*'AppName' => 'command.app.name',
        'AuthMake' => 'command.auth.make',
        'CacheTable' => 'command.cache.table',
        'ConsoleMake' => 'command.console.make',
        'ControllerMake' => 'command.controller.make',
        'EventGenerate' => 'command.event.generate',
        'EventMake' => 'command.event.make',
        'ExceptionMake' => 'command.exception.make',
        'FactoryMake' => 'command.factory.make',
        'ListenerMake' => 'command.listener.make',
        'MailMake' => 'command.mail.make',
        'MiddlewareMake' => 'command.middleware.make',
        'MigrateMake' => 'command.migrate.make',
        'ModelMake' => 'command.model.make',
        'NotificationMake' => 'command.notification.make',
        'NotificationTable' => 'command.notification.table',
        'PolicyMake' => 'command.policy.make',
        'ProviderMake' => 'command.provider.make',
        'QueueFailedTable' => 'command.queue.failed-table',
        'QueueTable' => 'command.queue.table',
        'RequestMake' => 'command.request.make',
        'ResourceMake' => 'command.resource.make',
        'RuleMake' => 'command.rule.make',
        'SeederMake' => 'command.seeder.make',
        'SessionTable' => 'command.session.table',
        'Serve' => 'command.serve',
        'TestMake' => 'command.test.make',
        'VendorPublish' => 'command.vendor.publish',*/
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands(
            array_merge(
                $this->commands, $this->devCommands
            )
        );
    }

    /**
     * Register the given commands.
     *
     * @param  array $commands
     * @return void
     */
    protected function registerCommands(array $commands)
    {
        foreach (array_keys($commands) as $command) {
            call_user_func_array([$this, "register{$command}Command"], []);
        }

        $this->commands(array_values($commands));
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerAppNameCommand()
    {
        Zilf::$container->register(
            'command.app.name', function ($app) {
                return new AppNameCommand($app['composer'], $app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerAuthMakeCommand()
    {
        Zilf::$container->register(
            'command.auth.make', function ($app) {
                return new AuthMakeCommand;
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerCacheClearCommand()
    {
        Zilf::$container->register(
            'command.cache.clear', function ($app) {
                return new CacheClearCommand(Zilf::$container['cache'], Zilf::$container['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerCacheForgetCommand()
    {
        Zilf::$container->register(
            'command.cache.forget', function ($app) {
                return new CacheForgetCommand($app['cache']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerCacheTableCommand()
    {
        Zilf::$container->register(
            'command.cache.table', function ($app) {
                return new CacheTableCommand($app['files'], $app['composer']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerClearCompiledCommand()
    {
        Zilf::$container->register(
            'command.clear-compiled', function () {
                return new ClearCompiledCommand;
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerClearResetsCommand()
    {
        Zilf::$container->register(
            'command.auth.resets.clear', function () {
                return new ClearResetsCommand;
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerConfigCacheCommand()
    {
        Zilf::$container->register(
            'command.config.cache', function ($app) {
                return new ConfigCacheCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerConfigClearCommand()
    {
        Zilf::$container->register(
            'command.config.clear', function ($app) {
                return new ConfigClearCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerConsoleMakeCommand()
    {
        Zilf::$container->register(
            'command.console.make', function ($app) {
                return new ConsoleMakeCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerControllerMakeCommand()
    {
        Zilf::$container->register(
            'command.controller.make', function ($app) {
                return new ControllerMakeCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerEventGenerateCommand()
    {
        Zilf::$container->register(
            'command.event.generate', function () {
                return new EventGenerateCommand;
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerEventMakeCommand()
    {
        Zilf::$container->register(
            'command.event.make', function ($app) {
                return new EventMakeCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerExceptionMakeCommand()
    {
        Zilf::$container->register(
            'command.exception.make', function ($app) {
                return new ExceptionMakeCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerFactoryMakeCommand()
    {
        Zilf::$container->register(
            'command.factory.make', function ($app) {
                return new FactoryMakeCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerDownCommand()
    {
        Zilf::$container->register(
            'command.down', function () {
                return new DownCommand;
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerEnvironmentCommand()
    {
        Zilf::$container->register(
            'command.environment', function () {
                return new EnvironmentCommand;
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerJobMakeCommand()
    {
        Zilf::$container->register(
            'command.job.make', function () {
                return new JobMakeCommand(Zilf::$container['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerKeyGenerateCommand()
    {
        Zilf::$container->register(
            'command.key.generate', function () {
                return new KeyGenerateCommand;
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerListenerMakeCommand()
    {
        Zilf::$container->register(
            'command.listener.make', function ($app) {
                return new ListenerMakeCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMailMakeCommand()
    {
        Zilf::$container->register(
            'command.mail.make', function ($app) {
                return new MailMakeCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMiddlewareMakeCommand()
    {
        Zilf::$container->register(
            'command.middleware.make', function ($app) {
                return new MiddlewareMakeCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateCommand()
    {
        Zilf::$container->register(
            'command.migrate', function ($app) {
                return new MigrateCommand($app['migrator']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateFreshCommand()
    {
        Zilf::$container->register(
            'command.migrate.fresh', function () {
                return new MigrateFreshCommand;
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateInstallCommand()
    {
        Zilf::$container->register(
            'command.migrate.install', function ($app) {
                return new MigrateInstallCommand($app['migration.repository']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateMakeCommand()
    {
        Zilf::$container->register(
            'command.migrate.make', function ($app) {
                // Once we have the migration creator registered, we will create the command
                // and inject the creator. The creator is responsible for the actual file
                // creation of the migrations, and may be extended by these developers.
                $creator = $app['migration.creator'];

                $composer = $app['composer'];

                return new MigrateMakeCommand($creator, $composer);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateRefreshCommand()
    {
        Zilf::$container->register(
            'command.migrate.refresh', function () {
                return new MigrateRefreshCommand;
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateResetCommand()
    {
        Zilf::$container->register(
            'command.migrate.reset', function ($app) {
                return new MigrateResetCommand($app['migrator']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateRollbackCommand()
    {
        Zilf::$container->register(
            'command.migrate.rollback', function ($app) {
                return new MigrateRollbackCommand($app['migrator']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateStatusCommand()
    {
        Zilf::$container->register(
            'command.migrate.status', function ($app) {
                return new MigrateStatusCommand($app['migrator']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerModelMakeCommand()
    {
        Zilf::$container->register(
            'command.model.make', function ($app) {
                return new ModelMakeCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerNotificationMakeCommand()
    {
        Zilf::$container->register(
            'command.notification.make', function ($app) {
                return new NotificationMakeCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerOptimizeCommand()
    {
        Zilf::$container->register(
            'command.optimize', function ($app) {
                return new OptimizeCommand($app['composer']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerPackageDiscoverCommand()
    {
        Zilf::$container->register(
            'command.package.discover', function ($app) {
                return new PackageDiscoverCommand;
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerPresetCommand()
    {
        Zilf::$container->register(
            'command.preset', function () {
                return new PresetCommand;
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerProviderMakeCommand()
    {
        Zilf::$container->register(
            'command.provider.make', function ($app) {
                return new ProviderMakeCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerQueueFailedCommand()
    {
        Zilf::$container->register(
            'command.queue.failed', function () {
                return new ListFailedQueueCommand;
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerQueueForgetCommand()
    {
        Zilf::$container->register(
            'command.queue.forget', function () {
                return new ForgetFailedQueueCommand;
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerQueueFlushCommand()
    {
        Zilf::$container->register(
            'command.queue.flush', function () {
                return new FlushFailedQueueCommand;
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerQueueListenCommand()
    {
        Zilf::$container->register(
            'command.queue.listen', function ($app) {
                return new QueueListenCommand(Zilf::$container['queue.listener']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerQueueRestartCommand()
    {
        Zilf::$container->register(
            'command.queue.restart', function () {
                return new QueueRestartCommand;
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerQueueRetryCommand()
    {
        Zilf::$container->register(
            'command.queue.retry', function () {
                return new QueueRetryCommand;
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerQueueWorkCommand()
    {
        Zilf::$container->register(
            'command.queue.work', function ($app) {
                return new QueueWorkCommand(Zilf::$container['queue.worker']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerQueueFailedTableCommand()
    {
        Zilf::$container->register(
            'command.queue.failed-table', function ($app) {
                return new FailedTableCommand($app['files'], $app['composer']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerQueueTableCommand()
    {
        Zilf::$container->register(
            'command.queue.table', function ($app) {
                return new TableCommand($app['files'], $app['composer']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerRequestMakeCommand()
    {
        Zilf::$container->register(
            'command.request.make', function ($app) {
                return new RequestMakeCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerResourceMakeCommand()
    {
        Zilf::$container->register(
            'command.resource.make', function ($app) {
                return new ResourceMakeCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerRuleMakeCommand()
    {
        Zilf::$container->register(
            'command.rule.make', function ($app) {
                return new RuleMakeCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerSeederMakeCommand()
    {
        Zilf::$container->register(
            'command.seeder.make', function ($app) {
                return new SeederMakeCommand($app['files'], $app['composer']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerSessionTableCommand()
    {
        Zilf::$container->register(
            'command.session.table', function ($app) {
                return new SessionTableCommand($app['files'], $app['composer']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerStorageLinkCommand()
    {
        Zilf::$container->register(
            'command.storage.link', function () {
                return new StorageLinkCommand;
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerRouteCacheCommand()
    {
        Zilf::$container->register(
            'command.route.cache', function ($app) {
                return new RouteCacheCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerRouteClearCommand()
    {
        Zilf::$container->register(
            'command.route.clear', function ($app) {
                return new RouteClearCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerRouteListCommand()
    {
        Zilf::$container->register(
            'command.route.list', function ($app) {
                return new RouteListCommand($app['router']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerSeedCommand()
    {
        Zilf::$container->register(
            'command.seed', function ($app) {
                return new SeedCommand($app['db']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerScheduleFinishCommand()
    {
        Zilf::$container->register(ScheduleFinishCommand::class, function (){
            return new ScheduleFinishCommand(new Schedule());
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerScheduleRunCommand()
    {
        Zilf::$container->register(ScheduleRunCommand::class, function (){
            $schedule = Zilf::$container->getShare(Schedule::class);
            return new ScheduleRunCommand($schedule);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerServeCommand()
    {
        Zilf::$container->register(
            'command.serve', function () {
                return new ServeCommand();
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerTestMakeCommand()
    {
        Zilf::$container->register(
            'command.test.make', function ($app) {
                return new TestMakeCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerUpCommand()
    {
        Zilf::$container->register(
            'command.up', function () {
                return new UpCommand;
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerVendorPublishCommand()
    {
        Zilf::$container->register(
            'command.vendor.publish', function ($app) {
                return new VendorPublishCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerViewClearCommand()
    {
        Zilf::$container->register(
            'command.view.clear', function ($app) {
                return new ViewClearCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerPolicyMakeCommand()
    {
        Zilf::$container->register(
            'command.policy.make', function ($app) {
                return new PolicyMakeCommand($app['files']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerNotificationTableCommand()
    {
        Zilf::$container->register(
            'command.notification.table', function ($app) {
                return new NotificationTableCommand($app['files'], $app['composer']);
            }
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array_merge(array_values($this->commands), array_values($this->devCommands));
    }
}
