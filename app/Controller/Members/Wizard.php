<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Members {

    use Minute\Routing\RouteEx;
    use Minute\View\Helper;
    use Minute\View\View;

    class Wizard {

        public function step (string $step) {
            return (new View("Members/Wizard/Step/$step", [], false));
        }
	}
}