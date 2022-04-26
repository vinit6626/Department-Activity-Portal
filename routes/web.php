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
    return view('welcome');
});

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*Route::get('/home', function () {
            return redirect('/');
});*/

//-----Admin-----//
Route::group(['prefix'=>'admin'], function() {
        // Authentication Routes...
        
        Route::get('dashboard','AdminController@index');
        Route::get('profile/edit','AdminController@editprofile');
        Route::post('editprofile_data','AdminController@updateprofile');
        Route::get('change_password','AdminController@change_password_showform');
        Route::post('change_password','AdminController@change_password');
        Route::get('forget_password','ForgetPasswordController@admin_forget_password_showform');
        Route::post('forget_password_data','ForgetPasswordController@admin_forget_password_data');
        
        //Verifying and managing students
        Route::get('show/students/unverified','Auth\StudentsManageController@show_unverified_students');
       Route::post('student_verified','Auth\StudentsManageController@verify_student');
        Route::get('show/students/verified','Auth\StudentsManageController@show_verified_students');
        Route::post('student_make_unverified','Auth\StudentsManageController@make_unverify_student');

        //Verifying and managing faculties
        Route::get('show/faculties/unverified','Auth\FacultiesManageController@show_unverified_faculties');
        Route::post('faculty_verified','Auth\FacultiesManageController@verify_faculty');
        Route::get('show/faculties/verified','Auth\FacultiesManageController@show_verified_faculties');
        Route::post('faculty_make_unverified','Auth\FacultiesManageController@make_unverify_faculty');

        //New Counselor and manage existing conselors
        Route::get('add/counselor','Auth\CounselorsManageController@create_counselor_form');
        
        Route::get('counselors/manage','Auth\CounselorsManageController@manageCounselors');
        Route::post('counselors/remove_counselor','Auth\CounselorsManageController@removeCounselor');

        Route::get('show/all/counselors','Auth\CounselorsManageController@showAllCounselors');
        Route::post('create/counselor','Auth\CounselorsManageController@create_counselor');
        Route::post('create/counselor/getstudents','Auth\CounselorsManageController@get_students');

        //Faculties Reports
        Route::get('generate/faculties/reports','FacultiesReportsController@generateFacultiesReportsForm');
        Route::post('generate/faculties/reports','FacultiesReportsController@generateFacultiesReports');
        //Route::get('generate/faculties/reports','FacultiesReportsController@generateFacultiesReports');
        Route::post('/faculties/all/reports/downloadAllExcel','FacultiesReportsController@downloadAllInExcel');



        //Students Reports
        Route::get('generate/students/reports','StudentsReportsController@generateFacultiesReportsForm');
        Route::post('generate/students/reports','StudentsReportsController@generateFacultiesReports');
        //Route::get('generate/faculties/reports','FacultiesReportsController@generateFacultiesReports');


        
        /*----login and registration----*/
        
        $this->get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
        $this->post('login', 'Auth\LoginController@login');
        $this->post('logout', 'Auth\LoginController@logout')->name('admin.logout');

        // Registration Routes...
        $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('admin.register');
        
        //custom updated
        $this->post('register', 'Auth\RegisterController@redirect_register');

        // Password Reset Routes...
        $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        $this->post('password/reset', 'Auth\ResetPasswordController@reset');
});


