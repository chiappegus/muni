<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PesonaAdminController extends AbstractController
{
    /**
     * @Route("/pesona/admin", name="pesona_admin")
     */
    public function index()
    {
        return $this->render('pesona_admin/index.html.twig', [
            'controller_name' => 'PesonaAdminController',
        ]);
    }
}
