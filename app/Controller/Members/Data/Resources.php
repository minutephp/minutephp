<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Members\Data {

    use App\Controller\Stock\Resource\Listing;
    use Minute\Config\Config;

    class Resources {
        const Key = 'buzzvid';
        /**
         * @var Listing
         */
        private $listing;
        /**
         * @var Config
         */
        private $config;

        /**
         * Resources constructor.
         *
         * @param Config $config
         * @param Listing $listing
         */
        public function __construct(Config $config, Listing $listing) {
            $this->listing = $listing;
            $this->config  = $config;
        }

        public function index() {
            $res  = $this->config->get(self::Key . '/resources', ['astons' => [], 'textFXs' => []]);
            $vids = $this->listing->getListing('videos');

            $res['bgs'] = array_filter($vids, function ($video) {
                return $video['category'] === 'loops';
            });

            return json_encode($res, JSON_PRETTY_PRINT);
        }
    }
}