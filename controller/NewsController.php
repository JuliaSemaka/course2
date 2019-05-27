<?php

namespace controller;

use core\DBDriver;
use core\Exception\ModelIncorrectDataException;
use core\Validator;
use models\NewsModel;
use core\DB;

define("ROOT", "__DIR__ . '/../views/");

class NewsController extends BaseController
{
    public function indexAction()
    {
        $this->title .= '::список всех статей';

        $mNews = new NewsModel(
            new DBDriver(DB::db_connect()),
            new Validator()
            );
        $news = $mNews->getAll(['is_moderate' => '1']);

        $this->content = $this->build(ROOT . 'news.html.php', ['news' => $news]);
    }

    public function oneAction()
    {
        $id = $this->request->get('id');

        $this->title = 'Статья №' . $id;

        $mNews = new NewsModel(
            new DBDriver(DB::db_connect()),
            new Validator()
        );
        $news = $mNews->getById(['id' => $id]);

        $this->content = $this->build(ROOT . 'one_news.html.php', ['news' => $news]);
    }

    public function editAction()
    {
        $id = $this->request->get('id');

        $this->title = 'Редактирование статьи №' . $id;

        $mNews = new NewsModel(
            new DBDriver(DB::db_connect()),
            new Validator()
        );


        if($this->request->isGet()){
            $news = $mNews->getById(['id' => $id]);

            $this->content = $this->build(ROOT . 'edit.html.php', ['news' => $news]);
        }

        if($this->request->isPost()){
//            var_dump($this->request->getMethod('post', 'title'));
//            die();

            $mNews->updateById($id, ['news_title'=>$this->request->post('title'), 'news_content'=>$this->request->post('content')]);

            $this->redirect('/news/');
        }

    }

    public function newAction()
    {
        if($this->request->isGet()) {
            $this->title = 'Новая статья';
            $this->content = $this->build(ROOT . 'add_new.html.php');
        }

        if($this->request->isPost()){

            $mNews = new NewsModel(
                new DBDriver(DB::db_connect()),
                new Validator()
            );

            try {
                $news = $mNews->addNew(['news_title' => $this->request->post('title'), 'news_content' => $this->request->post('content')]);

                $this->redirect(sprintf('/news/one/%s', $news));
            } catch (ModelIncorrectDataException $e) {
                $this->title = 'Ошибка';
                $err['message'] = $e->getMessage();
                $err['trace'] = $e->getTrace();
                $err['errors'] = $e->getErrors();
                $this->content = $this->build(ROOT . 'errorEx.html.php', ['err' => $err]);
            }
        }
    }
}