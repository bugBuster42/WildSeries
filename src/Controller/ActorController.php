<?php

namespace App\Controller;

use App\Repository\ActorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActorController extends AbstractController
{
    #[Route('/actor/{id}', name: 'actor_show')]
    public function show(int $id, ActorRepository $actorRepository): Response
    {
        $actor = $actorRepository->find($id);

        if (!$actor) {
            throw $this->createNotFoundException('Actor not found');
        }

        $actorName = $actor->getName();
        $programs = $actor->getPrograms();

        return $this->render('actor/show.html.twig', [
            'actorName' => $actorName,
            'programs' => $programs,
        ]);
    }
}
