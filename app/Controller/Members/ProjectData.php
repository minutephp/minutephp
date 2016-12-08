<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Members {

    use Minute\Config\Config;
    use Minute\Error\ProjectError;
    use Minute\Model\CollectionEx;
    use Minute\Session\Session;
    use StringTemplate\Engine;

    class ProjectData {
        /**
         * @var Config
         */
        private $config;
        /**
         * @var Session
         */
        private $session;
        /**
         * @var Engine
         */
        private $engine;

        /**
         * ProjectData constructor.
         *
         * @param Config $config
         * @param Session $session
         * @param Engine $engine
         */
        public function __construct(Config $config, Session $session, Engine $engine) {
            $this->config  = $config;
            $this->session = $session;
            $this->engine  = $engine;
        }

        public function index(CollectionEx $projects) {
            if ($project = $projects->first()) {
                $lengths    = ['trial' => 30, 'starter' => 3 * 60, 'business' => 5 * 60, 'power' => 15 * 60];
                $max_length = 30;

                asort($lengths);

                foreach ($lengths as $level => $duration) {
                    if ($this->session->hasAccess($level)) {
                        $max_length = $duration;
                        break;
                    }
                }

                $defaults = ['max_length' => $max_length, 'free' => !$this->session->isTrialAccount()];
                $info     = ['upgrade_msg' => "This was only a preview.\n\nClick here to download the full video!", 'upgrade_link' => '{host}/pricing'];
                $upgrade  = $this->config->get('/private/upgrade', $info);
                $metadata = array_merge($defaults, $this->engine->render($upgrade, $this->config->getPublicVars()));

                return sprintf('{"project": %s, "metadata": %s}', $project->data_json ?: 'null', json_encode($metadata));
                //return json_encode(['project' => $data]);
            }

            throw new ProjectError("Access denied");
        }
    }
}