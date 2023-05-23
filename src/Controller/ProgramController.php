<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;

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
public function show(int $id, ProgramRepository $programRepository):Response
{
    $program = $programRepository->findOneBy(['id' => $id]);

    if (!$program) {
        throw $this->createNotFoundException(
            'No program with id : '.$id.' found in program\'s table.'
        );
    }
    return $this->render('program/showProgram.html.twig', [
        'program' => $program,
    ]);
}
}