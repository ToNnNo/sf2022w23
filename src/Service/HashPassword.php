<?php

namespace App\Service;

class HashPassword
{
    private $salt;
    private $casearCipher;

    public function __construct(string $salt, CasearCipher $casearCipher)
    {
        $this->casearCipher = $casearCipher;
        $this->salt = $this->casearCipher->encode($salt);
    }

    public function hash($password): string
    {
        return sha1($this->salt.$password.$this->salt);
    }

}
