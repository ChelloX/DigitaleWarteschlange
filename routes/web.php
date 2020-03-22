<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//})->name('welcome');

Auth::routes();

Route::group([
    'middleware' => 'auth',
    'prefix' => 'admin'
], function () {

    Route::get('/invite', 'InviteController@index')->name('admin.invite');
    Route::post('/invite/send', 'SendEmailController@send')->name('admin.invite.send');
    Route::get('/dashboard', 'AdminController@index')->name('admin.dashboard');
    Route::get('/managePoi', 'ManagePois@index')->name('admin.managePoi');
    Route::post('/managePoi', 'ManagePois@delete');
});

Route::group([
    'middleware' => 'auth',
    'prefix' => 'maintainer'
], function () {
    Route::get('/dashboard', 'MaintainerController@index')->name('maintainer.dashboard');
    Route::get('/manageQueue', 'ManageQueue@index')->name('maintainer.manageQueue');
    Route::post('/createQueue', 'ManageQueue@create')->name('maintainer.createQueue');
    Route::post('/deleteQueue', 'ManageQueue@delete')->name('maintainer.deleteQueue');
    Route::post('/skipUser', 'QueueDetail@skipUser')->name('maintainer.skipUser');
    Route::get('/queueDetail', 'QueueDetail@index')->name('maintainer.queueDetail');
    Route::post('/queueDetail', 'QueueDetail@pop');
    Route::post('/editQueue', 'QueueDetail@editQueue')->name('maintainer.editQueue');
});
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', function () {
    return redirect(route('admin.dashboard'));
});
Route::get('/logout', 'AdminController@logout')->name('logout');
Route::get('/register/{token}', 'RegisterController@index')->name('register');
Route::post('/register/register', 'RegisterController@register')->name('register.post');

Route::post('/postQueueUser', 'QueueUserController@postQueueUser')->name('postQueueUser');
Route::post('/postDequeueUser', 'QueueUserController@postDequeueUser')->name('postDequeueUser');

Route::get('/queueUserInQueueQR/{uuid}', 'QrController@queueQr');

//Route::get('/getSetCookies', 'QueueUserController@coockieCheck');


Route::get('/qr/{text}', 'KundeninfoController@getQRCode')->name('qr');
Route::get('/info/{uuid}', 'KundeninfoController@getPage')->name('kundeninfo');

Route::get('/warten', 'Wait@index')->name('warten');
Route::post('/editWarten', 'Wait@edit')->name('editWarten');


Route::get('/', 'IndexController@index')->name('index');


