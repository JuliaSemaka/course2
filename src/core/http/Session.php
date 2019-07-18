<?php

namespace JuliaYatsko\course2\core\http;

use Ig0rbm\HandyBag\HandyBag;

class Session
{
    protected $bag;

    protected $isStarted = false;

    public function __construct()
    {
        $this->bag = new HandyBag();
    }

    public function start()
    {
        if (!session_start()) {
            throw new \RuntimeException('Session start is failed.');
        }

        $this->isStarted = true;

        return $this;
    }

    public function collection()
    {
        return $this->bag;
    }

    public function initialize()
    {
        if (!$this->isStarted) {
            return false;
        }
//        var_dump($_SESSION);
//        die;
        $this->bag->merge($_SESSION);

        return $this;
    }

    public function getId()
    {
        if (false === $this->isStarted) {
            return false;
        }

        return session_id();
    }

    public function save()
    {
        if (0 === $this->bag->count()) {
            return $this;
        }

        if (false === $this->isStarted) {
            return $this;
        }

        foreach ($this->bag->getAll() as $key => $value) {
            $_SESSION[$key] = $value;
        }

        return $this;
    }
}