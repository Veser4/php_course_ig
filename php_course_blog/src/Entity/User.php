<?php 

namespace App\Entity;
use App\Entity\Image;

class User
{
    private ?Image $image;

    public function __construct(
        private ?int $id, private string $firstName, 
        private string $lastName, private ?string $middleName, 
        private string $gender, private string $birthDate,
        private string $email, private ?string $phone, private ?string $avatarPath)
    {
    }

    public function getUserId(): ?int
    {
        return $this->id;
    }

    public function setUserId($id)
    {
        $this->id = $id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getMiddleName(): ?string
    {
       return $this->middleName;
    }

    public function setMiddleName($middleName)
    {
       $this->middleName = $middleName;
    }
   
    public function getGender(): string
    {
       return $this->gender;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function getBirthDate(): ?string
    {
       return $this->birthDate;
    }

    public function setBirthDate($birthDate)
    {
       $this->birthDate = $birthDate;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPhone(): ?string
    {
       return $this->phone;
    }
    public function setPhone($phone)
    {
       $this->phone = $phone;
    }    
    public function getAvataPath(): ?string
    {
       return $this->avatarPath;
    }

    public function setAvataPath($avatarPath)
    {
       $this->avatarPath = $avatarPath;
    }

    

}
