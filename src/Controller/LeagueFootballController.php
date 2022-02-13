<?php

namespace App\Controller;

use App\Service\HttpRequestMaker;
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
            'season' => '2021'];
        $response = $httpRequestMaker->get('/fixtures', $query);

        return  $this->render('league/resut_calendar.html.twig', [
            'results' => $response
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
        dd($response);
        return  $this->render('league/classement.html.twig', [
            'results' => $response
        ]);
    }
}
