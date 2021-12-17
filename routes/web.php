<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Business\BusinessController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Admin\LetterController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Business\DisputeController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Subscriptions\PaymentController;
use App\Http\Controllers\Business\DisputeEditorController;
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
Route::get('/test', [\App\Http\Controllers\HomeController::class,'apiTest']);
//Route::get('/home', function () {
//    return view('auth.login');
//})->name('home');

//Route::get('/subscribe', [PaymentController::class,'showSubscription']);
//Route::post('/subscribe', [PaymentController::class,'processSubscription']);

Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout');

Route::group(['middleware'=>['auth']], function (){
    Route::get('/subscription/create',  [PaymentController::class, 'index'])->name('subscription.create');
    Route::post('order-post',  [PaymentController::class, 'orderPost'])->name('subscription.store');
});

Route::group(['middleware' => ['admin'], 'prefix' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/client/{id}/delete', [App\Http\Controllers\Admin\ClientController::class, 'destroy'])->name('admin.client.delete');;
    Route::resource('business-clients',\App\Http\Controllers\Admin\BusinessClientController::class,['as' => 'admin']);
    Route::resource('clients',\App\Http\Controllers\Admin\ClientController::class,['as' => 'admin']);
    Route::get('/video/{id}/delete', [VideoController::class, 'destroy']);
    Route::resource('video',VideoController::class,['as' => 'admin']);

    Route::get('/packages', [SubscriptionController::class, 'packages'])->name('admin.packages');
    Route::get('/packages/add', [SubscriptionController::class, 'addPackage']);
    Route::post('/packages/add', [SubscriptionController::class, 'addPackagePost'])->name('admin.add.package.post');
    Route::get('/packages/edit/{id}', [SubscriptionController::class, 'editPackage'])->name('admin.edit.package');
    Route::post('/packages/edit/{id}', [SubscriptionController::class, 'editPackagePost'])->name('admin.edit.package.post');

    Route::get('/letters', [LetterController::class, 'index'])->name('admin.letters.library');
    Route::get('/letters/create', [LetterController::class, 'create']);
    Route::post('/letters', [LetterController::class, 'store']);
    Route::get('/letters/{id}', [LetterController::class, 'show']);
    Route::get('/letters/{id}/edit', [LetterController::class, 'edit']);
    Route::post('/letters/update', [LetterController::class, 'update']);
    Route::get('/letters/{id}/delete', [LetterController::class, 'destroy']);

    Route::get('/letter/flows', [\App\Http\Controllers\Admin\LetterFlowController::class, 'flows'])->name('admin.letter.flows');
    Route::get('/letter/flow/create', [\App\Http\Controllers\Admin\LetterFlowController::class, 'flowCreate'])->name('admin.letter.flow.create');
    Route::post('/letter/flow/create', [\App\Http\Controllers\Admin\LetterFlowController::class, 'flowCreatePost'])->name('admin.letter.flow.create.post');

    Route::get('/keys', [LetterController::class, 'keys'])->name('admin.keys');
    Route::post('/keys', [LetterController::class, 'keysPost'])->name('admin.keys.post');

//    Route::get('/add-client', [AdminController::class, 'addClient'])->name('admin.add.client');
    Route::get('/credit-wizard', [AdminController::class, 'creditWizard'])->name('admin.credit.wizard');
//    Route::get('/letters-library', [AdminController::class, 'lettersLibrary'])->name('admin.letters.library');
//    Route::get('/training-videos', [AdminController::class, 'trainingVideos'])->name('admin.training.videos');
    Route::get('/subscription-forms', [AdminController::class, 'subscriptionForms'])->name('admin.subscription.forms');
    Route::get('/add-subscription', [AdminController::class, 'addSubscriptionForm'])->name('admin.subscription.add');
    Route::get('/subscriptions', [AdminController::class, 'subscriptions'])->name('admin.subscriptions');

    Route::get('/my-profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/my-profile', [AdminController::class, 'profilePost'])->name('admin.profile.post');

    Route::resource('reason',\App\Http\Controllers\Admin\ReasonController::class,['as' => 'admin']);
    Route::get('/reason/{type}/{id}', [\App\Http\Controllers\Admin\ReasonController::class, 'updateReasonStatus'])->where('type', 'checked|un-checked')->name('admin.update.reason.status');

});

