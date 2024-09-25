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
        $templatePath = __DIR__ . "/../$path";
        if (!file_exists($templatePath)) {
            throw new \Exception("Template file not found at {$templatePath}.");
        }

        return file_get_contents($templatePath);
    }
}
