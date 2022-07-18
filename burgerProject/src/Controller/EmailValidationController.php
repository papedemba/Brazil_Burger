<?php

namespace App\Controller;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmailValidationController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }
    public function __invoke(EntityManagerInterface $entityManager,Request $request, UserRepository $userRepository)
    {
        $token = $request->get("token");
        $user = $userRepository->findOneBy(["token" => $token]);

        if (!$user) {
            return new JsonResponse(["error" => "token inexistant "], Response::HTTP_BAD_REQUEST);
        }
        if ($user->isIsActivate()) {
            return new JsonResponse(["error" => "compte active deja"], Response::HTTP_BAD_REQUEST);
        }
        if ($user-> getExpiredAt()<new \DateTime()) {

            return new JsonResponse(["error" => "token expiré"], Response::HTTP_BAD_REQUEST);
        }
        $user->setIsActivate(true);
        $entityManager->flush();
        return new JsonResponse(["message" => "compte actif"], Response::HTTP_OK);

    }
}
