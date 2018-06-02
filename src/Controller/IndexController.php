<?php

namespace App\Controller;

use App\Form\UploadType;
use App\Model\UploadModel;
use iio\libmergepdf\Merger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \iio\libmergepdf\Exception
     */
    public function index(Request $request): Response
    {
        $data = new UploadModel();
        $form = $this->createForm(UploadType::class, $data);
        $form->handleRequest($request);

        $errors = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $merger = new Merger();
            $filename = [];
            foreach ($data->getFiles() as $file) {
                if ($file->getUploadedFile()) {
                    $filename[] = basename(
                        $file->getUploadedFile()->getClientOriginalName(),
                        '.' . $file->getUploadedFile()->getClientOriginalExtension()
                    );
                    $merger->addFile($file->getUploadedFile());
                }
            }
            $createdPDF = $merger->merge();

            $response = new Response();
            $response->headers->set('Cache-Control', 'private');
            $response->headers->set('Content-type', 'application/pdf');
            $response->headers->set('Content-Disposition', 'attachment; filename="' . implode('_', $filename) . '.pdf";');
            $response->headers->set('Content-length', \strlen($createdPDF));
            $response->sendHeaders();
            $response->setContent($createdPDF);
            return $response;
        }

        if ($form->isSubmitted() && ! $form->isValid()) {
            $errors = $form->getErrors(true);
        }

        $data->reset();
        $form = $this->createForm(UploadType::class, $data);
        foreach ($errors as $error) {
            $form->addError($error);
        }

        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
