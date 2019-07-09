<?php

namespace box;

use Content;

class TagBuilder
{
    private $content;

    public function __construct(Content $content)
    {
        $this->content = $content;
    }

    public function h1()
    {
        return sprintf('<h1>%s</h1>h1>', $this->content->get());
    }
}