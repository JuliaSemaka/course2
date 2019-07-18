<?php

namespace JuliaYatsko\course2\core\http;

class Cookie
{
    public $name;
    public $value;
    public $expire;
    public $path;
    public $domain;

    public function __construct($name, $value = null, $expire = 0, $path = '/', $domain = null )
    {
        $this->name = $name;
        $this->value = $value;

        if ($expire instanceof \DateTimeInterface) {
            $expire = $expire->format('U');
        } elseif (!is_numeric($expire)) {
            $expire = strtotime($expire);

            if (false === $expire) {
                throw new \InvalidArgumentException('The cookie expiration time is not valid.');
            }
        }

        $this->expire = $expire;
        $this->path = $path;
        $this->domain = $domain;
    }
}