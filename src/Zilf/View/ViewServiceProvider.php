<?php

namespace Zilf\View;

use function Clue\StreamFilter\fun;
use Zilf\System\Zilf;
use Zilf\View\Engines\PhpEngine;
use Zilf\View\Engines\FileEngine;
use Zilf\View\Engines\CompilerEngine;
use Zilf\View\Engines\EngineResolver;
use Zilf\View\Compilers\BladeCompiler;

class ViewServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFactory();

        $this->registerViewFinder();

        $this->registerEngineResolver();
    }

    /**
     * Register the view environment.
     *
     * @return void
     */
    public function registerFactory()
    {
        Zilf::$container->register('view',function (){
            // Next we need to grab the engine resolver instance that will be used by the
            // environment. The resolver will be used by an environment to get each of
            // the various engine implementations such as plain PHP or Blade engine.
            $resolver = Zilf::$container->getShare('view.engine.resolver');

            $finder = Zilf::$container->getShare('view.finder');

            $factory = $this->createFactory($resolver, $finder);

            // We will also set the container instance on this view environment since the
            // view composers may be classes registered in the container, which allows
            // for great testable, flexible composers for the application developer.
           /* $factory->setContainer($app);

            $factory->share('app', $app);*/

            return $factory;
        });
    }

    /**
     * Create a new Factory Instance.
     *
     * @param  \Zilf\View\Engines\EngineResolver  $resolver
     * @param  \Zilf\View\ViewFinderInterface  $finder
     * @return \Zilf\View\Factory
     */
    protected function createFactory($resolver, $finder)
    {
        return new Factory($resolver, $finder);
    }

    /**
     * Register the view finder implementation.
     *
     * @return void
     */
    public function registerViewFinder()
    {
        Zilf::$container->register('view.finder', function ($app) {
            return new FileViewFinder(Zilf::$container['files'], [Zilf::$app->resourcePath()]);
        });
    }

    /**
     * Register the engine resolver instance.
     *
     * @return void
     */
    public function registerEngineResolver()
    {
        Zilf::$container->register('view.engine.resolver', function () {
            $resolver = new EngineResolver;

            // Next, we will register the various view engines with the resolver so that the
            // environment will resolve the engines needed for various views based on the
            // extension of view file. We call a method for each of the view's engines.
            foreach (['file', 'php', 'blade'] as $engine) {
                $this->{'register'.ucfirst($engine).'Engine'}($resolver);
            }

            return $resolver;
        });
    }

    /**
     * Register the file engine implementation.
     *
     * @param  \Zilf\View\Engines\EngineResolver  $resolver
     * @return void
     */
    public function registerFileEngine($resolver)
    {
        $resolver->register('file', function () {
            return new FileEngine;
        });
    }

    /**
     * Register the PHP engine implementation.
     *
     * @param  \Zilf\View\Engines\EngineResolver  $resolver
     * @return void
     */
    public function registerPhpEngine($resolver)
    {
        $resolver->register('php', function () {
            return new PhpEngine;
        });
    }

    /**
     * Register the Blade engine implementation.
     *
     * @param  \Zilf\View\Engines\EngineResolver  $resolver
     * @return void
     */
    public function registerBladeEngine($resolver)
    {
        // The Compiler engine requires an instance of the CompilerInterface, which in
        // this case will be the Blade compiler, so we'll first create the compiler
        // instance to pass into the engine so it can compile the views properly.
        Zilf::$container->register('blade.compiler', function () {

            return new BladeCompiler(
                Zilf::$container['files'],Zilf::$app->runtimePath().'/views'
            );

        });

        $resolver->register('blade', function () {
            return new CompilerEngine(Zilf::$container['blade.compiler']);
        });
    }
}
