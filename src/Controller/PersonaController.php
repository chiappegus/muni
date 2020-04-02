<?php

namespace App\Controller;

use App\Entity\Persona;
use App\Form\PersonaType;
use App\Repository\PersonaRepository;
use App\Service\UploaderHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/persona")
 */
class PersonaController extends AbstractController
{
    /**
     * @Route("/", name="persona_index", methods={"GET"})
     */
    public function index(PersonaRepository $personaRepository): Response
    {
        return $this->render('persona/index.html.twig', [
            'personas'           => $personaRepository->findAll(),
            'nombre_controlador' => 'PersonaController',
        ]);
    }

    /**
     * @Route("/new", name="persona_new", methods={"GET","POST"})

     */
    function new (Request $request, PersonaRepository $personaRepository, UploaderHelper $uploaderHelper): Response {
//dd($em);
        //
        //
        //
        //

        if (!isset($_GET["persona"])) {

            $persona = new Persona();
        } else {
            $user    = $_GET["persona"];
            $persona = $personaRepository->find($user);

        }

        //dd($user);

        //  dd( $personaRepository->find($user));

        //dd($this->getDoctrine()->getManager());
        //dd($intendente);
        /*
        if ( is_null($persona)) {

        }*/

        //$persona = new Persona();

        //$persona= $pepe;
        $form = $this->createForm(PersonaType::class, $persona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /*==============================
            =            images            =
            ==============================*/

            // dd($form['imageFile']->getData());

            //dd($form['imageFile']->getData());
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['imageFile']->getData();
            if ($uploadedFile) {
                $newFilename = $uploaderHelper->uploadArticleImage($uploadedFile);

                $persona->setImageFilename($newFilename);
            }
            /*=====  End of images  ======*/

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($persona);
            $entityManager->flush();

            return $this->redirectToRoute('persona_index');
        }

        return $this->render('persona/new.html.twig', [
            'persona' => $persona,
            'form'    => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="persona_show", methods={"GET"})
     */
    public function show(Persona $persona): Response
    {
        return $this->render('persona/show.html.twig', [
            'persona' => $persona,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="persona_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Persona $persona, UploaderHelper $uploaderHelper): Response
    {
        $form = $this->createForm(PersonaType::class, $persona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /*==============================
            =            images            =
            ==============================*/

            // dd($form['imageFile']->getData());

            //dd($form['imageFile']->getData());
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['imageFile']->getData();
            if ($uploadedFile) {
                $newFilename = $uploaderHelper->uploadArticleImage($uploadedFile);

                $persona->setImageFilename($newFilename);
            }
            /*=====  End of images  ======*/

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('persona_index');
        }

        return $this->render('persona/edit.html.twig', [
            'persona' => $persona,
            'form'    => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="persona_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Persona $persona): Response
    {
        if ($this->isCsrfTokenValid('delete' . $persona->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($persona);
            $entityManager->flush();
        }

        return $this->redirectToRoute('persona_index');
    }
}
