<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/admin', 'AdminController@getLogin');
Route::get('/admin/register', 'AdminController@getRegister');
Route::post('/admin/panel', 'AdminController@postLogin')->name('login');
Route::post('/admin/register', 'AdminController@postRegister')->name('register');
Route::group(['middleware' => ['auth']], function () {
	Route::get('/admin/dashboard', 'AdminController@getDashboard')->name('admin-dashboard');
	Route::get('/admin/tours-categories', 'TourCategoryController@adminGetTourCategories')->name('admin-tours-categories');
    Route::get('/admin/tours-list', 'TourController@adminGetToursList')->name('admin-tours-list');
	Route::get('/admin/new-category', 'TourCategoryController@adminGetNewCategory')->name('admin-new-category');
	Route::get('/admin/edit-category/{category_id}', 'TourCategoryController@adminGetEditCategory');
	Route::post('/admin/new-category', 'TourCategoryController@adminPostNewCategory')->name('admin-post-new-category');
	Route::get('/admin/hotels', 'HotelController@adminGetHotels')->name('admin-hotels');
	Route::get('/admin/new-hotel', 'HotelController@adminGetNewHotel')->name('admin-new-hotel');
	Route::post('/admin/new-hotel', 'HotelController@adminPostNewHotel')->name('admin-post-new-hotel');
	Route::get('/admin/new-tour', 'TourController@adminGetNewTour')->name('admin-new-tour');
	Route::post('/admin/new-tour', 'TourController@adminPostNewTour')->name('admin-post-new-tour');
    Route::get('/admin/edit-tour/{tour_id}', 'TourController@adminGetEditTour');
    Route::post('/admin/edit-tour/', 'TourController@adminPostNewTour');
    Route::post('/admin/remove-image', 'AdminController@adminAjaxDeleteImage');
    Route::get('/admin/edit-hotel/{hotel_id}', 'HotelController@adminGetEditHotel');
    Route::post('/admin/edit-hotel/', 'HotelController@adminPostNewHotel');

    Route::get('/admin/galleries', 'GalleryController@adminGetGalleries')->name('admin-get-galleries');
    Route::get('/admin/edit-gallery/{gallery_id}', 'GalleryController@adminGetEditGallery')->name('admin-edit-gallery');
    Route::get('/admin/new-gallery', 'GalleryController@adminGetNewGallery')->name('admin-new-gallery');
    Route::post('/admin/new-gallery', 'GalleryController@adminPostNewGallery')->name('admin-post-new-gallery');

    Route::get('/admin/photo-gallery', 'PhotoGalleryController@adminGetPhotoGallery')->name('admin-photo-gallery');
    Route::post('/admin/photo-gallery', 'PhotoGalleryController@adminPostPhotoGallery')->name('admin-post-photo-gallery');
    Route::get('/admin/video-gallery', 'VideoGalleryController@adminGetVideoGallery')->name('admin-video-gallery');
    Route::get('/admin/new-video', 'VideoGalleryController@adminGetNewVideo')->name('admin-new-video');
    Route::post('/admin/new-video', 'VideoGalleryController@adminPostNewVideo')->name('admin-post-new-video');
    Route::get('/admin/edit-video/{video_id}', 'VideoGalleryController@adminGetEditVideo');
    Route::get('/admin/new-custom-tour', 'TourController@adminGetNewCustomTour')->name('admin-new-custom-tour');
    Route::post('/admin/new-custom-tour', 'TourController@adminPostNewCustomTour')->name('admin-post-new-custom-tour');
    Route::get('/admin/edit-custom-tour/{tour_id}', 'TourController@adminGetEditCustomTour');
    Route::post('/admin/remove-data', 'AdminController@adminAjaxRemoveData');
    Route::get('/admin/pages', 'PageController@adminGetPagesList')->name('admin-pages-list');
    Route::get('/admin/new-page', 'PageController@adminGetNewPage')->name('admin-new-page');
    Route::post('/admin/new-page', 'PageController@adminPostNewPage')->name('admin-post-new-page');
    Route::get('/admin/edit-page/{page_id}', 'PageController@adminGetEditPage')->name('admin-edit-page');
    Route::get('/admin/pdf', 'DownloadPDFController@adminGetPDFListPage')->name('admin-pdf-list');
    Route::get('/admin/new-pdf', 'DownloadPDFController@adminGetNewPDF')->name('admin-new-pdf');
    Route::post('/admin/new-pdf', 'DownloadPDFController@adminPostNewPDF')->name('admin-post-new-pdf');
    Route::get('/admin/edit-pdf/{file_id}', 'DownloadPDFController@adminGetEditPDF')->name('admin-edit-pdf');
    Route::get('/admin/guide-list', 'GuideController@adminGetGuideList')->name('admin-guide-list');
    Route::get('/admin/new-guide', 'GuideController@adminGetNewGuide')->name('admin-new-guide');
    Route::post('/admin/new-guide', 'GuideController@adminPostNewGuide')->name('admin-post-new-guide');
    Route::get('/admin/edit-guide/{guide_id}', 'GuideController@adminGetEditGuide')->name('admin-edit-guide');
    Route::get('/admin/settings', 'AdminController@adminGetSettings')->name('admin-settings');
    Route::post('/admin/update-currencies', 'AdminController@adminPostUpdateCurrencies')->name('admin-post-update-currencies');
    Route::post('/admin/reset-password', 'AdminController@adminPostResetPassword')->name('admin-post-reset-password');
    Route::get('/admin/logout', 'AdminController@adminLogout')->name('admin-logout');


});

Route::group(['middleware' => ['language']], function () {

    Route::get('/', 'PageController@getIndexPage');
    Route::get('set_lang/{lang}', 'LanguageController@setLanguage');
    Route::get('/x_cat/{category_id}', 'TourController@ajaxGetToursByCategory');
    Route::get('/set_cur/{cur}', 'CurrencyController@setCurrency');
    Route::get('/tours/{tour_url}', 'TourController@getTourByUrl');
    Route::get('/tours', 'TourController@getTours');
    Route::get('/hotels', 'HotelController@getHotels');
    Route::get('/hotels/{hotel_url}', 'HotelController@getHotelByUrl');
    Route::get('/video_gallery', 'VideoGalleryController@getVideoGallery');
    Route::get('/galleries', 'GalleryController@getGalleries');
    Route::get('/portfolio', 'GalleryController@getPortfolios');
    Route::get('/portfolio/{url}', 'GalleryController@getPortfolioByUrl');
    Route::get('/gallery/{url}', 'GalleryController@getGalleryByUrl');
    Route::get('/catalogue', 'DownloadPDFController@getCatalogs');
    Route::get('/contacts', 'ContactController@getContacts');
    Route::post('/contacts', 'ContactController@postContacts');
    Route::post('/main_search', 'TourController@postSearchTours');
    Route::post('/tour_detail_search', 'TourController@postSearchCustomTour');
    Route::post('/order_tour', 'TourController@postOrderTour');

    Route::get('/{page_url}', 'PageController@getPageByUrl');
});