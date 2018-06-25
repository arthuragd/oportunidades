<?php
// src/Controller/WelcomeController.php
namespace App\Controller;
// ...
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WelcomeController extends Controller
{
    /**
     * @Route("/", name="welcome")
     */
    public function index()
    {
        return $this->render('/base.html.twig');
    }
}