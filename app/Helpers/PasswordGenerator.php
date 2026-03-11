<?php

namespace App\Helpers;

class PasswordGenerator
{

    public static function generate($length = 8, $specialChars = true){
        // Forcer minimum 8 caractères
        $length = max(8, $length);
        
        // Définir les caractères disponibles
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $symbols = '!@#$%^&*()_-+=<>?';
        
        // Assembler selon les besoins
        $chars = $lowercase . $uppercase . $numbers;
        if ($specialChars) {
            $chars .= $symbols;
        }
        
        // Garantir au moins un caractère de chaque type
        $password = [
            $lowercase[random_int(0, 25)],
            $uppercase[random_int(0, 25)],
            $numbers[random_int(0, 9)]
        ];
        
        if ($specialChars) {
            $password[] = $symbols[random_int(0, strlen($symbols) - 1)];
        }
        
        // Compléter la longueur
        for ($i = count($password); $i < $length; $i++) {
            $password[] = $chars[random_int(0, strlen($chars) - 1)];
        }
        
        // Mélanger le tout
        shuffle($password);
        
        return implode('', $password);
    }
}