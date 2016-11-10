<?php
/**
 * Created by PhpStorm.
 * User: san
 * Date: 4/2/2016
 * Time: 6:13 AM
 */
namespace App\Config {

    use Auryn\Injector;
    use Illuminate\Database\Connection;
    use Minute\Cache\QCache;
    use Minute\Config\Config;
    use Minute\Database\Database;
    use Minute\Event\Binding;
    use Minute\Event\Dispatcher;
    use Minute\Http\HttpRequestEx;
    use Minute\Http\HttpResponseEx;
    use Minute\Log\LoggerEx;
    use Minute\Routing\Router;
    use Minute\Session\Session;
    use PDO;

    class BootLoader {
        protected $baseDir;
        /**
         * @var Injector
         */
        protected $injector;

        public function __construct() {
            $this->baseDir = realpath(__DIR__ . '/../../');
        }

        public function getBaseDir() {
            return $this->baseDir;
        }

        public function getInjector() {
            $this->injector = $injector = new Injector;

            $injector->share(Binding::class);
            $injector->share(BootLoader::class);
            $injector->share(Config::class);
            $injector->share(Database::class);
            $injector->share(Dispatcher::class);
            $injector->share(HttpRequestEx::class);
            $injector->share(HttpResponseEx::class);
            $injector->share(LoggerEx::class);
            $injector->share(QCache::class);
            $injector->share(Router::class);
            $injector->share(Session::class);
            $injector->share(Connection::class);
            $injector->share($injector);

            return $injector;
        }
    }
}