<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller {

    use Minute\Routing\RouteEx;
    use Minute\TTS\TTSManager;
    use Minute\View\Helper;
    use Minute\View\View;

    class Test {
        /**
         * @var TTSManager
         */
        private $manager;

        /**
         * Test constructor.
         *
         * @param TTSManager $manager
         */
        public function __construct(TTSManager $manager) {
            $this->manager = $manager;
        }

        public function index() {
            $voices = $this->manager->getVoices();

            return (new View('', ['san' => [1, 2, 3]]));
        }
    }
}