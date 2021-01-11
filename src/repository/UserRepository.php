<?php

require_once "Repository.php";
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{

    public function executeGetUserStmt(PDOStatement $stmt): ?User{
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            //TODO zwrocic exception i potem w security controllerze odebrac ten bladi poprawnie obsluzyc
            return null;
        }
        return new User(
            $user['id'],
            $user['email'],
            $user['password'],
            $user['name'],
            $user['surname'],
            $user['phone'],
            $user['age'],
            $user['photo']
        );
    }

    public function getUserUsingID(int $id): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users NATURAL JOIN user_details WHERE users.id=:id
        ');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $this->executeGetUserStmt($stmt);

    }

    public function getUserUsingEmail(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users NATURAL JOIN user_details WHERE email=:email
        ');

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        return $this->executeGetUserStmt($stmt);

    }

    public function getPhoto(string $id): ?string
    {
        $user = $this->getUserUsingID($id);
        return $user->getPhoto();
    }

    public function setPhoto(string $id, string $photoName): void
    {
        /*
         * UPDATE tableName
            SET column1=value1, column2=value2,...
            WHERE filterColumn=filterValue
         */

        $stmt = $this->database->connect()->prepare('
            SELECT id_user_details FROM user_details LEFT JOIN users ON user_details.id=users.id_user_details WHERE users.id=:id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $id_details = $stmt->fetch(PDO::FETCH_ASSOC);


        $stmt = $this->database->connect()->prepare('

            UPDATE public.user_details 
            SET photo=:photo
            WHERE id=:id
            
        ');

        $stmt->bindParam(':photo', $photoName, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id_details['id_user_details'], PDO::PARAM_INT);
        $stmt->execute();
    }

    public function editEmail(int $userID,string $data)
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE public.users
            SET email=:data
            WHERE id=:id
        ');
        $stmt->bindParam(':data', $data, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userID, PDO::PARAM_INT);

        $stmt->execute();

    }

    public function editPassword(int $userID,string $data)
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE public.users
            SET password=:data
            WHERE id=:id
        ');
        $stmt->bindParam(':data', $data, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userID, PDO::PARAM_INT);

        $stmt->execute();
    }

    public function editName(int $userID,string $data)
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE public.user_details
            SET name=:data
            WHERE id=:id
        ');
        $stmt->bindParam(':data', $data, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userID, PDO::PARAM_INT);

        $stmt->execute();
    }

    public function editSurname(int $userID,string $data)
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE public.user_details
            SET surname=:data
            WHERE id=:id
        ');
        $stmt->bindParam(':data', $data, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userID, PDO::PARAM_INT);

        $stmt->execute();
    }

    public function editDateOfBirth(int $userID,string $data)
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE public.user_details
            SET date_of_birth=:data
            WHERE id=:id
        ');
        $stmt->bindParam(':data', $data, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userID, PDO::PARAM_INT);

        $stmt->execute();
    }

    public function editUserData(string $userID): void
    {
        /*
         * UPDATE tableName
            SET column1=value1, column2=value2,...
            WHERE filterColumn=filterValue
         */

        if ($_POST['email'] != null) {
            $this->editEmail($userID, $_POST['email']);
        }

        if ($_POST['password_1'] != null && $_POST['password_2'] != null && $_POST['password_1'] == $_POST['password_2']) {
            $this->editPassword($userID, $_POST['password_1']);
        }

        if ($_POST['name'] != null) {
            $stmt = $this->database->connect()->prepare('
            SELECT * FROM user_details LEFT JOIN users ON user_details.id=users.id_user_details WHERE users.id=:id
        ');
            $stmt->bindParam('id',$userID, PDO::PARAM_INT);
            $stmt->execute();

            $userDetails=$stmt->fetch(PDO::FETCH_ASSOC);

            $this->editName($userDetails['id'],  $_POST['name']);
        }

        if ($_POST['surname'] != null) {
            $stmt = $this->database->connect()->prepare('
            SELECT * FROM user_details LEFT JOIN users ON user_details.id=users.id_user_details WHERE users.id=:id
        ');
            $stmt->bindParam('id', $userID, PDO::PARAM_INT);
            $stmt->execute();

            $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->editSurname($userDetails['id'], $_POST['surname']);
        }

        if ($_POST['date_of_birth'] != null) {
            $stmt = $this->database->connect()->prepare('
            SELECT * FROM user_details LEFT JOIN users ON user_details.id=users.id_user_details WHERE users.id=:id
        ');
            $stmt->bindParam('id',$userID, PDO::PARAM_INT);
            $stmt->execute();

            $userDetails=$stmt->fetch(PDO::FETCH_ASSOC);

            $this->editDateOfBirth($userDetails['id'], $_POST['date_of_birth']);
        }



    }

    public function newUser($email, $password, $name, $surname, $phone, $date_of_birth)
    {
        //TODO przydaloby sie to zamienic na transakcje ale nie wiem jak, lub w jakis sposob pozyskac ID tworzonego user_details


        $stmt = $this->database->connect()->prepare('
            INSERT INTO public.user_details (name,surname,phone,date_of_birth)
            VALUES(?,?,?,?)
        ');
        $stmt->execute([
            $name,
            $surname,
            $phone,
            $date_of_birth
        ]);

        $stmt = $this->database->connect()->prepare('  
            SELECT MAX(id)
            FROM public.user_details
        ');
        $stmt->execute();
        $userDetails=$stmt->fetch(PDO::FETCH_ASSOC);
        $newUserDetailID=$userDetails['max'];

        $stmt = $this->database->connect()->prepare('
            INSERT INTO public.users (email,password,id_user_details)
            VALUES(?,?,?)
        ');
        return $stmt->execute([
            $email,
            $password,
            $newUserDetailID
        ]);
    }

}