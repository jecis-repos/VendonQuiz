<?php

namespace Vendon;

use Pecee\SimpleRouter\SimpleRouter;


SimpleRouter::all('/', 'HomeController@index');

SimpleRouter::all('/quizes', 'QuizController@get');
SimpleRouter::all('/quiz', 'QuizController@index');
SimpleRouter::all('/quiz/get', 'QuizController@getAssoc');
SimpleRouter::all('/quiz/post', 'QuizController@post');

SimpleRouter::all('/result', 'ResultController@index');
SimpleRouter::all('/result/get', 'ResultController@getAssoc');



/** Uzstādīšanas Ceļi */
SimpleRouter::all('/setup', 'SetupController@index');
SimpleRouter::all('/setup/credentials', 'SetupController@addCredentials');
SimpleRouter::all('/createDatabase', '\Vendon\Code\Model\Database\CreateDatabase@create');
SimpleRouter::all('/addTables', '\Vendon\Code\Model\Database\CreateDatabase@addTables');
SimpleRouter::all('/seedData', '\Vendon\Code\Model\Database\CreateDatabase@seedData');


