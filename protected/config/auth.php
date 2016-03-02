<?php
return array (
  'usersView' => 
  array (
    'type' => 0,
    'description' => 'Просмотр пользователя',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'usersCreate' => 
  array (
    'type' => 0,
    'description' => 'Создание пользователя',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'usersUpdate' => 
  array (
    'type' => 0,
    'description' => 'Редактирование пользователя',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'usersDelete' => 
  array (
    'type' => 0,
    'description' => 'Удаление пользователя',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'usersIndex' => 
  array (
    'type' => 0,
    'description' => 'Просмотр списка пользователей',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'usersAdmin' => 
  array (
    'type' => 0,
    'description' => 'Администрирование пользователей',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'ordersView' => 
  array (
    'type' => 0,
    'description' => 'Просмотр документа',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'ordersCreate' => 
  array (
    'type' => 0,
    'description' => 'Создание документа',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'ordersUpdate' => 
  array (
    'type' => 0,
    'description' => 'Редактирование документа',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'ordersDelete' => 
  array (
    'type' => 0,
    'description' => 'Удаление документа',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'ordersIndex' => 
  array (
    'type' => 0,
    'description' => 'Просмотр списка документов',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'ordersAdmin' => 
  array (
    'type' => 0,
    'description' => 'Администрирование документов',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'usersOwnUpdate' => 
  array (
    'type' => 1,
    'description' => 'Редактирование своих данных',
    'bizRule' => 'return Yii::app()->user->id==$params["users"]->user_id;',
    'data' => NULL,
    'children' => 
    array (
      0 => 'usersUpdate',
    ),
  ),
  'user' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'ordersView',
      1 => 'ordersCreate',
      2 => 'ordersUpdate',
      3 => 'ordersDelete',
      4 => 'ordersIndex',
      5 => 'ordersAdmin',
      6 => 'usersOwnUpdate',
    ),
  ),
  'admin' => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'user',
      1 => 'usersView',
      2 => 'usersCreate',
      3 => 'usersUpdate',
      4 => 'usersDelete',
      5 => 'usersIndex',
      6 => 'usersAdmin',
    ),
  ),
);
