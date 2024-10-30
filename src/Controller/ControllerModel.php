<?php 

namespace App\Controller;

use App\Entity\Model;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ControllerModel
{
    public function __invoke(Request $request, EntityManagerInterface $entityManager, Model $model): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $model = new Model();
        // s'assurer avoir une valeur par défaut
        $model->setTitre($data['titre'] ?? null);
        $model->setTekno($data['tekno'] ?? null);
        $model->setDescription($data['description'] ?? null);

       

        $entityManager->persist($model);
        $entityManager->flush();


    

      
        return new JsonResponse(['message' => 'Custom logic executed'], 200);
    }
}