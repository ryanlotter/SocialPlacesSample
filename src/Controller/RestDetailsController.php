<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RestDetailsController extends AbstractController
{
    /**
     * @Route("/rest", name="rest")
    */
     public function index() {
      return $this->render('restdetails.html.twig');
     }
}