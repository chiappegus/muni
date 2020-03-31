<?php

namespace App\Controller;

use App\Repository\PersonaRepository;
use Gedmo\Sluggable\Util\Urlizer;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PersonaAdminController extends AbstractController
{
    /**
     * @Route("/admin/personaSINPAGINATOR", name="persona_adminSINPAGINATOR")
     */
    public function indexSINPAGINATOR(PersonaRepository $personaRepository, Request $request)
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

    #PaginatorInterface Knp\Component\Pager\PaginatorInterface
    #https://github.com/KnpLabs/KnpPaginatorBundle

    /**
     * @Route("/admin/persona", name="persona_admin")
     */
    public function index(PersonaRepository $personaRepository, Request $request, PaginatorInterface $paginator)
    {

        $q = $request->query->get('q');

        /* $personas = $personaRepository->findBy([], ['id' => 'DESC']);
        'personas'           => $personaRepository->findAll(),
        dump($personas);*/
        //$personas = $personaRepository->findBy([], ['id' => 'DESC']);

        //dump($this->getUser());
        //$personas    = $personaRepository->findByDNI($q);
        $queyBuilder = $personaRepository->getwithQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queyBuilder, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10/*limit per page*/
        );
        return $this->render('persona_admin/index.html.twig', [
            'pagination'         => //$personaRepository->findBy([], ['dni' => 'asc']),
            $pagination,
            'nombre_controlador' => 'PersonaController',
        ]);

    }

    /**
     * @Route("/admin/controlDni/{dni}", name="persona_admin_dni")
     */
    public function controlDni($dni, PersonaRepository $personaRepository, Request $request)
    {

        $persona = $personaRepository->findBy(['dni' => $dni]);

        //dump(isset($persona[0]));

        return new JsonResponse(['valor' => isset($persona[0])]);
        //die();
        /*

        $q = $request->query->get('q');

        /* $personas = $personaRepository->findBy([], ['id' => 'DESC']);
        'personas'           => $personaRepository->findAll(),
        dump($personas);*/
        //$personas = $personaRepository->findBy([], ['id' => 'DESC']);

        //dump($this->getUser());

        /*
    return $this->render('persona_admin/index.html.twig', [
    'personas'           => //$personaRepository->findBy([], ['dni' => 'asc']),
    $personaRepository->findByDNI($q),
    'nombre_controlador' => 'PersonaController',
    ]);
     */
    }

    public function UpcomingEvents(PersonaRepository $personaRepository, Request $request, PaginatorInterface $paginator)
    {

        $q = $request->query->get('q');

        $queyBuilder = $personaRepository->getwithQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queyBuilder, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10/*limit per page*/
        );
        return $this->render('persona_admin/cuadroBusqueda.html.twig', [
            'pagination'         => //$personaRepository->findBy([], ['dni' => 'asc']),
            $pagination,
            'nombre_controlador' => 'PersonaController',
        ]);

    }
    /**
     * @Route("/admin/actualizar/{dni}", name="andaTodoMal")
     */
    public function recentArticles($q = null, PersonaRepository $personaRepository, Request $request)
    {
        // make a database call or other logic
        // to get the "$max" most recent articlessetMaxResults(1)
        //$articles = ...;$entityManager->createQueryBuilder()->expr()->max($x);

        //https://symfony.com/doc/4.1/templating/embedding_controllers.html

        //https://stackoverflow.com/questions/42221356/simple-ajax-request-to-controller-symfony3

        //https://stackoverflow.com/questions/24446149/render-template-into-symfony2-with-ajax

        //https://stackoverflow.com/questions/24446149/render-template-into-symfony2-with-ajax

        if ($q == "") {
            //dump($q);
            $personas = $personaRepository->findBy([], ['id' => 'DESC'], 10, 0);

        } else {
            $personas = $personaRepository->findBy(['dni' => $q], ['id' => 'DESC'], 10, 0);

        }

        //$q = $request->query->get('q');
        //$q = $request->query->all();

        // $q = '26258210';

        // dd($q);
        //if (!$q == "") {
        //dd($q);
        //$personas = $personaRepository->findByDniINNER($q);

        return $this->render(
            'persona_admin/recent_list.html.twig',
            ['personas' => $personas]
        );
    }

    /**
     * @Route("/admin/arrayGus/{dni}", name="andaTodoMal")
     */
    public function arrayGus($dni = null, PersonaRepository $personaRepository, Request $request)
    {
        // make a database call or other logic
        // to get the "$max" most recent articlessetMaxResults(1)
        //$articles = ...;$entityManager->createQueryBuilder()->expr()->max($x);

        //https://symfony.com/doc/4.1/templating/embedding_controllers.html

        //https://stackoverflow.com/questions/42221356/simple-ajax-request-to-controller-symfony3

        //https://stackoverflow.com/questions/24446149/render-template-into-symfony2-with-ajax

        //https://stackoverflow.com/questions/24446149/render-template-into-symfony2-with-ajax

        if ($dni == "") {
            // dump($q);
            //$arrData = ['output' => 'here the result which will appear in div'];
            $personas = $personaRepository->findBy([], ['id' => 'DESC'], 10, 0);
            // return new JsonResponse($arrData);
            return $this->render(
                'persona_admin/recent_list.html.twig',
                ['personas' => $personas]
            );

        } else {
            //$personas = $personaRepository->findBy(['dni' => $dni]);
            $personas = $personaRepository->findBy(['dni' => $dni], ['id' => 'DESC'], 10, 0);

            if ($personas == null) {

                $personas = $personaRepository->findBy([], ['id' => 'DESC'], 10, 0);
                // return new JsonResponse($arrData);
                return $this->render(
                    'persona_admin/recent_list.html.twig',
                    ['personas' => $personas]
                );

            } else {

                // $arrData = ['output' => 'here the result which will appear in div'];
                $arrData = ['personas' => $personas];
                //$arrData = json_encode($personas);
                //return new JsonResponse($arrData);

                // return new JsonResponse([$arrData]);

                return $this->render(
                    'persona_admin/recent_list.html.twig',
                    ['personas' => $personas]
                );}
            // return new JsonResponse($arrData);

        }

    }

    /**
     * @Route("/admin/upload/test", name="upload_test")
     */
    public function temporaryUploadAction(Request $request)
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('image');

        /*=================================
        =            seguridad            =

        ejemplo
        5e82c8297868a_01.jpg
        para path para saber bien en donde esta

        ahora al reves 01_dasdaa_jpg
        se usa Urlizer por lo espacion
        =================================*/

        $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

        $newFileName = Urlizer::urlize($originalFileName) . '_' . uniqid() . '.' . $uploadedFile->guessExtension();

        /*=====  End of seguridad  ======*/

        // dd($request->files->get('image'));

        $destination = $this->getParameter('kernel.project_dir') . '/public/uploads';
        dd($uploadedFile->move($destination,
            $newFileName
        ));

    }

}
