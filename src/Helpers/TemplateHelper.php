<?php

namespace Turkpin\Maker\Helpers;

class TemplateHelper
{
    public static function render($path, $variables)
    {
        $template = self::getTemplate($path);
        foreach ($variables as $key => $value) {
            $template = str_replace("{{$key}}", $value, $template);
        }

        return $template;
    }
    private static function getTemplate($path)
    {
        $paths = [
            __DIR__ . "/../{$path}",
            __DIR__ . "/../../../../{$path}"
        ];

        foreach ($paths as $templatePath) {
            if (file_exists($templatePath)) {
                return file_get_contents($templatePath);
            }
        }

        throw new \Exception("Template not found at {$path}.");
    }
}
