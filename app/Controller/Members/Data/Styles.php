<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Members\Data {

    use Minute\Model\CollectionEx;

    class Styles {

        public function index(CollectionEx $styles) {
            header('Content-type: application/javascript');

            return $styles->toJson();
        }
    }
}