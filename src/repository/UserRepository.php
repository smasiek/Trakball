<?php

require_once "Repository.php";
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM (SELECT * FROM public.users NATURAL JOIN public.user_details)as alias WHERE alias.email=:email 
        ');

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            //TODO zwrocic exception i potem w security controllerze odebrac ten bladi poprawnie obsluzyc
            return null;
        }
        return new User(
            $user['email'],
            $user['password'],
            $user['name'],
            $user['surname'],
            $user['phone'],
            $user['age'],
            $user['photo']
        );

    }

    public function getPhoto(string $email): ?string
    {
        $user = $this->getUser($email);
        return $user->getPhoto();
    }

    public function setPhoto(string $email,string $photoName): void
    {
        /*
         * UPDATE tableName
            SET column1=value1, column2=value2,...
            WHERE filterColumn=filterValue
         */

        $stmt = $this->database->connect()->prepare('
            SELECT id_user_details FROM (SELECT * FROM public.users NATURAL JOIN public.user_details)as alias WHERE alias.email=:email 
        ');

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $id_details= $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $this->database->connect()->prepare('

            UPDATE public.user_details 
            SET photo=:photo
            WHERE id=:id
            
        ');

        $stmt->bindParam(':photo', $photoName, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id_details['id_user_details'], PDO::PARAM_STR);
        $stmt->execute();
    }

}