<?php

return [

    '' => [
        'controller' => 'Main',
        'action' => 'main'
    ],

    'auth/login' => [
        'controller' => 'Auth',
        'action' => 'login'
    ],

    'auth/logout' => [
        'controller' => 'Auth',
        'action' => 'logout'
    ],

    'auth/registration' => [
        'controller' => 'Auth',
        'action' => 'registration'
    ],

    'auth/restore' => [
        'controller' => 'Auth',
        'action' => 'restore'
    ],

    'auth/reset' => [
        'controller' => 'Auth',
        'action' => 'reset'
    ],

    'auth/activate' => [
        'controller' => 'Auth',
        'action' => 'activate'
    ],

    'setting/email' => [
        'controller' => 'setting',
        'action' => 'emailEdit'
    ],

    'setting/login' => [
        'controller' => 'setting',
        'action' => 'loginEdit'
    ],

    'setting/password' => [
        'controller' => 'setting',
        'action' => 'passwordEdit'
    ],

    'setting/notify' => [
        'controller' => 'setting',
        'action' => 'notify'
    ],

    'photo/new' => [
        'controller' => 'photo',
        'action' => 'new'
    ],

    'photo/user-gallery' => [
        'controller' => 'photo',
        'action' => 'userGallery'
    ],

    'photo/upload' => [
        'controller' => 'photo',
        'action' => 'upload'
    ],

    'photo\/\d+' => [
        'controller' => 'photo',
        'action' => 'show'
    ],

    'photo\/\d+/delete' => [
        'controller' => 'photo',
        'action' => 'delete'
    ],

    'like' => [
        'controller' => 'like',
        'action' => 'like'
    ],

    'comment' => [
        'controller' => 'comment',
        'action' => 'comment'
    ],

    'comment\/\d+/delete' => [
        'controller' => 'comment',
        'action' => 'delete'
    ],
];