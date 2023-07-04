<?php
//src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Season;
use App\Entity\Episode;
use App\Entity\Program;
use App\Form\ProgramType;
use App\Service\ProgramDuration;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Mime\Email;
use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, ProgramRepository $programRepository, SluggerInterface $slugger, MailerInterface $mailer): Response
    {
        $program = new Program();
        // Create the form, linked with $category
        $form = $this->createForm(ProgramType::class, $program);
        // Get data from HTTP request
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($program->getTitle());
            $program->setSlug($slug);
            $programRepository->save($program, true);

            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to('thomaslavalade@gmail.com')
                ->subject('Une nouvelle série vient d\'être publiée !')
                ->html($this->renderView('Program/newProgramEmail.html.twig', ['program' => $program]));
            $mailer->send($email);

            $this->addFlash(
                'success',
                'La nouvelle série a bien été ajouté ;)'
            );
            return $this->redirectToRoute('program_index');
        }
        return $this->renderForm('program/new.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }



    #[Route('/show/{slug}', name: 'show')]
    public function show(Program $program, ProgramDuration $programDuration): Response
    {

        return $this->render('program/show.html.twig', [
            'program' => $program,
            'programDuration' => $programDuration->calculate($program)
        ]);
    }


    #[Route('/{program}/season/{season}', name: 'season_show')]

    public function showSeason(Program $program, Season $season): Response
    {

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,

        ]);
    }

    #[Route('/{program}/season/{season}/episode/{episode}', name: 'episode_show')]

    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {

        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,

        ]);
    }

    #[Route('/{slug}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Program $program, ProgramRepository $programRepository): Response
    {
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $programRepository->save($program, true);

            $this->addFlash(
                'success',
                'La série a bien été modifiée ;)'
            );

            return $this->redirectToRoute('program_show', ['slug' => $program->getSlug()]);
        }

        return $this->renderForm('program/edit.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{slug}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Program $program, ProgramRepository $programRepository, SeasonRepository $seasonRepository, EpisodeRepository $episodeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $program->getSlug(), $request->request->get('_token'))) {
            $seasons = $program->getSeasons();
            foreach ($seasons as $season) {
                $episodes = $season->getEpisodes();
                foreach ($episodes as $episode) {
                    $episodeRepository->remove($episode, true);
                }
                $seasonRepository->remove($season, true);
            }

            $programRepository->remove($program, true);

            $this->addFlash(
                'success',
                'La série a bien été supprimée ;)'
            );
        }

        return $this->redirectToRoute('program_index');
    }
}
