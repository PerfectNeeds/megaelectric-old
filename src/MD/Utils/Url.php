<?php

namespace MD\Utils;

class Url {
    /*
     * @version      : 1
     * @author       : Peter Nassef <peter.nassef@gmail.com>
     * @Description  : return youtube thumbnail
     * @param        : type $youtubeUrl
     */

    public static function youtubeThumbnail($youtubeUrl) {
        $params = array();
        $queryString = parse_url($youtubeUrl, PHP_URL_QUERY);
        parse_str($queryString, $params);
        return 'http://img.youtube.com/vi/' . $params['v'] . '/default.jpg';
//        return 'http://img.youtube.com/vi/' . $params['v'] . '/0.jpg';
    }

}
