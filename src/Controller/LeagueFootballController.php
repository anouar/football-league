<?php

namespace App\Controller;

use App\Form\SearchTeamType;
use App\Service\HttpRequestMaker;
use App\Service\HttpResponseFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LeagueFootballController extends AbstractController
{
    /**
     * @Route("/", name="league_home_index")
     */
    public function index(Request $request, HttpRequestMaker $httpRequestMaker): Response
    {
        $form = $this->createForm(SearchTeamType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $team = $data['team'];
            $query =   [
                'name' => $team];
            $response = $httpRequestMaker->get('/teams', $query);
            if(!empty($response)){
                if(count($response->response)>0){
                    $team_infos = $response->response[0]->team;
                    $team_id = $team_infos->id;
                    $list_match_results = $httpRequestMaker->get('/fixtures', ['season'=> '2021', 'team' => $team_id]);
                    if(!empty($list_match_results)){
                        return  $this->render('league/resut_calendar.html.twig', [
                            'results' => $list_match_results
                        ]);
                    }
                }
            }
        }
        return  $this->render('home/index.html.twig', [
            'form' => $form->createView(), 
        ]);
    }

        /**
     * @Route("/resultat", name="league_result_calendar")
     */
    public function resultCalendar(HttpRequestMaker $httpRequestMaker): Response
    {
        $query =   [
            'league' => '61',
            'season' => '2021',
            'last' => '10'];
        $response = $httpRequestMaker->get('/fixtures', $query);
       
        return  $this->render('league/resut_calendar.html.twig', [
            'results' => $response
        ]);
    }

          /**
     * @Route("/match/detail/{id}", name="league_match_detail")
     */
    public function leagueMatchDetail(HttpRequestMaker $httpRequestMaker, HttpResponseFormatter $httpResponseFormatter,$id=0): Response
    {
        $query =   [
            'id' => $id];
        $response = $httpRequestMaker->get('/fixtures', $query);
        $responseFormatted = $httpResponseFormatter->formatStatics((array)$response);
  
        return  $this->render('league/match_detail.html.twig', [
            'results' => $responseFormatted
        ]);
    }

     /**
     * @Route("/filter/team", name="league_filter_team")
     */
    public function filter(Request $request, HttpRequestMaker $httpRequestMaker, HttpResponseFormatter $httpResponseFormatter)
    {
        $result = [];
        $teamQuery = $request->query->get('query');

        $query =   [
            'search' => $teamQuery];
        $response = $httpRequestMaker->get('/teams', $query);
        $responseFormatted = $httpResponseFormatter->formatFilterResults((array)$response);  
      
        foreach ($responseFormatted as $team){
            $result[] = [
                'team_id' => $team['id'],
                'team_name' => $team['name'],
            ];
        }
  
        return $this->json(['result' =>$result], 200, [], ['groups' => 'main']);
    }
}
