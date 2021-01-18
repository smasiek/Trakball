<?php

require_once __DIR__ . '/../repository/UserRepository.php';

class AppController
{

    private $request;

    protected function isGet(): bool
    {
        return $this->request === 'GET';
    }

    protected function isPost(): bool
    {
        return $this->request === 'POST';
    }

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    protected function render(string $template = null, array $variables = [])
    {
        $templatePath = 'public/views/' . $template . '.php';
        $output = "File not found";


        if (file_exists($templatePath)) {
            extract($variables);

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }

        print $output;
    }

    protected function setCookie($id, $token)
    {
        $userRepository = new UserRepository();
        $userRepository->setCookie($id, $token);

        setcookie('user_token', $token, time() + 3600, '/'); // expires after 1 hour)
    }

    protected function unsetCookie($token): string
    {
        $userRepository = new UserRepository();

        try {
            setcookie('user_token', null, -1, '/');
        } catch (Exception $e) {
            return ('Exception happened while unsetting cookie. Message: ' . $e->getMessage());
        }

        return $userRepository->unsetCookie($token);
    }

    protected function getCurrentUserID(): int
    {
        $userRepository = new UserRepository();

        if (isset($_COOKIE['user_token'])) {
            return $userRepository->cookieCheck($_COOKIE['user_token']);
        } else {
            return 0;
        }
    }

    protected function cookieCheck(): int
    {
        $userID=$this->getCurrentUserID();
        if($userID!=0){
            return $userID;
        }else{
            $this->render('login');
            return 0;
        }
    }

    //TODO PRZESLEDZIC CZEMU SIE LOGIN DWA RAZY WYSWIETLA. Gdzies przy sprawdzaniu cookie musi byc redundancja
}