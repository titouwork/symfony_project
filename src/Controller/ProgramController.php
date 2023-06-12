<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/program')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'program_index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render('program/showProgram.html.twig', [
            'programs' => $programs,
        ]);
    }

    #[Route('/new', name: 'new_program')]
    public function new(Request $request, MailerInterface $mailer, ProgramRepository $programRepository): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $programRepository->save($program, true);

            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to('your_email@example.com')
                ->subject('Une nouvelle série vient d\'être publiée !')
                ->html($this->renderView('Program/newProgramEmail.html.twig', ['program' => $program]));

            $mailer->send($email);

            return $this->redirectToRoute('list_index');
        }

        return $this->render('program/newProgram.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'program_show')]
    public function show(Program $program): Response
    {
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $id . ' found in program\'s table.'
            );
        }
        return $this->render('program/showProgram.html.twig', [
            'program' => $program,
        ]);
    }

    #[Route('/program/{program}/seasons/{season}', name: 'season_show')]
    public function showSeason(Season $season, Program $program): Response
    {
        if (!$season) {
            throw $this->createNotFoundException(
                'No season with id : ' . $season . ' found in season\'s table.'
            );
        }
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $program . ' found in program\'s table.'
            );
        }
        return $this->render(
            'category/saison/showSeason.html.twig',
            [
                'program' => $program,
                'season' => $season,
            ]
        );
    }

    #[Route('/{program}/season/{season}/episode/{episode}', name: 'episode_show')]
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        if (!$episode) {
            throw $this->createNotFoundException(
                'No episode with id : ' . $episode . ' found in program\'s table.'
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
