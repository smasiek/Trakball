<?php

class AppController {

    private $request;

    protected function isGet(): bool{
        return $this->request==='GET';
    }

    protected function isPost(): bool{
        return $this->request==='POST';
    }

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    protected function render(string $template =null, array $variables =[]){
        $tempaltePath='public/views/'.$template.'.php';
        $output="File not found";

        if(file_exists($tempaltePath)){
            extract($variables);

            ob_start();
            include $tempaltePath;
            $output = ob_get_clean();
        }

        print $output;

    }
}