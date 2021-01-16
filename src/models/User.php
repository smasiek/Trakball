<?php


class User
{
    private $id;
    private $email;
    private $password;
    private $name;
    private $surname;
    private $phone;
    private $dateOfBirth;
    private $photo;
    private $role;


    public function __construct(string $id,string $email, string $password, string $name, string $surname, string $phone, $dateOfBirth, string $photo,string $role)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
        $this->phone = $phone;
        $this->dateOfBirth = $dateOfBirth;
        $this->photo = $photo;
        $this->role = $role;
    }


    public function getEmail(): string
    {
        return $this->email;
    }


    public function setEmail(string $email)
    {
        $this->email = $email;
    }


    public function getPassword(): string
    {
        return $this->password;
    }


    public function setPassword(string $password)
    {
        $this->password = $password;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }


    public function setSurname(string $surname)
    {
        $this->surname = $surname;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function getId(){
        return $this->id;
    }

    public function getRole(){
        return $this->role;
    }

}