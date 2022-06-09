<?php

namespace App\Service;

class CasearCipher
{

    // Don't Repeat Yoursel - SOLID - Keep It Simple Stupid
    public function encode(string $message): string
    {
        return str_rot13($message);
    }

    public function decode(string $message): string
    {
        return $this->encode($message);
    }

}
