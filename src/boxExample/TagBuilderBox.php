<?php

namespace box;

use RegisterBoxInterface;
use Container;

class TagBuilderBox implements RegisterBoxInterface
{
    public function register(Container $container)
    {
        $container->set('tag-builder', function ($string) {
            $content = new Content($string);
            $builder = new TagBuilder($content);

            return $builder;
        });


        $container->set('UserModel', function () {
            $mUsers = new UsersModel(
                new DBDriver(DB::db_connect()),
                new Validator()
            );

            return $mUsers;
        });

        $container->set('SessionModel', function () {
            $mSession = new SessionModel(
                new DBDriver(DB::db_connect()),
                new Validator()
            );

            return $mSession;
        });
    }
}