//-----Faculty-----//
Route::group(['prefix'=>'faculty'], function() {

    Route::get('dashboard','FacultyController@index');
    Route::post('delete/notification','FacultyController@delete_notification');


    Route::view('home','faculty_home');
    Route::get('profile','FacultyController@showprofile');
    Route::get('profile/edit','FacultyController@editprofile');
    Route::post('editprofile_data','FacultyController@updateprofile');
    Route::get('change_password','FacultyController@change_password_showform');
    Route::post('change_password','FacultyController@change_password');
    
    Route::get('forget_password','ForgetPasswordController@faculty_forget_password_showform');
    Route::post('forget_password_data','ForgetPasswordController@faculty_forget_password_data');




//Counselor role routes
    Route::get('counselor/dashboard','CounselorController@index');
    Route::get('counselor/students','CounselorController@showallstudents');
    
    Route::get('counselor/add/result','CounselorController@show_add_result_form');
    Route::post('counselor/add/result','CounselorController@add_result');

    Route::get('counselor/manage/results','CounselorController@manage_results');
    
    Route::get('counselor/edit/results','CounselorController@edit_results_form');
    Route::post('counselor/fetch/results','CounselorController@fetch_result');
    
    Route::post('counselor/edit/result','CounselorController@edit_result');

/*------Personal Reports-------*/

    Route::get('generate/personal/reports','FacultyPersonalReportsController@showPersonalReportsForm');
    Route::post('generate/personal/reports','FacultyPersonalReportsController@generatePersonalReport');
    //Route::get('generate/personal/reports','FacultyPersonalReportsController@generatePersonalReport');

    Route::post('/personal/all/reports/downloadAllExcel','FacultyPersonalReportsController@downloadAllInExcel');


/*------Attended Activities------*/ 

    Route::get('attended/activity/add','FacultyActivitiesController@showAttendedForm');
    Route::post('attended/activitydata','FacultyActivitiesController@insertAttendedActivity');

    Route::get('show/attended/activities','FacultyActivitiesController@showAttendedActivities');
    
    //Edit
    Route::get('edit/attended/activity/{sr_no}','FacultyActivitiesController@editAttendedActivityForm');
    Route::post('edit/attended/activity/{sr_no}','FacultyActivitiesController@editAttendedActivityData');


/*------Organized Activities------*/ 

    Route::get('organized/activity/add','FacultyActivitiesController@showOrganizedForm');

    Route::post('organized/activitydata','FacultyActivitiesController@insertOrganizedActivity');

    Route::post('organized/fetch/other_faculties','FacultyActivitiesController@fetch_other_faculties');

    Route::get('show/organized/activities','FacultyActivitiesController@showOrganizedActivities');



    //Edit
    Route::get('edit/organized/activity/{sr_no}','FacultyActivitiesController@editOrganizedActivityForm');
    Route::post('edit/organized/activity/{sr_no}','FacultyActivitiesController@editOrganizedActivityData');

/*------Training & Internship-------*/
    Route::get('training_internship/add','FacultyActivitiesController@show_training_intership_form');
    Route::post('training_internship_data','FacultyActivitiesController@insertTrainingInternship');
    Route::get('show/trainings_internships','FacultyActivitiesController@show_trainings_internships');

    //Edit
    Route::get('edit/training_internship/{sr_no}','FacultyActivitiesController@editTrainingInternshipForm');
    Route::post('edit/training_internship/{sr_no}','FacultyActivitiesController@editTrainingInternshipData');

/*------Published Papers-----*/
    Route::get('published_paper/add','FacultyActivitiesController@show_published_paper_form');
    Route::post('published_paper_data','FacultyActivitiesController@insertPublishedPaper');

    Route::get('show/published/papers','FacultyActivitiesController@show_published_papers');

     //Edit
    Route::get('edit/published_paper/{sr_no}','FacultyActivitiesController@editPublishedPaperForm');
    Route::post('edit/published_paper/{sr_no}','FacultyActivitiesController@editPublishedPaperData');


/*------Published Books-----*/
    Route::get('published_book/add','FacultyActivitiesController@show_published_book_form');
    Route::post('published_book_data','FacultyActivitiesController@insertPublishedBook');

    Route::get('show/published/books','FacultyActivitiesController@show_published_books');

     //Edit
    Route::get('edit/published_book/{sr_no}','FacultyActivitiesController@editPublishedBookForm');
    Route::post('edit/published_book/{sr_no}','FacultyActivitiesController@editPublishedBookData');

/*------Research & Development-----*/
    Route::get('research_development/add','FacultyActivitiesController@show_r_and_d_form');
    Route::post('research_development_data','FacultyActivitiesController@insertResearchDevelopment');
    
    Route::get('show/research_development','FacultyActivitiesController@show_r_and_d');

     //Edit
    Route::get('edit/research_development/{sr_no}','FacultyActivitiesController@edit_R_and_D_Form');
    Route::post('edit/research_development/{sr_no}','FacultyActivitiesController@edit_R_and_D_Data');

/*------Other Services-----*/
    Route::get('other_services/add','FacultyActivitiesController@show_other_services_form');
    Route::post('other_services_data','FacultyActivitiesController@insertOtherService');

    Route::get('show/other_services','FacultyActivitiesController@show_other_services');

     //Edit
    Route::get('edit/other_service/{sr_no}','FacultyActivitiesController@edit_other_service_Form');
    Route::post('edit/other_service/{sr_no}','FacultyActivitiesController@edit_other_services_Data');

// Login Routes...
    Route::get('login', ['as' => 'faculty.login', 'uses' => 'FacultyAuth\LoginController@showLoginForm']);
    Route::post('login', ['uses' => 'FacultyAuth\LoginController@login']);
    Route::post('logout', ['as' => 'faculty.logout', 'uses' => 'FacultyAuth\LoginController@logout']);

// Registration Routes...
    Route::get('register', ['as' => 'faculty.register', 'uses' => 'FacultyAuth\RegisterController@showRegistrationForm']);
    Route::post('register', ['uses' => 'FacultyAuth\RegisterController@redirect_register']);

// Password Reset Routes...
    Route::get('password/reset', ['as' => 'password.reset', 'uses' => 'FacultyAuth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/email', ['as' => 'password.email', 'uses' => 'FacultyAuth\ForgotPasswordController@sendResetLinkEmail']);
    Route::get('password/reset/{token}', ['as' => 'password.reset.token', 'uses' => 'FacultyAuth\ResetPasswordController@showResetForm']);
    Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'FacultyAuth\ResetPasswordController@reset']);
});



