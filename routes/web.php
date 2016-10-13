<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::get('/','HomeController@index');
Route::get('editor','DemoController@editor');
Route::get('getProfiles', 'DemoController@getProfiles');
Route::get('test', 'DemoController@index');

Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('welcome',function (){
   return View('welcome');
});
Route::get('admin/main', function(){return View('admin.main');});


Route::group(['prefix' => 'api'], function() {

    /*
     *  Организационная структура ВУЗа (Институты, профили)
     */
    Route::group(['prefix' => 'org'], function () {
        Route::get('institute/{id}/profiles', 'OrgStructureController@getInstituteProfiles');
        Route::get('institutes', 'OrgStructureController@getAllInstitutes');

        Route::group(['prefix' => 'profile'], function () {
            Route::get('{id}/groups', 'OrgStructureController@getProfileGroups');
            Route::get('{id}/plans', 'OrgStructureController@getProfilePlans');

            Route::post('create', 'OrgStructureController@createProfile');
            Route::post('update', 'OrgStructureController@updateProfile');
            Route::post('delete/{id}', 'OrgStructureController@deleteProfile');
        });
    });

    /*
     * Учебные планы
     */
    Route::group(['prefix' => 'plan'], function () {
        Route::get('{id}', 'StudyPlanController@getPlan');
        Route::get('{id}/disciplines', 'StudyPlanController@getPlanDisciplines');
        Route::post('create', 'StudyPlanController@create');
        Route::post('update', 'StudyPlanController@update');
        Route::post('delete/{id}', 'StudyPlanController@delete');

        Route::group(['prefix' => 'discipline'], function () {
            Route::get('{id}/marks', 'StudyPlanController@getDisciplinePlanMarkTypes');
            Route::post('create', 'StudyPlanController@addDisciplinePlan');
            Route::post('update', 'StudyPlanController@updateDisciplinePlan');
            Route::post('delete/{id}', 'StudyPlanController@deleteDisciplinePlan');
        });

        Route::group(['prefix' => 'mark'], function () {
            Route::post('create', 'StudyPlanController@addDisciplinePlan');
            Route::post('update', 'StudyPlanController@updateDisciplinePlan');
            Route::post('delete/{id}', 'StudyPlanController@deleteDisciplinePlan');
        });
    });


});


