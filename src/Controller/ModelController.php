<?php

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Entity\Model;
use App\Form\ModelType;
use App\Repository\ModelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/model')]
final class ModelController extends AbstractController
{
    #[Route(name: 'api_model_index', methods: ['GET'])]
    public function index(ModelRepository $modelRepository, SerializerInterface $serializer): JsonResponse
    {
        $model = $modelRepository->findAll();
        $json = $serializer->serialize($model, 'json');
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/new', name: 'api_model_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $model = new Model();
        // s'assurer avoir une valeur par défaut
        $model->setTitre($data['titre' ?? null]);
        $model->setTekno($data['tekno' ?? null]);
        $model->setDescription($data['description' ?? null]);

       

        $entityManager->persist($model);
        $entityManager->flush();

        // Sérialisation et réponse JSON
        $json = $serializer->serialize($model, 'json');

        return new JsonResponse($json, Response::HTTP_CREATED, [], true);
    }

    #[Route('/{id}', name: 'api_model_show', methods: ['GET'])]
    public function show(Model $model,SerializerInterface $serializer): JsonResponse
    {
        $json=$serializer->serialize($model,'json');
        return new JsonResponse($json,Response::HTTP_OK,[],true);

    }

    #[Route('/{id}/edit', name: 'api_model_edit', methods: ['PUT'])]
    public function edit(Request $request, Model $model, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
       $data=json_decode($request->getContent(),true);
       $model->setTitre($data['titre' ?? null]);
       $model->setTekno($data['tekno' ?? null]);
       $model->setDescription($data['description' ?? null]);


       $entityManager->flush();

       $json = $serializer->serialize($model, 'json');

       return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'api_model_delete', methods: ['DELETE'])]
    public function delete(Request $request, Model $model, EntityManagerInterface $entityManager): JsonResponse
    {
   
        $entityManager->remove($model);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
