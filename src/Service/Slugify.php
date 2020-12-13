<?php


namespace App\Service;


class Slugify
{

    public function generate(string $input): string
    {
        $slug = strtolower(trim($input));
        $slug = strtr($slug, "àáâàäåòóôõöøèéêëçìíîïùúûüÿñ", "aaaaaaooooooeeeeciiiiuuuuyn");
        $slug = preg_replace('/\p{P}+/u', ' ', $slug);
        $slug = preg_replace('/\-+/', '-', $slug);
        $slug = str_replace(' ', '-', $slug);
        return $slug;
    }
}