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
        $model->setLien($data['lien'] ?? null);
        $model->setImageSrc($data['imageSrc'] ?? null);
        $model->setText1($data['text1'] ?? null);
        $model->setText2($data['text2'] ?? null);
        $model->setText3($data['text3'] ?? null);
        $model->setText4($data['text4'] ?? null);
        $model->setAlt($data['alt'] ?? null);
        $model->setVideo($data['video'] ?? null);

       

        $entityManager->persist($model);
        $entityManager->flush();


    

      
        return new JsonResponse(['message' => 'Custom logic executed'], 200);
    }
}