<?php 
namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpResponseFormatter
{


public function formatStatics($response)
{
    $statics =[];
    if(!empty($response)){
            $res = (array)$response["response"][0];
            $teams =  (array) $res['teams'];
            $statics['teams']['home'] = $teams['home'];
            $statics['teams']['away'] =  $teams['away'];
            $statics['homeTeam'] = $res['statistics'][0];
            $statics['awayTeam'] = $res['statistics'][1];
            $score = (array)$res['goals'];
            $statics['score'] = $score;
            $events = (array)$res['events'];
            $statics['events'] = $events;
    }
    return $statics;
}

} 