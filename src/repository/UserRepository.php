<?php

require_once "Repository.php";
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{

    public function executeGetUserStmt(PDOStatement $stmt): ?User
    {
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            //TODO zwrocic exception i potem obsluzyc
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
            $user['photo'],
            $user['role']
        );
    }

    public function getUserUsingID(int $id): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM user_details NATURAL JOIN users NATURAL JOIN roles WHERE users.id=:id
            
        ');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $this->executeGetUserStmt($stmt);

    }

    public function getUserUsingEmail(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM user_details NATURAL JOIN users NATURAL JOIN roles WHERE email=:email
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

        $stmt = $this->database->connect()->prepare('
            SELECT user_details.id_user_details FROM user_details LEFT JOIN users ON user_details.id_user_details=users.id_user_details WHERE users.id=:id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $id_details = $stmt->fetch(PDO::FETCH_ASSOC);


        $stmt = $this->database->connect()->prepare('

            UPDATE user_details 
            SET photo=:photo
            WHERE id_user_details=:id
            
        ');

        $stmt->bindParam(':photo', $photoName, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id_details['id_user_details'], PDO::PARAM_INT);
        $stmt->execute();
    }

    public function editEmail(int $userID, string $data)
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

    public function editPassword(int $userID, string $data)
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

    public function editName(int $userID, string $data)
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

    public function editSurname(int $userID, string $data)
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

    public function editDateOfBirth(int $userID, string $data)
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

    public function editUserData(string $userID): array
    {

        $messages = [];

        if ($_POST['email'] != null) {
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $this->editEmail($userID, $_POST['email']);
            } else $messages[] = "Podaj poprawny email!";
        }

        if ($_POST['password_1'] != null && $_POST['password_2'] != null && $_POST['password_1'] == $_POST['password_2']) {
            $hashedPassword = password_hash($_POST['password_1'], PASSWORD_DEFAULT);
            $this->editPassword($userID, $hashedPassword);
        } else if ($_POST['password_1'] != null && $_POST['password_2'] == null) {
            $messages[] = "Powtórz zmieniane hasło!";
        } else if ($_POST['password_1'] != $_POST['password_2']) {
            $messages[] = "Hasła nie są identyczne!";
        }

        if ($_POST['name'] != null) {
            $userDetails = $this->getUserDetails($userID);
            $this->editName($userDetails['id'], $_POST['name']);
        }

        if ($_POST['surname'] != null) {
            $userDetails = $this->getUserDetails($userID);
            $this->editSurname($userDetails['id'], $_POST['surname']);
        }

        if ($_POST['date_of_birth'] != null) {
            $userDetails = $this->getUserDetails($userID);
            $this->editDateOfBirth($userDetails['id'], $_POST['date_of_birth']);
        }
        return $messages;
    }

    public function newUser($email, $password, $name, $surname, $phone, $date_of_birth)
    {
        $PDO = $this->database->connect();
        $PDO->beginTransaction();

        $stmt = $PDO->prepare('
            INSERT INTO public.user_details (name,surname,phone,date_of_birth,role)
            VALUES(?,?,?,?,?)
        ');
        $stmt->execute([
            $name,
            $surname,
            $phone,
            $date_of_birth,
            "user"
        ]);

        $stmt = $PDO->prepare('  
            SELECT MAX(id_user_details)
            FROM public.user_details
        ');
        $stmt->execute();
        $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);
        $newUserDetailID = $userDetails['max'];

        $stmt = $PDO->prepare('
            INSERT INTO public.users (email,password,id_user_details)
            VALUES(?,?,?)
        ');
        $outcome = $stmt->execute([
            $email,
            $password,
            $newUserDetailID
        ]);

        $PDO->commit();
        return $outcome;
    }

    public function cookieCheck($user_token): int
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM cookie_session WHERE token=:token AND expiration>:currentDate
        ');
        $currentDate = date("Y-m-d H:i:s");
        $stmt->bindParam(':token', $user_token, PDO::PARAM_STR);
        $stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
        $stmt->execute();

        $cookieInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($cookieInfo == null) {
            return 0;
        }

        return $cookieInfo['id_user'];
    }

    public function setCookie($id, $token)
    {
        //Delete old cookies of this user.
        $stmt = $this->database->connect()->prepare('
        DELETE FROM cookie_session
        WHERE id_user=:id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $this->database->connect()->prepare('
            INSERT INTO cookie_session (id_user,token,expiration)
            VALUES(?,?,?)
        ');

        $time = date("Y-m-d H:i:s", time() + 3600);
        try {
            $stmt->execute([
                $id,
                $token,
                $time
            ]);
        } catch (PDOException $e) {
            //TODO mozna zrobic aktualizacje expiration w przypadku resetu cookie'sa
            die("Exception happened while setting cookie. Message: " . $e->getMessage());
        }


    }

    public function unsetCookie($token): string
    {
        try {
            $stmt = $this->database->connect()->prepare('
            DELETE FROM cookie_session 
            WHERE token=:token
        ');
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->execute();
            return ("You have logged out");
        } catch (PDOException $e) {
            return ("Exception happened while unsetting cookie. Message: " . $e->getMessage());
        }

    }

    private function getUserDetails($userID)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM user_details LEFT JOIN users ON user_details.id=users.id_user_details WHERE users.id=:id
        ');
        $stmt->bindParam('id', $userID, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}