<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// //Generate Application key
// $router->get('/key', function (){
//     return str_random(32);
// });

$router->group(['prefix' => 'api/v1/'], function($router){

	// Route for All User API
	////php add/user ....
	$router->group(['prefix' => 'users'], function($router){
		$router->post('/add/user','UserController@addUser');
		$router->post('/add/school','UserController@addSchool');	
		$router->post('/register','UserController@addSchUser');
		$router->post('/login-access','UserController@authenticate');
		$router->get('/view_all','UserController@viewAllSchool');
		$router->put('/update_reg/{id}','UserController@updateUser'); 
		$router->get('/vv/{id}','ProductController@al');

		$router->post('/upload_file','ProductController@uploadFile');
		$router->get('/combine_all','UserController@combineAll');
		$router->get('/vv/{id}','ProductController@al');

		$router->post('/upload_file','ProductController@uploadFile');
		$router->get('/combine_all','UserController@combineAll');
		$router->get('/vv/{id}','ProductController@al');
		$router->get('/vv2/{id}','ProductController@vv');

		$router->post('/upload_file','ProductController@uploadFile');
		$router->get('/combine_all','UserController@combineAll');

		

		

		//http://localhost:8000/api/v1/users/record/allrecord  ...
		$router->group(['prefix' => 'record', 'middleware' => 'auth'], function($router){
			$router->get('/allrecord','UserController@viewAllRecords');
			$router->get('/allrecord/{id}','UserController@viewAllRecord');
			$router->get('/view_alls','UserController@viewAllSchool');
			$router->get('/view_all_prod','ProductController@viewAllProduct');
			$router->put('/edit/{id}','UserController@updateUser'); 
			$router->post('/product','ProductController@addProduct');

			// http://localhost:8000/api/v1/users/record/product
			$router->get('/product/{id}','ProductController@getProductId');
			$router->delete('/delete_user/{id}','UserController@deleteUser');
			
			 
		});

		////http://localhost:8000/api/v1/users/getSchoolRecord/register ....
		$router->group(['prefix' => 'getSchoolRecord', 'middleware' => 'auth'], function($router){
			// $router->get('/schools','UserController@viewAllSchool');
			$router->get('/register/{id}','UserController@viewRegister'); 
			$router->put('/edit/schools/{id}','UserController@updateUser'); 
			$router->delete('/delete/schools/{id}','UserController@deleteUserSch'); 
		});
	});

	


});

