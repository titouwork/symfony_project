<?php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Season;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProgramController extends AbstractController
{
    #[Route('/program/', name: 'program_index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render('program/showProgram.html.twig', [
            'programs' => $programs,
        ]);
    }

    #[Route('/program/{id<^[0-9]+$>}', name: 'program_show')]
    public function show(int $id, ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $id . ' found in program\'s table.'
            );
        }
        return $this->render('program/showProgram.html.twig', [
            'program' => $program,
        ]);
    }

    #[Route('/program/{programId}/seasons/{seasonId}', name: 'season_show')]
    public function showSeason(int $seasonId, SeasonRepository $seasonRepository, int $programId, ProgramRepository $programRepository): Response
    {
        $seasonId = $seasonRepository->findOneBy(['id' => $seasonId]);
        $programId = $programRepository->findOneBy(['id' => $programId]);

        if (!$seasonId) {
            throw $this->createNotFoundException(
                'No season with id : ' . $seasonId . ' found in season\'s table.'
            );
        }
        if (!$programId) {
            throw $this->createNotFoundException(
                'No program with id : ' . $programId . ' found in program\'s table.'
            );
        }
        return $this->render(
            'category/saison/showSeason.html.twig',
            [
                'programId' => $programId,
                'seasonId' => $seasonId,
            ]
        );
    }

    #[Route('/{programId}/season/{seasonId}/episode/{episodeId}', name: 'episode_show')]
    public function showEpisode(int $episodeId, EpisodeRepository $episodeRepository, int $seasonId, SeasonRepository $seasonRepository, int $programId, ProgramRepository $programRepository): Response
    {
        $episode = $episodeRepository->findOneBy(['id' => $episodeId]);
        $program= $programRepository->findOneBy(['id' => $programId]);
        $season = $seasonRepository->findOneBy(['id' => $seasonId]);

        if (!$episodeId) {
            throw $this->createNotFoundException(
                'No episode with id : ' . $episodeId . ' found in program\'s table.'
            );
        }
        return $this->render(
            'category/saison/episode/showEpisode.html.twig',
            [
                'episode' => $episode,
                'program' => $program,
                'season' => $season,
                 
            ]
        );
    }
}
