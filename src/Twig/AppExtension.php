<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('taille', [$this, 'getLenth']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('additon', [$this, 'calculAdd']),
        ];
    }

    public function getLenth(array $tableau)
    {
        return "Actuellement ". count($tableau). " articles";    
    }

    public function calculAdd(int $chiffre1, int $chiffre2){
        return $chiffre1 - $chiffre2;
    }
}
