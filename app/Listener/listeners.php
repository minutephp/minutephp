<?php

/** @var Binding $binding */
use Minute\Auth\CheckUserLogin;
use Minute\Auth\RetrievePassword;
use Minute\Auth\UpdateUserData;
use Minute\Event\AdminEvent;
use Minute\Event\Binding;
use Minute\Event\TodoEvent;
use Minute\Event\UserForgotPasswordEvent;
use Minute\Event\UserLoginEvent;
use Minute\Event\UserUpdateDataEvent;
use Minute\Menu\AuthMenu;
use Minute\Todo\AuthTodo;

/*$binding->addMultiple([
    ['event' => EVENT_NAME, 'handler' => [Some::class, 'fn']],
]);*/