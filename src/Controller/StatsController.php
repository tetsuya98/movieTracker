<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\OrderFilter;
use App\Form\Type\MovieType;
use App\Form\Type\EditMovieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use DateTime;

class StatsController
{
    public function calculStats(Request $request) {
        $movies = $this->getDoctrine()->getRepository(Movie::class)->findAll();
        $stats= array();
        $cpt = 0;
        foreach($movies as $movie) {
            
        }
    }

}