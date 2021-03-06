<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Generic Page Routs
Route::get('/', "PageController@index");
Route::get('about', 'PageController@about');
Route::get('contact', 'PageController@contact');

// Properties
Route::get('properties', 'PageController@search');
Route::get('properties/post', 'PropertyController@create')->middleware("auth");
Route::get('properties/vote/{vote}/{property}', 'PropertyController@vote')->middleware("auth");
Route::get('properties/search', 'PageController@search');
Route::get('properties/view/{property}', 'PropertyController@view');
Route::get('properties/update/{property}', 'PropertyController@update')->middleware("auth");
Route::get('properties/toggleArchive/{property}', 'PropertyController@toggleArchive')->middleware("auth");
Route::post('properties/post', 'PropertyController@store')->middleware("auth");

// Users
Route::get('users', 'UserController@index')->name("profile");
Route::get('users/reports', 'UserController@reports');
Route::post('users/update/{user}', 'UserController@update');
Route::post('users/update/email/{user}', 'UserController@update_email');
Route::post('users/update/password/{user}', 'UserController@update_password');
Route::post('users/email/resend/{user}', 'UserController@resend_verification');
Route::get('users/view/{user}', 'UserController@index');
Route::get('users/destroy/{user}', 'UserController@destroy');
Route::post('users/check_deactivated', 'UserController@is_deactivated');
Route::get('users/reactivate', 'UserController@show_reactivate');
Route::post('users/reactivate', 'UserController@reactivate');

// Conversations
Route::get('conversations/unread/count/{user}', 'ConversationController@count_new_conversations');
Route::get('conversations/converse/{user}', 'ConversationController@create_conversation');
Route::get('conversations/chatheads', 'ConversationController@get_conversations');
Route::get('conversations/messages/read/{msg}', 'ConversationController@read');
Route::get('conversations/messages/{conv}', 'ConversationController@paginate_messages');
Route::post('conversations/send/{conversation}', 'ConversationController@send');

// Auth Routes
Auth::routes(["verify" => true]);   
Route::get('login', 'PageController@invalid')->name("login");
Route::get('register', 'PageController@invalid');
Route::get('password/reset', 'PageController@invalid');
Route::get('logout', 'PageController@logout');

// Admin Routes
Route::post('admin/requests/{property}', 'AdminController@add_panorama');
Route::get('admin/brokers', 'AdminController@brokers');
Route::get('admin/brokers/verify/{user}', 'AdminController@verify');
Route::get('admin/logs', 'AdminController@logs');
Route::get('admin/logs/download', 'AdminController@logs_download');
Route::get('admin/advertisements', 'AdminController@advertisements');
Route::get('admin/advertisements/remove/{ad}', 'AdminController@remove_advertisement');
Route::get('admin/requests', 'AdminController@requests');
Route::get('admin/reports', 'AdminController@reports');
Route::post('admin/advertisements', 'AdminController@add_advertisements');

// Paypal
//payment form
Route::get('paypal', 'PaymentController@index')->name("subscription");
Route::post('paypal/subscribe/{subscription}', 'PaymentController@payWithpaypal');
Route::get('paypal/status', 'PaymentController@getPaymentStatus')->name("status");