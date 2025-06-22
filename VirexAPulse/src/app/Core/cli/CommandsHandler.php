<?php

namespace App\Core\cli;
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
        if (file_exists($path . '.php')) {
            return "Контроллер {$name}.php уже существует!\n";
        }
        if ($type === '--full') {
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
        } elseif ($type === null) {
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

    public function makeModel(string $name): string
    {
        $name = ucfirst($name);
        $path = MODELS_PATH . "/$name.php";
        if (file_exists($path)) {
            return "Модель {$name}.php уже существует!\n";
        } else {
            $template = <<<PHP
            <?php
            namespace src\Models;
            use Illuminate\Database\Eloquent\Model;
            class $name extends Model
            {
                protected \$table = 'ваша таблица'; //например protected \$table = 'users';
                /** 
                * protected @fillable = [] здесь указываются столбцы таблицы, которые можно изменять,
                * либо используйте:  
                 protected @guarded = [], чтобы каждый раз не вводить в @fillable столбцы
                * Например: protected @fillable = ['username', 'user_password', 'email'], либо
                *  @guarded = []
                 */
            }
            PHP;
        }
        file_put_contents(MODELS_PATH . "/{$name}.php", $template);
        return "Модель {$name}.php создана\n";
    }

    public function getCommandsList()
    {
        return "==========================Controllers==================================\n php blaze make:controller Test - позволяет создать контроллер в папке Controllers,\n с именем, которое вы указали\n Также, можно указать --full, для автоматического заполнения шаблонами методов в контроллере.\n Тогда запрос должен выглядеть так:\n php blaze make:controller Test --full\n======================================================================\n==========================Models======================================\n php blaze make:model Test - позволяет создать модель в папке Models\n======================================================================\n";
    }
}