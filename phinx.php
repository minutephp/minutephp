<?php

namespace Phinx {

    require_once('vendor/autoload.php');

    use App\Config\BootLoader;
    use Minute\Database\Database;

    class PhinxLoader {
        /**
         * @var Database
         */
        private $database;

        /**
         * PhinxLoader constructor.
         *
         * @param Database $database
         */
        public function __construct(Database $database) {
            $this->database = $database;
        }

        public function getConfiguration() {
            $conn  = ['environments' => ['default_database' => 'dev', "default_migration_table" => "m_phinx_logs",
                                         'dev' => ['name' => $this->database->getDsn()['database'], 'connection' => $this->database->getPdo()]]];
            $paths = ['paths' => ['migrations' => __DIR__ . '/db/migrations']];

            return array_merge($paths, $conn);
        }
    }

    /** @var PhinxLoader $phinxLoader */
    $bootLoader  = new BootLoader();
    $injector    = $bootLoader->getInjector();
    $phinxLoader = $injector->make('Phinx\PhinxLoader');

    return $phinxLoader->getConfiguration();
}