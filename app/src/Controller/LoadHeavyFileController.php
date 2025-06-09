<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class LoadHeavyFileController extends AbstractController
{
    #[Route('/load/heavy/file', name: 'app_load_heavy_file')]
    public function index(ParameterBagInterface $params): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/LoadHeavyFileController.php',
            'parameters' => "ENUM"
        ]);
    }
}
