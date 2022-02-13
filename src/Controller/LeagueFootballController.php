<?php

namespace App\Controller;

use App\Service\HttpRequestMaker;
use App\Service\HttpResponseFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LeagueFootballController extends AbstractController
{
    

    /**
     * @Route("/", name="league_home_index")
     */
    public function index(): Response
    {
        return  $this->render('home/index.html.twig');
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
     * @Route("/classement", name="league_result_standing")
     */
    public function standings( HttpRequestMaker $httpRequestMaker): Response
    {
        $query =   [
            'league' => '61',
            'season' => '2021'];
        $response = $httpRequestMaker->get('/standings', $query);
        return  $this->render('league/classement.html.twig', [
            'results' => $response
        ]);
    }

     /**
     * @Route("/filter/{team}", name="league_filter_team")
     */
    public function filter( HttpRequestMaker $httpRequestMaker, $team)
    {
        $query =   [
            'search' => $team];
        $response = $httpRequestMaker->get('/teams', $query);
        return  $this->render('league/classement.html.twig', [
            'results' => $response
        ]);
    }
}
