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

Route::get('/', function () {
    return view('dashboard/index')->with(['title' => 'Amax Education']);
})->name('index');
Route::get('/student', 'StudentController@index')->name('StudentIndex');
Route::post('/student/editName', 'StudentController@editStudentName')->name('StudentEditName');
Route::post('/student/save', 'StudentController@store')->name('StudentStore');
Route::post('/student/get', 'StudentController@getStudentInfo')->name('StudentGetOne');
Route::post('/student/delete', 'StudentController@deleteStudent')->name('DeleteStudent');
Route::post('/student/filter', 'StudentController@getStudentFromFilter')->name('StudentGetFilter');



Route::get('/course', 'CourseController@index')->name('CourseIndex');
Route::post('/course/save', 'CourseController@store')->name('CourseStore');
Route::post('/course/get', 'CourseController@getCourseInfo')->name('CourseGetOne');
Route::get('/course/register', 'CourseController@courseRegister')->name('CourseRegister');
Route::post('/course/delete', 'CourseController@deleteCourse')->name('CourseDelete');


Route::get('/teacher', 'TeacherController@index')->name('TeacherIndex');
Route::post('/teacher/store', 'TeacherController@store')->name('TeacherStore');
Route::post('/teacher/delete', 'TeacherController@deleteTeacher')->name('TeacherDelete');
Route::post('/teacher/get', 'TeacherController@getTeacherInfo')->name('TeacherGetOne');


Route::get('/subject', 'SubjectController@index')->name('SubjectIndex');
Route::post('/subject/store', 'SubjectController@store')->name('SubjectStore');
Route::post('/subject/delete', 'SubjectController@deleteSubject')->name('SubjectDelete');
Route::post('/subject/get', 'SubjectController@getSubjectInfo')->name('SubjectGetOne');


Route::post('/bill/save', 'BillController@store')->name('BillStore');
Route::get('/bill/index', 'BillController@index')->name('BillIndex');
Route::post('/bill/get', 'BillController@getBillInfo')->name('BillGetOne');