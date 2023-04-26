<?php

namespace Core;

class Controller extends TemplateEngine{
    
    private static $_render;

    protected function render($view, $scope = [])
    {
        extract($scope);

        $f = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', 'View', str_replace("src","",str_replace('Controller', '', basename(get_class($this)))), $view]) . '.php';
        $f = str_replace("//","/",str_replace("\\\\","/",$f));
        if (file_exists($f)) {
            
            $content_parsed = $this->parse(file_get_contents($f));
                preg_match("/(@(.*))/", $content_parsed[1], $match2);
                if (!is_bool($match2)&&isset($match2[0])) {
                    do{
                        preg_match("/(@(.*))/", $content_parsed[1], $match2);
                        $content_parsed = $this->parse($content_parsed[1]);
                    }while(!is_bool($match2)&&isset($match2[0]));
                }
            $template = __DIR__ . "/template.php";
            try {
                file_put_contents($template,str_replace("\\","",$content_parsed[1]));
            } catch (\Exception $th) {
                echo $th;
            }

            ob_start();
            require($template);
            $view = ob_get_clean();
            ob_start();
            require(implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', 'View', 'index']) . '.php');
            self::$_render = ob_get_clean();
        }
    }

    public function __destruct(){
        echo self::$_render;
    }
}