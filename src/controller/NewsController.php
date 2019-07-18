<?php

namespace JuliaYatsko\course2\controller;

use JuliaYatsko\course2\core\DBDriver;
use JuliaYatsko\course2\core\Exception\ModelIncorrectDataException;
use JuliaYatsko\course2\core\Validator;
use JuliaYatsko\course2\models\NewsModel;
use JuliaYatsko\course2\core\DB;

class NewsController extends BaseController
{
    const ROOT = "__DIR__ . '/../views/";

    public function indexAction()
    {
        $this->title .= '::список всех статей';

        $user = $this->container->get('user');

        if (!$user->isAuth($this->request)) {
            $this->response->redirect('/users/sign_in')->send();
        }

        $news = $this->container->fabricate('factory-models', 'News')->getAll('is_moderate = \'1\'');

        $this->content = $this->build(self::ROOT . 'news.html.php', ['news' => $news]);
    }

    public function oneAction()
    {
        $id = $this->request->get()->get('id');

        $this->title = 'Статья №' . $id;

        $user = $this->container->get('user');

        if (!$user->isAuth($this->request)) {
            $this->response->redirect('/users/sign_in')->send();
        }

        $news = $this->container->fabricate('factory-models', 'News')->getById(sprintf('id = \'%s\'', $id));

        $this->content = $this->build(self::ROOT . 'one_news.html.php', ['news' => $news]);
    }

    public function editAction()
    {
        $id = $this->request->get()->get('id');

        $this->title = 'Редактирование статьи №' . $id;

        $user = $this->container->get('user');

        if (!$user->isAuth($this->request)) {
            $this->response->redirect('/users/sign_in')->send();
        }

        if($this->request->isPost()){
            $this->container->fabricate('factory-models', 'News')->updateById($id, ['news_title'=>$this->request->post()->get('title'), 'news_content'=>$this->request->post()->get('content')]);

            $this->response->redirect('/')->send();
        } else {
            $news = $this->container->fabricate('factory-models', 'News')->getById("id = $id");

            $this->content = $this->build(self::ROOT . 'edit.html.php', ['news' => $news]);
        }

    }

    public function newAction()
    {
        $user = $this->container->get('user');

        if (!$user->isAuth($this->request)) {
            $this->response->redirect('/users/sign_in')->send();
        }

        if(!$this->request->isPost()) {
            $this->title = 'Новая статья';
            $this->content = $this->build(self::ROOT . 'add_new.html.php');
        }

        if($this->request->isPost()){

            try {
                //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                $news = $this->container->fabricate('factory-models', 'News')->addNew(['news_title' => $this->request->post()->get('title'), 'news_content' => $this->request->post()->get('content')]);

                $this->response->redirect(sprintf('/news/one/%s', $news))->send();
            } catch (ModelIncorrectDataException $e) {
                $this->title = 'Ошибка';
                $err['message'] = $e->getMessage();
                $err['trace'] = $e->getTrace();
                $err['errors'] = $e->getErrors();
                $this->content = $this->build(self::ROOT . 'add_new.html.php', ['err' => $err]);
            }
        }
    }
}