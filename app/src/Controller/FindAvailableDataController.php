<?php

namespace App\Controller;

use App\Repository\FileDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class FindAvailableDataController extends AbstractController
{
    #[Route('/find/available/data', name: 'app_find_available_data')]
    public function index(FileDataRepository $fileDataRepository, SerializerInterface $serializer): JsonResponse
    {
        $jsonContent = $serializer->serialize($fileDataRepository->findOneBy(['id' => 1]), 'json', [
            AbstractObjectNormalizer::SKIP_NULL_VALUES => true
            // 'groups' => ['input']
        ]);
        return JsonResponse::fromJsonString($jsonContent);
    }
}
