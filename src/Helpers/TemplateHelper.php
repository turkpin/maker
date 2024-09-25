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
        if (!file_exists($path)) {
            throw new \Exception("Template file not found at {$path}.");
        }

        return file_get_contents($path);
    }
}
