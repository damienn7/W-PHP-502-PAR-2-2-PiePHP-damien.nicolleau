<?php

namespace Core;

class TemplateEngine
{

    private array $template = [
        "@foreach" => "/(.*@foreach(.*))/",
        "@endforeach" => "/(.*@endforeach(.*))/",
        "@if" => "/(.*@if(.*))/",
        "@elseif" => "/(.*@elseif(.*))/",
        "@else" => "/(.*@else(.*))/",
        "@endif" => "/(.*@endif(.*))/",
        "@empty" => "/(.*@empty(.*))/",
        "@endempty" => "/(.*@endempty(.*))/",
        "@isset" => "/(.*@isset(.*))/",
        "@endisset" => "/(.*@endisset(.*))/",
        "{{" => "/({{(.*)}})/"
    ];

    // protected function __construct()
    // {
    //     $this->template = [
    //         "@foreach" => "/(@foreach(.*))/",
    //         "@endforeach" => "/(@endforeach(.*))/",
    //         "@if" => "/(@if(.*))/",
    //         "@elseif" => "/(@elseif(.*))/",
    //         "@else" => "/(@else(.*))/",
    //         "@endif" => "/(@endif(.*))/",
    //         "@empty" => "/(@empty(.*))/",
    //         "@endempty" => "/(@endempty(.*))/",
    //         "@isset" => "/(@isset(.*))/",
    //         "@endisset" => "/(@endisset(.*))/",
    //         "{{" => "/({{(.*)}})/"
    //     ];
    // }

    public function parse($content)
    {
        $old_content = $content;
        $new_content = $content;
        
            foreach ($this->template as $key => $value) {
                preg_match($value, $old_content, $match);

                if (!is_bool($match)) {
                    if (isset($match[0])) {

                        $matching = $match[0];

                        switch ($key) {
                            case '@foreach':
                                $to_replace = substr(trim(str_replace("@foreach", "<\?php foreach", $matching)), 0, -1) . "): ?>";
                                $new_content = str_replace($match[0], $to_replace, $new_content);
                                break;
                            case '@if':
                                $to_replace = substr(trim(str_replace("@if", ' <\?php if', $matching)), 0, -1) . "): ?>";
                                $new_content = str_replace($match[0], $to_replace, $new_content);
                                break;
                            case '@elseif':
                                $to_replace = substr(trim(str_replace("@elseif", "<\?php elseif", $matching)), 0, -1) . "): ?>";
                                $new_content = str_replace($match[0], $to_replace, $new_content);
                                break;
                            case '@isset':
                                $to_replace = substr(trim(str_replace("@isset", "<\?php if(isset", $matching)), 0, -1) . ")): ?>";
                                $new_content = str_replace($match[0], $to_replace, $new_content);
                                break;
                            case '@empty':
                                $to_replace = substr(str_replace("@empty", "<\?php if(empty", $matching), 0, -1) . "): ?>";
                                $new_content = str_replace($match[0], $to_replace, $new_content);
                                break;
                            case '{{':
                                $new_content = str_replace("}}", " ?>", str_replace("{{", "<\?= ", $new_content));
                                break;
                            case '@else':
                                $new_content = str_replace("@else", "<\?php else: ?>", $new_content);
                                break;
                            case '@endempty';
                                $new_content = str_replace("@endempty", "<\?php endif; ?>", $new_content);
                                break;
                            case '@endisset';
                                $new_content = str_replace("@endisset", "<\?php endif; ?>", $new_content);
                                break;
                            default:
                                $to_replace = str_replace($key, "<\?php " . substr($key, 1, strlen($key)), $matching) . "; ?>";
                                $new_content = str_replace($match[0], $to_replace, $new_content);
                                break;


                        }
                    }
                }
            }
            
            return [$old_content, $new_content];
            
    }
}