Route::group(['middleware' => ['business'], 'prefix' => 'business'], function () {
    Route::get('/', [BusinessController::class, 'index'])->name('business.index');

    Route::get('/profile', [BusinessController::class, 'profile'])->name('business.profile');
    Route::post('/profile', [BusinessController::class, 'profilePost'])->name('business.profile.post');
    Route::get('/dispute-test', [DisputeController::class, 'testDispute'])->name('dispute.test');
    Route::get('/letters-test', [DisputeController::class, 'testLetters'])->name('dispute.letters');
//    Route::get('/', [App\Http\Controllers\Business\HomeController::class, 'index'])->name('business');
    Route::resource('video',\App\Http\Controllers\Business\VideoController::class);
    Route::get('/client/{id}/delete', [App\Http\Controllers\Business\ClientController::class, 'destroy']);
    Route::post('/client/credentials/{id}/update', [App\Http\Controllers\Business\ClientController::class, 'updateClientCredentials'])->name('client.credentials.update');
    Route::get('/client/import/{id}/report', [App\Http\Controllers\Business\ClientController::class, 'clientImportReport'])->name('client.import.report');
    Route::resource('client',\App\Http\Controllers\Business\ClientController::class,['as' => 'business']);
    Route::post('/client/file/upload/{id}', [App\Http\Controllers\Business\ClientController::class, 'uploadClientFile'])->name('business.client.upload.file');

    Route::get('/credit/{id}', [App\Http\Controllers\Business\CreditController::class, 'index'])->name('business.credit.get.profile');
    Route::get('/credit/dispute/{id}/{type}', [App\Http\Controllers\Business\CreditController::class, 'creditDisputeType'])->where('type', 'collections|late_payments')->name('business.credit.dispute.type');
    Route::post('/create/dispute/{id}/{type}', [DisputeController::class, 'createDisputeUpdate'])->where('type', 'collections|late_payments')->name('business.create.dispute');
    Route::get('/credit/module/{id}', [App\Http\Controllers\Business\CreditController::class, 'module']);
    Route::get('/credit/form/{id}', [App\Http\Controllers\Business\CreditController::class, 'form']);
    Route::get('/credit/step-b/{id}', [App\Http\Controllers\Business\CreditController::class, 'stepB']);
    Route::get('/credit/editor/{id}', [App\Http\Controllers\Business\CreditController::class, 'editor']);

    Route::get('/letters', [App\Http\Controllers\Business\LettersController::class, 'index']);
    Route::get('/letters/create', [App\Http\Controllers\Business\LettersController::class, 'create']);
    Route::post('/letters', [App\Http\Controllers\Business\LettersController::class, 'store']);
    Route::get('/letters/{id}', [App\Http\Controllers\Business\LettersController::class, 'show']);
    Route::get('/letters/{id}/edit', [App\Http\Controllers\Business\LettersController::class, 'edit']);
    Route::post('/letters/update', [App\Http\Controllers\Business\LettersController::class, 'update']);
    Route::get('/letters/{id}/delete', [App\Http\Controllers\Business\LettersController::class, 'destroy']);

    Route::get('/letter/flows', [\App\Http\Controllers\Business\LetterFlowController::class, 'flows'])->name('business.letter.flows');
    Route::get('/letter/flow/create', [\App\Http\Controllers\Business\LetterFlowController::class, 'flowCreate'])->name('business.letter.flow.create');
    Route::post('/letter/flow/create', [\App\Http\Controllers\Business\LetterFlowController::class, 'flowCreatePost'])->name('business.letter.flow.create.post');

    Route::get('/calendar', [App\Http\Controllers\Business\CalendarController::class, 'index']);
    Route::get('/financial', [App\Http\Controllers\Business\FinancialController::class, 'index']);
    Route::get('/debt', [App\Http\Controllers\Business\DebtController::class, 'index']);

    Route::post('/reminder', [App\Http\Controllers\Business\ReminderController::class, 'store']);
    Route::post('/reminder/update', [App\Http\Controllers\Business\ReminderController::class, 'update']);
    Route::get('/reminder/delete/{id}', [App\Http\Controllers\Business\ReminderController::class, 'destroy']);

    Route::get('/disputes-status', [DisputeController::class, 'getDisputeStatuses'])->name('business.disputes.status');
    Route::get('/disputes', [DisputeController::class, 'getDisputes'])->name('business.disputes');
    Route::get('/disputes/{unid}', [DisputeEditorController::class, 'getDisputesEditor'])->name('business.get.disputes.editor');
    Route::post('edit/dispute/editor/letter/{id}', [DisputeEditorController::class, 'editDisputeEditorLetterPost'])->name('edit.dispute.editor.letter.post');

    Route::get('/disputes/letter/{id}', [DisputeController::class, 'getDisputeLetter'])->name('get.dispute.letter');

    Route::get('edit/dispute/letter/{id}', [DisputeController::class, 'editDisputeLetter'])->name('edit.dispute.letter');
    Route::post('edit/dispute/letter/{id}', [DisputeController::class, 'editDisputeLetterPost'])->name('edit.dispute.letter.post');


    Route::get('fax/dispute/letter/{id}', [DisputeController::class, 'faxDisputeLetter'])->name('business.fax.dispute.letter');
//    Route::get('/keys', [App\Http\Controllers\Business\LettersController::class, 'keys'])->name('business.keys');
//    Route::post('/keys', [App\Http\Controllers\Business\LettersController::class, 'keysPost'])->name('business.keys.post');

    Route::resource('reason',\App\Http\Controllers\Business\ReasonController::class,['as' => 'business']);
    Route::get('/reason/{type}/{id}', [App\Http\Controllers\Business\ReasonController::class, 'updateReasonStatus'])->where('type', 'checked|un-checked')->name('business.update.reason.status');
});

