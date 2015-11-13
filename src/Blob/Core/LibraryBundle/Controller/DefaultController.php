<?php

namespace Blob\Core\LibraryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BlobCoreLibraryBundle:Default:index.html.twig');
    }
}
