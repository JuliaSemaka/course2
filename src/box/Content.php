<?php

namespace box;

class Content
{
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function get()
    {
        return $this->content;
    }
}