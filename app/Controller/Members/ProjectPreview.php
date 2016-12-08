<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Members {

    use Minute\Routing\RouteEx;
    use Minute\View\Helper;
    use Minute\View\Redirection;
    use Minute\View\View;

    class ProjectPreview {

        public function index (int $project_id) {
            return new Redirection("/swf2vid/player/$project_id");
        }
	}
}