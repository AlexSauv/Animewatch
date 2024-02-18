<?php 
namespace   App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {
    #[Route('/', 'Home.index', methods: ['GET'])]
    public function index(): Response { return $this->render('pages/home.html.twig');}


}
