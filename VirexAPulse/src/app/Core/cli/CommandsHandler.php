<?php

namespace App\Core\cli;
require_once dirname(__DIR__,2) . '/config.php';
class CommandsHandler
{
    public function serve(): never
    {
        exec('php -S 127.0.0.1:7777 -t public');
        exit;
    }
    public function makeController(string $name, string|null $type): string
    {
        $name = ucfirst($name) . 'Controller';
        $path = CONTROLLERS_PATH . "/$name";
        if (file_exists($path . '.php'))
        {
            return "Контроллер {$name}.php уже существует!\n";
        }
        if($type === '--full')
        {
            $template = <<<PHP
            <?php
            namespace src\Controllers;
            
            class $name
            {
                public function index()
                {
                    // 
                }
                
                public function create()
                {
                    // 
                }
                
                public function store()
                {
                    // 
                }
                
                public function show()
                {
                    // 
                }
                
                public function edit()
                {
                    // 
                }
                
                public function update()
                {
                    // 
                }
                
               public function destroy()
                {
                    // 
                }
            }
            PHP;
        }elseif($type === null)
        {
            $template = <<<PHP
            <?php
            namespace src\Controllers;
            
            class $name
            {
                public function index()
                {
                    //
                }
            }
            PHP;
        }
        file_put_contents(CONTROLLERS_PATH . "/$name.php", $template);
        return "Контроллер {$name}.php создан\n";
    }

    public function makeModel(string $name)
    {
        $path = MODELS_PATH . "/{$name}Models.php";
        if(file_exists($path))
        {

        }
    }
}