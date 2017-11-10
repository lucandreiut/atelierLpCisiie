<?php

namespace App\Controllers;

use Respect\Validation\Validator as v;
use Cartalyst\Sentinel\Native\Facades\Sentinel as Sentinel;

class AuthController extends BaseController
{
    public function checkAuth() 
    {
        return Sentinel::check();
    }

    public function index($request, $response, $args)
    {
        if (Sentinel::check()) {
            return $response->withRedirect('lists');
        } else {
            return $response->withRedirect('login');            
        }  
    }

    public function inscription($request, $response, $args) 
    {
        $data = [];

        if ($request->isPost()) {
            $params = $request->getParams();
            $errors = [];

            if (! v::length(1, 255)->alpha('-éèçàùïô')->validate($params['name'])) {
                array_push($errors, "Le nom entré est invalide ou est trop long !");
            }

            if (! v::length(1, 255)->filterVar(FILTER_VALIDATE_EMAIL)->validate($params['email'])) {
                array_push($errors, "L'email entré est invalide !");                
            }

            if (! v::length(1, 50)->validate(params['password'])) {
                array_push($errors, "Le mot de passe entré est trop long !");
            }

            if (Sentinel::findByCredentials(["email" => $params["email"]])) {
                array_push($errors, "L'adresse email entrée est déjà utilisée !"); 
            }

            $data = [
                "errors" => $errors
            ];

            if (sizeof($errors) > 0) {
                return $this->container->view->render($response, 'inscription.twig', $data);
            }

            $user = Sentinel::registerAndActivate(
                [
                    "name" => $params["name"], 
                    "email" => $params["email"], 
                    "password" => $params["password"]
                ]
            );

            Sentinel::login($user);

            return $response->withRedirect("/lists");
        }

        return $this->container->view->render($response, 'inscription.twig');
    }

    public function login($request, $response, $args)
    {
        if (Sentinel::check()) {
            return $response->withRedirect('/lists');            
        }

        $data = [];
        
        if ($request->isPost()) {
            $params = $request->getParams();
            $errors = [];

            if (! v::length(1, 255)->filterVar(FILTER_VALIDATE_EMAIL)->validate($params['email'])) {
                array_push($errors, "L'email entré est invalide !");                
            }

            if (! v::length(1, 50)->validate($params['password'])) {
                array_push($errors, "Le mot de passe entré est trop long !"); 
            }
            
            $data = [
                "errors" => $errors
            ];

            if (sizeof($errors) > 0) {
                return $this->container->view->render($response, 'login.twig', $data);
            }

            $creds = [
                "email" => $params["email"],
                "password" => $params["password"]
            ];

            if ($user = Sentinel::findByCredentials($creds)) {
                Sentinel::login($user);
                return $response->withRedirect('lists'); 
            } else {
                array_push($errors, "Les informations renseignées ne correspondent à aucun compte !");

                $data = [
                    "errors" => $errors
                ];
                
                return $this->container->view->render($response, 'login.twig', $data);
            }
        }

        return $this->container->view->render($response, 'login.twig', $data);
    }

    public function logout($request, $response, $args)
    {
        if ($user = Sentinel::check()) {
            Sentinel::logout($user);            
        }

        return $response->withRedirect('/login');
    }
} 