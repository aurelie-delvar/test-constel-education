<?php

namespace App\Controller;

use App\Entity\Mentor;
use App\Entity\Star;
use App\Repository\MentorRepository;
use App\Repository\StarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    /**
     * @Route("/star/add", name="app_star_add", methods={"POST"})
     */
    public function add(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, MentorRepository $mentorRepository, EntityManagerInterface $doctrine): JsonResponse
    {
        // ce que je veux faire : 
        // 1. Récupérer le contenu Json 
        // 2. Le désérializer
        // 3. Retrouver l'id du mentor concerné
        // 4. Lui set son "hasStar" à true
        // 5. Retourner une validation avec une 201

        // on récupère le json de la requête du front avec Request
        $jsonContent = $request->getContent();
        dump($jsonContent); // on reçoit un id de mentor et un id de student (de star)

        // j'utilise le try/catch pour essayer d'ajouter l'étoile, sinon renvoyer une erreur
        try {

            // il faut désérializer le contenu Json, grâce au composant Serializer de Symfony
            // on veut convertir le contenu en entité
            $jsonStar = $serializer->deserialize($jsonContent, Star::class, 'json');
            dump($jsonStar);

            // je veux récupérer l'id du mentor à partir du contenu reçu
            $mentorId = $jsonStar->getMentor()->getId();
            // dump($mentorId);

            // à partir de l'id récupéré, je cherche le mentor
            $mentor = $mentorRepository->find($mentorId);

            // j'ai crée une propriété booléenne "hasStar" sur l'entité mentor, je veux la mettre à true :
            $mentor->setHasStar(true);

        } catch (\Throwable $e) {

            // si le try n'a pas fonctionné, je veux renvoyer une 422
            return $this->json(
                $e->getMessage(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );

        }

        // je valide le contenu $jsonStar avec le composant Validator
        $listError = $validator->validate($jsonStar);

        // s'il y a au moins 1 erreur, je les indique et retourne une 422
        if (count($listError) > 0) {

            return $this->json(
                $listError,
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        // j'ajoute en BDD
        $doctrine->persist($jsonStar);
        $doctrine->flush();

        return $this->json(['message' => 'Etoile ajoutée'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/star/remove/{id}", name="app_star_remove", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete(Mentor $mentor): JsonResponse
    {      
        // je mets la propriété à false  
        $mentor->setHasStar(false);

        // je renvoie une réponse
        return $this->json(
            null,
            Response::HTTP_NO_CONTENT
        );
    }
}
