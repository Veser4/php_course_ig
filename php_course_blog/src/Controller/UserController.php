<?php

namespace App\Controller;
use App\Entity\User;
use App\Repository\UserRepository;
use App\View\PhpTemplateEngine;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    public function __construct( private UserRepository $userRepository) 
    {
    }

    
    public function index(): Response
    {
        $allUsers = $this->userRepository->getAllUsers();
        return $this->render('main_page.html.twig', ['page_title' => 'MyTitle', 'users_list' => $allUsers]);
    }

    public function registerUser(Request $request): Response
    {
        $file = $request->files->get('avatar_path');
        $type = ($file !== null) ? $file->getClientOriginalExtension() : null;
        if ((str_contains($type, 'png')) || (str_contains($type, 'jpg')) || (str_contains($type, 'gif')) || ($type == null)) 
        {
            $user = new User(
                null, 
                $request->get('first_name'),
                $request->get('last_name'),
                $request->get('middle_name') ?? null,
                $request->get('gender'),
                $request->get('birth_date'),
                $request->get('email'),
                $request->get('phone') ?? null,
                null,
            );
            try
            {
                $id = $this->userRepository->store($user);
                if ($type != null)
                {
                    $tmpFilePath = $file->getPathname();
                    $uploadRoot = "assets/avatar_";
                    move_uploaded_file($tmpFilePath, "{$uploadRoot}{$id}.{$type}");
                    $user->setAvataPath('avatar_' . $id . '.' . $type);
                    $this->userRepository->store($user);
                }
                return $this->redirectToRoute('show_user', ['user_id' => $id], Response::HTTP_SEE_OTHER);
            }
            catch (\Exception $e) 
            {
                return $this->render('error_page.html.twig', ['error' => $e->getMessage()]);

                //return $this->redirectToRoute('show_error', ['user_id' => $id], Response::HTTP_SEE_OTHER);
            }
        }
        else
        {
            return $this->render('error_page.html.twig', ['error' => 'Not available image type']);
        }
    }

    public function showUser(Request $request): Response
    {
        try 
        {
            $user = $this->userRepository->findById($request->get('user_id'));
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
            $user = $this->userRepository->findById($request->get('user_id'));
            $this->userRepository->delete($user);
            return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
        }
        return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
    }

    public function updateUser(Request $request) : Response
    {
        try 
        {
            $id = (int) $request->get('user_id');
            $currentUser = $this->userRepository->findById($id);
            $firstName = !empty($request->get('first_name')) ? $request->get('first_name') : $currentUser->getFirstName();
            $lastName = !empty($request->get('last_name')) ? $request->get('last_name') : $currentUser->getLastName();
            $middleName = !empty($request->get('middle_name')) ? $request->get('middle_name') : $currentUser->getMiddleName();
            $gender = !empty($request->get('gender')) ? $request->get('gender') : $currentUser->getGender();
            $birthDate = !empty($request->get('birth_date')) ? $request->get('birth_date') : $currentUser->getBirthDate();
            $email = !empty($request->get('email')) ? $request->get('email') : $currentUser->getEmail();
            $phone = !empty($request->get('phone')) ? $request->get('phone') : $currentUser->getPhone();
            // foreach ($request->request->all() as $key => $value)
            // {
            //     if (!empty($value)) {
            //         $this->table->updateUserDataById($key, $value, (int) $request->get('user_id'));
            //     }
            // }
            $file = $request->files->get('avatar_path');
            $type = ($file !== null) ? $file->getClientOriginalExtension() : null;
            if ($type != null)
            {
                $tmpFilePath = $file->getPathname();
                $uploadRoot = "assets/avatar_";
                move_uploaded_file($tmpFilePath, "{$uploadRoot}{$id}.{$type}");
                //$this->table->updateUserDataById('avatar_path', 'avatar_' . $id . '.' . $type, $id);
            }
            $avatarPath = $type != null ? 'avatar_' . $id . '.' . $type : $currentUser->getAvataPath();
            $currentUser->setUserId($id);
            $currentUser->setFirstName($firstName);
            $currentUser->setLastName($lastName);
            $currentUser->setMiddleName($middleName);
            $currentUser->setGender($gender);
            $currentUser->setBirthDate($birthDate);
            $currentUser->setEmail($email);
            $currentUser->setPhone($phone);
            $currentUser->setAvataPath($avatarPath);
            var_dump($currentUser);

            $this->userRepository->store($currentUser);

            return $this->redirectToRoute('show_user', [
                'user_id' => $id
            ], Response::HTTP_SEE_OTHER);
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
            return $this->render('error_page.html.twig', ['error' => $e->getMessage()]);
        } 
    }

}