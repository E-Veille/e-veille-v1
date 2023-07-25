<?php

function randomMDP($longueur = 10) {
    $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $motDePasse = '';
    for ($i = 0; $i < $longueur; $i++) {
        $motDePasse .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $motDePasse;
}
