<?php
// src/Controller/ProgramController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EpisodeRepository;


class EpisodeController extends AbstractController
{
    #[Route('/episode', name: 'episode_index')]
    public function index(EpisodeRepository $episodeRepository): Response
    {
        $episodes = $episodeRepository->findAll();

        return $this->render('category/saison/episode/index.html.twig', [
            'episodes' => $episodes,
        ]);
    }
    
}  