Route::group(['middleware' => ['client'], 'prefix' => 'client'], function () {
    Route::get('/', [ClientController::class, 'index'])->name('client.index');
    Route::get('/profile', [ClientController::class, 'profile'])->name('client.profile');
    Route::post('/profile', [ClientController::class, 'profilePost'])->name('client.profile.post');

    Route::get('/letter/flows', [\App\Http\Controllers\Client\LetterFlowController::class, 'flows'])->name('client.letter.flows');
    Route::get('/letter/flow/create', [\App\Http\Controllers\Client\LetterFlowController::class, 'flowCreate'])->name('client.letter.flow.create');
    Route::post('/letter/flow/create', [\App\Http\Controllers\Client\LetterFlowController::class, 'flowCreatePost'])->name('client.letter.flow.create.post');

    //    Route::get('/', [App\Http\Controllers\Business\HomeController::class, 'index'])->name('business');
//    Route::resource('video',\App\Http\Controllers\Client\VideoController::class);
//    Route::get('/client/{id}/delete', [App\Http\Controllers\Client\ClientController::class, 'destroy']);
//    Route::resource('client',\App\Http\Controllers\Client\ClientController::class);
//
//    Route::get('/credit/{id}', [App\Http\Controllers\Client\CreditController::class, 'index']);
//    Route::get('/credit/module/{id}', [App\Http\Controllers\Client\CreditController::class, 'module']);
//    Route::get('/credit/form/{id}', [App\Http\Controllers\Client\CreditController::class, 'form']);
//    Route::get('/credit/step-b/{id}', [App\Http\Controllers\Client\CreditController::class, 'stepB']);
//    Route::get('/credit/editor/{id}', [App\Http\Controllers\Client\CreditController::class, 'editor']);
//
    Route::get('/letters', [App\Http\Controllers\Client\LettersController::class, 'index'])->name('client.letters.library');
    Route::get('/letters/create', [App\Http\Controllers\Client\LettersController::class, 'create']);
    Route::post('/letters', [App\Http\Controllers\Client\LettersController::class, 'store']);
    Route::get('/letters/{id}', [App\Http\Controllers\Client\LettersController::class, 'show']);
    Route::get('/letters/{id}/edit', [App\Http\Controllers\Client\LettersController::class, 'edit']);
    Route::post('/letters/update', [App\Http\Controllers\Client\LettersController::class, 'update']);
    Route::get('/letters/{id}/delete', [App\Http\Controllers\Client\LettersController::class, 'destroy']);

    Route::get('/calendar', [\App\Http\Controllers\Client\CalendarController::class, 'index'])->name('client.calendar');
    Route::post('/reminder', [\App\Http\Controllers\Client\CalendarController::class, 'store']);
    Route::post('/reminder/update', [\App\Http\Controllers\Client\CalendarController::class, 'update']);
    Route::get('/reminder/delete/{id}', [\App\Http\Controllers\Client\CalendarController::class, 'destroy']);
    Route::get('/financial', [App\Http\Controllers\Client\FinancialController::class, 'index']);


    Route::get('/credit-profile-dashboard', [ClientController::class, 'creditProfile'])->name('client.credit.profile');
    Route::get('/credit/dispute/{type}', [\App\Http\Controllers\Client\DisputeController::class, 'creditDisputeType'])->where('type', 'collections|late_payments')->name('client.credit.dispute.type');
    Route::post('/create/dispute/{type}', [\App\Http\Controllers\Client\DisputeController::class, 'createDisputeUpdate'])->where('type', 'collections|late_payments')->name('client.create.dispute');
    Route::get('/import/report', [\App\Http\Controllers\Client\DisputeController::class, 'importReport'])->name('import.report');
    Route::get('/disputes', [\App\Http\Controllers\Client\DisputeController::class, 'getDisputes'])->name('client.disputes');
    Route::get('/disputes/letter/{id}', [\App\Http\Controllers\Client\DisputeController::class, 'getDisputeLetter'])->name('client.get.dispute.letter');
    Route::get('edit/dispute/letter/{id}', [\App\Http\Controllers\Client\DisputeController::class, 'editDisputeLetter'])->name('client.edit.dispute.letter');
    Route::post('edit/dispute/letter/{id}', [\App\Http\Controllers\Client\DisputeController::class, 'editDisputeLetterPost'])->name('client.edit.dispute.letter.post');

    Route::get('fax/dispute/letter/{id}', [\App\Http\Controllers\Client\DisputeController::class, 'faxDisputeLetter'])->name('client.fax.dispute.letter');

    Route::get('/disputes/{unid}', [\App\Http\Controllers\Client\DisputeEditorController::class, 'getDisputesEditor'])->name('client.get.disputes.editor');
    Route::post('edit/dispute/editor/letter/{id}', [\App\Http\Controllers\Client\DisputeEditorController::class, 'editDisputeEditorLetterPost'])->name('client.edit.dispute.editor.letter.post');

    Route::resource('reason',\App\Http\Controllers\Client\ReasonController::class,['as' => 'client']);

    Route::post('/client/credentials/update', [ClientController::class, 'updateCredentials'])->name('credentials.update');
    Route::get('/training-videos', [ClientController::class, 'trainingVideos'])->name('client.training.videos');
    Route::get('/training-videos/{id}', [ClientController::class, 'showTrainingVideo'])->name('client.show.training.video');
    Route::get('/financial-calculator', [ClientController::class, 'financialCalculator'])->name('client.financial.calculator');
 //   Route::get('/calendar', [ClientController::class, 'calendar'])->name('client.calendar');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
