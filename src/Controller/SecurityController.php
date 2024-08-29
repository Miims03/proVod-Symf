<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class SecurityController extends AbstractController
{

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path:'/api/login', methods: ['POST'])]
    public function apiLogin(AuthenticationUtils $authenticationUtils, Request $request): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        $username = $data['username'];
        $password = $data['password'];

        if($username && $password){
            $error = 
            $lastUsername = $username;
        }else{
            $error = $authenticationUtils->getLastAuthenticationError();
            $lastUsername = null;
        }

        // Construire une réponse JSON
        $data = [
            'last_username' => $lastUsername,
            'error' => $error
        ];

        // Si une erreur d'authentification existe, on renvoie une réponse 401 (Unauthorized)
        if ($error) {
            return new JsonResponse($data, JsonResponse::HTTP_UNAUTHORIZED);
        }

        // Sinon, on renvoie simplement une réponse 200 avec les données
        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
