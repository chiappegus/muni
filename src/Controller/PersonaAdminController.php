<?php

namespace App\Controller;

use App\Repository\PersonaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PersonaAdminController extends AbstractController
{
    /**
     * @Route("/admin/persona", name="persona_admin")
     */
    public function index(PersonaRepository $personaRepository, Request $request)
    {

        $q = $request->query->get('q');

        /* $personas = $personaRepository->findBy([], ['id' => 'DESC']);
        'personas'           => $personaRepository->findAll(),
        dump($personas);*/
        //$personas = $personaRepository->findBy([], ['id' => 'DESC']);

        //dump($this->getUser());
        return $this->render('persona_admin/index.html.twig', [
            'personas'           => //$personaRepository->findBy([], ['dni' => 'asc']),
            $personaRepository->findByDNI($q),
            'nombre_controlador' => 'PersonaController',
        ]);

    }

}
