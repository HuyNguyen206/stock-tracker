<?php

namespace App\Retail;

use App\RetailNotFoundException;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Str;

class RetailFactory
{
    public static function getRetailByName($name): RetailInterface
    {
        $retailName = Str::studly($name);
        $className = Str::of("Retail$retailName")->trim()->toString();
        $fullPathClass = "App\\Retail\\$className";

        if (!class_exists($fullPathClass)) {
            throw new RetailNotFoundException("This retail implementation for $fullPathClass doesn't exist yet");
        }

        return app($fullPathClass);
    }
}
