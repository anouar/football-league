<?php 
namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpResponseFormatter
{

/**
 * formatStatics
 *
 * @param [type] $response
 * @return array
 */
public function formatStatics($response):Array
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

/**
 * formatFilterResults
 *
 * @param [type] $response
 * @return array
 */
public function formatFilterResults($response):Array
{
    $teams = [];
    if(!empty($response)){
        $resulats = (array)$response["response"];
        if(count($resulats) > 0){
            foreach($resulats as $result){
                $teams[] = (array)$result->team;
            }
        }
     
    }
    return $teams;   
}

} 