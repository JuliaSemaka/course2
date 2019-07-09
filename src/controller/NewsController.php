<?php

namespace Project\Phpblog\controller;

use Project\Phpblog\core\DBDriver;
use Project\Phpblog\core\Exception\ModelIncorrectDataException;
use Project\Phpblog\core\Validator;
use Project\Phpblog\models\NewsModel;
use Project\Phpblog\core\DB;

class NewsController extends BaseController
{
    const ROOT = "__DIR__ . '/../views/";

    public function indexAction()
    {
        $this->title .= '::список всех статей';

        $mNews = new NewsModel(
            new DBDriver(DB::db_connect()),
            new Validator()
            );
        $news = $mNews->getAll('is_moderate = \'1\'');

        $this->content = $this->build(self::ROOT . 'news.html.php', ['news' => $news]);
    }

    public function oneAction()
    {
        $id = $this->request->get('id');

        $this->title = 'Статья №' . $id;

        $mNews = new NewsModel(
            new DBDriver(DB::db_connect()),
            new Validator()
        );
        $news = $mNews->getById(sprintf('id = \'%s\'', $id));

        $this->content = $this->build(self::ROOT . 'one_news.html.php', ['news' => $news]);
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

            $this->content = $this->build(self::ROOT . 'edit.html.php', ['news' => $news]);
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
            $this->content = $this->build(self::ROOT . 'add_new.html.php');
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
                $this->content = $this->build(self::ROOT . 'sign_up.html.php', ['err' => $err]);
            }
        }
    }
}