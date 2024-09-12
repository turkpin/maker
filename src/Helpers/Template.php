<?php

namespace Turkpin\Maker\Helpers;

class Template
{
    public static function render($name, $data)
    {
        $template = self::getTemplate($name);
        foreach ($data as $key => $value) {
            $template = str_replace("{{$key}}", $value, $template);
        }

        return $template;
    }

    private static function getTemplate($name)
    {
        $templatePath = self::findTemplatePath($name);
        if (!file_exists($templatePath)) {
            throw new \Exception("Template file not found: {$name}");
        }

        return file_get_contents($templatePath);
    }

    private static function findTemplatePath($name)
    {
        $path = __DIR__ . "/../Templates/";

        $nameLower = strtolower($name);

        $files = scandir($path);
        foreach ($files as $file) {
            $fileLower = strtolower($file);
            if (strpos($fileLower, $nameLower) !== false && substr($fileLower, -5) === '.stub') {
                return "$path$file";
            }
        }

        throw new \Exception("No template found matching: {$name}");
    }
}
