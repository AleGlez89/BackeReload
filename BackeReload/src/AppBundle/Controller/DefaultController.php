<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/getFiles", name="file_manager_get_files")
     * @Method({"GET"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getFilesAction(Request $request)
    {
        $FileManagerService = $this->get('manage.file.service');
        $folder = $FileManagerService->getFiles();

        return $this->fastJsonResponse($folder);
    }

    /**
     * @Route("/createFile", name="file_manager_create_file")
     * @Method({"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createFileAction(Request $request)
    {
        $ControlCreate = false;
        $FileManagerService = $this->get('manage.file.service');
        $file = $FileManagerService->createFile($request);

        if ($file)
        {
            $ControlCreate = true;
            return $this->fastJsonResponse($ControlCreate);
        }
        return $this->fastJsonResponse($ControlCreate);
    }

    /**
     * @Route("/moveFiles", name="file_manager_move_files")
     * @Method({"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function moveFilesAction(Request $request)
    {
        $FileManagerService = $this->get('manage.file.service');
        $Control = $FileManagerService ->moveFiles($request);
        return $this->fastJsonResponse($Control);
    }

    /**
     * @Route("/deleteFiles", name="file_manager_delete_files")
     * @Method({"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function deleteFilesAction(Request $request)
    {
        $FileManagerService = $this->get('manage.file.service');
        $Control = $FileManagerService ->deleteFiles($request);
        return $this->fastJsonResponse($Control);
    }

    /**
     * Returns a fast new json response
     * @param  mixed   $response
     * @param  integer  $status HTTP Status code
     * @return Response
     */
    public function fastJsonResponse($response, $status = 200)
    {
        return new Response(
            json_encode($response),
            $status,
            [
                'Content-Type'                => 'application/json'
            ]
        );
    }
}
