<?php

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    // $exitCode = Artisan::call('migrate');
    $exitCode = Artisan::call('storage:link');
    return 'DONE'; //Return anything
});
// Route::redirect('/', '/login');
// BEGIN FRONTEND
Route::get('/',function () {
    return view('frontend.home');
});
Route::group(['namespace' => 'Frontend'], function () {
    Route::get('/certificate-page', 'CertificateController@getCertificateView')->name('certificate.page');
    Route::get('/certificate/search', 'CertificateController@search')->name('certificate.search');
    Route::get('/contact-us', 'ContactController@index')->name('contact.page');
    Route::post('/contact', 'ContactController@submit')->name('contact.submit');
    Route::get('/notice-page', 'ContactController@noticePage')->name('notice.page');
    Route::get('/events-page', 'ContactController@eventPage')->name('events.page');
    Route::get('/gallery-page', 'ContactController@galleryPage')->name('gallery.page');
    Route::get('/director-page', 'ContactController@directorPage')->name('director.page');
    Route::get('/about-page', 'ContactController@aboutPage')->name('about.page');
    Route::get('/course/{id}', 'ContactController@coursePage')->name('course.page');
    Route::get('/admission', 'ContactController@admissionPage')->name('admission.page');
    Route::get('/blog-details/{slug}', 'ContactController@blogDetailsPage')->name('blog.details');
    Route::get('/download-regular-certificate/{id}', 'CertificateController@downloadRegularCertificate')->name('download.regularCertificate');
    Route::get('/download-test-certificate/{id}', 'CertificateController@downloadTestCertificate')->name('download.testCertificate');

});


// END FRONTEND
// BEGIN BACKEND
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::resource('permissions', 'PermissionsController');
    Route::get('allPermissions', 'PermissionsController@getAll')->name('allPermissions');

    // Roles
    Route::resource('roles', 'RolesController');
    Route::get('allRoles', 'RolesController@getAll')->name('allRoles');

    // Users
    Route::resource('users', 'UsersController');
    Route::get('/allUser', 'UsersController@getAll')->name('allUser.users');

    // Course
    Route::resource('courses', 'CourseController');
    Route::get('/allCourse', 'CourseController@getAll')->name('allCourse.courses');

    // Certificate
    Route::resource('certificates', 'CertificateController');
    Route::get('/allCertificate', 'CertificateController@getAll')->name('allCourse.certificates');

    // Web setting slider
    Route::resource('sliders', 'SliderController');
    Route::get('/allSliders', 'SliderController@getAll')->name('allSliders.sliders');
    // Director Section
    Route::resource('director-sections', 'DirectorSectionController');
    Route::get('/allDirectors', 'DirectorSectionController@getDirectorSection')->name('allDirector.section');
    // About Section
    Route::resource('about-sections', 'AboutSectionController');
    Route::get('/allAbouts', 'AboutSectionController@getAboutSection')->name('allAbout.section');
     // Admission Section
     Route::resource('admission-sections', 'AdmissionController');
     Route::get('/allAdmissions', 'AdmissionController@getAdmissionSection')->name('allAdmission.section');
    // Student manage
    Route::resource('students', 'StudentController');
    Route::get('/allStudent', 'StudentController@getAll')->name('allStudent.students');
    Route::get('/get-all-students', "StudentController@getAllStudents");
    Route::get('/get-batch-students', "StudentController@getBatchStudents");
    // Teacher manage
    Route::resource('teachers', 'TeacherController');
    Route::get('/allTeacher', 'TeacherController@getAll')->name('allTeacher.teachers');
     // Notice manage
     Route::resource('notices', 'NoticeController');
     Route::get('/allNotice', 'NoticeController@getAll')->name('allNotice.notices');
      // Events manage
      Route::resource('events', 'EventController');
      Route::get('/allEvent', 'EventController@getAll')->name('allEvent.events');
    // Gallery manage
    Route::resource('galleries', 'GalleryController');
    Route::get('/allGallery', 'GalleryController@getAll')->name('allGallery.galleries');
    //Partner Logo
    Route::resource('partner-logo', 'PartnerLogoController');
    Route::get('/allPartnerLogo', 'PartnerLogoController@getAll')->name('allPartnerLogo.partnerLogo');
    //Blog
    Route::resource('blogs', 'BlogController');
    Route::get('/allBlog', 'BlogController@getAll')->name('allBlog.blog');

    Route::resource('batch', 'BatchController');
    Route::get('/allBatch', 'BatchController@getAll')->name('allBatch.batches');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('/profile-change', 'ChangePasswordController@profile')->name('profile');
        Route::get('/edit_profile', 'ChangePasswordController@edit')->name('edit');
        Route::patch('/edit_profile', 'ChangePasswordController@update')->name('update');

        Route::get('/change_password', 'ChangePasswordController@change_password')->name('password_change');
        Route::patch('/change_password', 'ChangePasswordController@update_password')->name('change_password');
    }
});
// END BACKEND