//-----student-----/
Route::group(['prefix'=>'student'], function() {

    Route::get('dashboard','StudentController@index');
    Route::post('delete/notification','StudentController@delete_notification');
    Route::get('profile','StudentController@showprofile');
    Route::get('profile/edit','StudentController@editprofile');
    Route::post('editprofile_data','StudentController@updateprofile');
    Route::get('change_password','StudentController@change_password_showform');
    Route::post('change_password','StudentController@change_password');

    Route::get('forget_password','ForgetPasswordController@student_forget_password_showform');
    Route::post('forget_password_data','ForgetPasswordController@student_forget_password_data');
     //Route::view('home','student_home');

    /*------Personal Reports-------*/

    Route::get('generate/personal/reports','StudentPersonalReportsController@showPersonalReportsForm');
    Route::post('generate/personal/reports','StudentPersonalReportsController@generatePersonalReport');
    Route::post('/personal/all/reports/downloadAllExcel','StudentPersonalReportsController@downloadAllInExcel');
    
    //Route::get('generate/personal/reports','FacultyPersonalReportsController@generatePersonalReport');

/*------Attended Activities------*/ 

    Route::get('attended/activity/add','StudentActivitiesController@showAttendedForm');
    Route::post('attended/activitydata','StudentActivitiesController@insertAttendedActivity');

    Route::get('show/attended/activities','StudentActivitiesController@showAttendedActivities');
    
    //Edit
    Route::get('edit/attended/activity/{sr_no}','StudentActivitiesController@editAttendedActivityForm');
    Route::post('edit/attended/activity/{sr_no}','StudentActivitiesController@editAttendedActivityData');

/*------Organized Activities------*/ 

    Route::get('organized/activity/add','StudentActivitiesController@showOrganizedForm');
    Route::post('organized/activitydata','StudentActivitiesController@insertOrganizedActivity');

    Route::post('organized/fetch/other_students','StudentActivitiesController@fetch_other_students');


    Route::get('show/organized/activities','StudentActivitiesController@showOrganizedActivities');

    //Edit
    Route::get('edit/organized/activity/{sr_no}','StudentActivitiesController@editOrganizedActivityForm');
    Route::post('edit/organized/activity/{sr_no}','StudentActivitiesController@editOrganizedActivityData');


/*------Training & Internship-----*/
    Route::get('training_internship/add','StudentActivitiesController@show_training_intership_form');
    Route::post('training_internship_data','StudentActivitiesController@insertTrainingInternship');

    Route::get('show/trainings_internships','StudentActivitiesController@show_trainings_internships');

    //Edit
    Route::get('edit/training_internship/{sr_no}','StudentActivitiesController@editTrainingInternshipForm');
    Route::post('edit/training_internship/{sr_no}','StudentActivitiesController@editTrainingInternshipData');

/*------Published Papers-----*/
    Route::get('published_paper/add','StudentActivitiesController@show_published_paper_form');
    Route::post('published_paper_data','StudentActivitiesController@insertPublishedPaper');

    Route::get('show/published/papers','StudentActivitiesController@show_published_papers');

     //Edit
    Route::get('edit/published_paper/{sr_no}','StudentActivitiesController@editPublishedPaperForm');
    Route::post('edit/published_paper/{sr_no}','StudentActivitiesController@editPublishedPaperData');

// Login Routes...
    Route::get('login', ['as' => 'student.login', 'uses' => 'StudentAuth\LoginController@showLoginForm']);
    Route::post('login', ['uses' => 'StudentAuth\LoginController@login']);
    Route::post('logout', ['as' => 'student.logout', 'uses' => 'StudentAuth\LoginController@logout']);

// Registration Routes...
    Route::get('register', ['as' => 'student.register', 'uses' => 'StudentAuth\RegisterController@showRegistrationForm']);
    Route::post('register', ['uses' => 'StudentAuth\RegisterController@register']);

// Password Reset Routes...
    Route::get('password/reset', ['as' => 'password.reset', 'uses' => 'StudentAuth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/email', ['as' => 'password.email', 'uses' => 'StudentAuth\ForgotPasswordController@sendResetLinkEmail']);
    Route::get('password/reset/{token}', ['as' => 'password.reset.token', 'uses' => 'StudentAuth\ResetPasswordController@showResetForm']);
    Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'StudentAuth\ResetPasswordController@reset']);
});


Route::get('/student/edit',function(){
    return view('Student.student_edit_profile');
});


