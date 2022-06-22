<?php

Routes::test('/', 'GET', 'PagesController::home');
Routes::test('/\w{8}', 'GET', 'PagesController::load');

Routes::test(API_PATH . 'get', 'GET', 'HashController::get');
Routes::test(API_PATH . 'save', 'POST', 'HashController::save');
