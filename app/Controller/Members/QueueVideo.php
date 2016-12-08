<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Members {

    use App\Model\MProject;
    use Minute\Error\Swf2VidError;
    use Minute\Swf2Vid\Swf2Vid;

    class QueueVideo {
        /**
         * @var Swf2Vid
         */
        private $swf2vid;

        /**
         * QueueVideo constructor.
         *
         * @param Swf2Vid $swf2vid
         */
        public function __construct(Swf2Vid $swf2vid) {
            $this->swf2vid = $swf2vid;
        }

        public function index(int $project_id) {
            if ($project = MProject::find($project_id)) {
                $video = $this->swf2vid->queueProject($project);

                return json_encode(['video_id' => $video->video_id]);
            }

            throw new Swf2VidError("Unable to queue video");
        }
    }
}