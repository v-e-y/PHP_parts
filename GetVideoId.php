<?php

namespace EventBundle\Traits;
// TODO: add Vimeo.

/**
 *  Допоміжні функції для обробкі введених користувачем данних.
 *  Наприклад: отримання id відео з наданного юзером посилання на відео, отримання id з посилання 
 *  twitter or instagram.
 */
trait GetVideoId
{
    // TODO: Мабуть цю перевірку потрібно перенести до перевірки у формі.
    /*
    * This function chek link for work. 
    * Return link if link is good or eroor.
    */
    public function islinkWork($userInputLink)
    {
        if ($userInputLink) {
            $userInputLink = trim($userInputLink);
            if(checkdnsrr($userInputLink,'A') && get_headers($userInputLink, 1)){
                return $userInputLink;
            } else {
                throw new \Exception('You url is wrong or link returns with error!');
            }
        } else {
            throw new \Exception('Empty link! Please add link.');
        }
    }


    /**
    * Get video id from yotube link.
    * Return string like "HUZOKvYcx_o".
    */
    public function getVideoIdFromYoutubeLink($linkToVideoFromYotube)
    {
        use GetVideoId;
        $linkToVideoFromYotube = islinkWork($linkToVideoFromYotube);
        // Yotube link exemple: 
        // https://www.youtube.com/watch?v=HUZOKvYcx_o&index=11&list=PLDxTqP1zRCnnIVWFqewuyDA541FMVccUC
        if ($linkToVideoFromYotube) {
            // get url request, url string with out host
            $urlParse = parse_url($linkToVideoFromYotube, PHP_URL_QUERY);
            // make the string to parts
            parse_str($urlParse, $urlParts);
            // Write parts v
            $videoIdOnYoutube = $urlParts['v'] || false;

            return $videoIdOnYoutube;
        }
        throw new \Exception('Some error with link.');
    }
}
