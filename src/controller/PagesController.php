<?php

namespace JuliaYatsko\course2\controller;

class PagesController extends BaseController
{
    public function errorAction($e)
    {

        $this->title = "Ошибка";

        $this->content = $this->build(
            NewsController::ROOT . 'errorEx.html.php',
            [
                'errorMessage' => $e->getMessage(),
                'errorStackTrace' => $e->getTraceAsString(),
                'dev' => DEV
            ]
        );
    }
}