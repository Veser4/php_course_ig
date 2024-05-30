<?php 

namespace App\Repository;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\SchemaTool;



class UserRepository
{
    private EntityRepository $repository;
    public function __construct(private EntityManagerInterface $entityManager) {
        $this->repository = $entityManager->getRepository(User::class);
    }
    
    public function findById(int $id) : ?User {
        return $this->repository->findOneBy(['id' => (string) $id]);
    }

    public function store(User $user) : int {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user->getUserId();
    } 
     
    public function delete(User $user) {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function getAllUsers() : array {
        return $this->repository->findAll();
    }
}