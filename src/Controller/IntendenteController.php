<?php

namespace App\Controller;

use App\Entity\Intendente;
use App\Form\IntendenteType;
use App\Repository\IntendenteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/intendente")
 */
class IntendenteController extends AbstractController
{
    /**
     * @Route("/", name="intendente_index", methods={"GET"})
     */
    public function index(IntendenteRepository $intendenteRepository): Response
    {
        return $this->render('intendente/index.html.twig', [
            'intendentes' => $intendenteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="intendente_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $intendente = new Intendente();
        $form = $this->createForm(IntendenteType::class, $intendente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($intendente);
            $entityManager->flush();

            return $this->redirectToRoute('intendente_index');
        }

        return $this->render('intendente/new.html.twig', [
            'intendente' => $intendente,
            'form' => $form->createView(),
        ]);
        die();
    }

    /**
     * @Route("/{id}", name="intendente_show", methods={"GET"})
     */
    public function show(Intendente $intendente): Response
    {
        return $this->render('intendente/show.html.twig', [
            'intendente' => $intendente,
        ]);
         die();
    }

    /**
     * @Route("/{id}/edit", name="intendente_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Intendente $intendente): Response
    {
        $form = $this->createForm(IntendenteType::class, $intendente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('intendente_index');
        }

        return $this->render('intendente/edit.html.twig', [
            'intendente' => $intendente,
            'form' => $form->createView(),
        ]);
         die();
    }

    /**
     * @Route("/{id}", name="intendente_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Intendente $intendente): Response
    {
        if ($this->isCsrfTokenValid('delete'.$intendente->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($intendente);
            $entityManager->flush();
        }

        return $this->redirectToRoute('intendente_index');
         die();
    }
}
