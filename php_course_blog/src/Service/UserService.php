<?php 

    namespace App\Service;
    use App\Service\Data\UserData;
    use App\Repository\UserRepository;
    use App\Entity\User;


    class UserService implements UserServiceInterface
    {
        public function __construct(private UserRepository $repository)
        {
        }

        public function saveUser(string $firstName, string $lastName, ?string $middleName, string $gender, string $birthDate, string $email, ?string $phone, ?string $avatarPath): int
        {
            $user = new User(
                null,
                $firstName,
                $lastName,
                $middleName,
                $gender,
                $birthDate,
                $email,
                $phone,
                $avatarPath,
            );
            return $this->repository->store($user);
        }
   
        public function getUser(int $userId): UserData
        {
            $user = $this->repository->findById($userId);
            return ($user === null) ? null : new UserData(
                $userId,
                $user->getFirstName(),
                $user->getLastName(),
                $user->getMiddleName(),
                $user->getGender(),
                $user->getBirthDate(),
                $user->getEmail(),
                $user->getPhone(),
                $user->getAvataPath(),
            );

        }

        public function deleteUser(int $userId): void
        {
            $user = $this->repository->findById($userId);
            if ($user === null)
            {
                return;
            }
            $this->repository->delete($user);
        }

        public function listUsers(): array
        {
            return $this->repository->getAllUsers();
        }
    }