<?php

namespace App\Controller;
use App\Entity\User;
use App\Service\ImageServiceInterface;
use App\Service\UserServiceInterface;
use App\View\PhpTemplateEngine;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    public function __construct( 
        private UserServiceInterface $userService, 
        private ImageServiceInterface $imageService
    ) 
    {
    }

    
    public function index(): Response
    {
        $allUsers = $this->userService->listUsers();
        return $this->render('main_page.html.twig', ['page_title' => 'MyTitle', 'users_list' => $allUsers]);
    }

    public function registerUser(Request $request): Response
    {
        try
        {
            $imagePath = (!empty($request->files->get('avatar_path'))) ? $this->imageService->moveImageToUploads($request->files->get('avatar_path')) : null;
            $userId = $this->userService->saveUser(
            $request->get('first_name'),
            $request->get('last_name'),
            $request->get('middle_name'),
            $request->get('gender'),
            $request->get('birth_date'),
            $request->get('email'),
            $request->get('phone'),
            $imagePath,
        );   
            return $this->redirectToRoute('show_user', ['user_id' => $userId], Response::HTTP_SEE_OTHER);
        }
        catch (\Exception $e) 
        {
            return $this->render('error_page.html.twig', ['error' => $e->getMessage()]);
        }
    }

    public function showUser(Request $request): Response
    {
        try 
        {
            $user = $this->userService->getUser($request->get('user_id'));
            if ($user) 
            {
                return $this->render('user.html.twig', ['user' => $user]);
            } 
            else
            {
                throw new \Exception('No such person');
            }
        }
        catch (\Exception $e)
        {
            return $this->render('error_page.html.twig', ['error' => $e->getMessage()]);
        }
    }

    public function deleteUser(Request $request) : Response
    {
        try 
        {
            $this->userService->deleteUser($request->get('user_id'));
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
        }
        return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
    }

    public function updateUser(Request $request)
    {
    }

}