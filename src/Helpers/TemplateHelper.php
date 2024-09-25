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
    private static function getTemplate($path, $maxDepth = 6)
    {
        $currentDir = __DIR__;

        for ($i = 0; $i < $maxDepth; $i++) {
            $templatePath = "$currentDir/$path";

            if (file_exists($templatePath)) {
                return file_get_contents($templatePath);
            }

            $currentDir = dirname($currentDir);
        }

        throw new \Exception("Template not found at {$path}.");
    }
}
