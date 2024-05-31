<?php 

    namespace App\Service;
    use App\Service\Data\UserData;

    interface UserServiceInterface
{
    public function saveUser(string $firstName, string $lastName, ?string $middleName, string $gender, string $birthDate, string $email, ?string $phone, ?string $avatarPath): int;
   
    public function getUser(int $userId): UserData;

    public function deleteUser(int $userId): void;

    public function listUsers(): array;
}
