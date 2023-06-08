 <?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReservationConfirmationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BarcodeController;

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
    return view('home', ['title' => 'Home']);
})->name('home');

Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('register', [UserController::class, 'register_action'])->name('register.action');
Route::get('login', [UserController::class, 'login'])->name('login');
Route::post('login', [UserController::class, 'login_action'])->name('login.action');
Route::get('password', [UserController::class, 'password'])->name('password');
Route::post('password', [UserController::class, 'password_action'])->name('password.action');
Route::get('logout', [UserController::class, 'logout'])->name('logout'); 




Route::get('/student', [StudentController::class, 'index'])->name('student.index');

Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
Route::post( '/student', [StudentController::class, 'store'])->name('student.store');


Route::get( '/student/{id}',  [StudentController::class, 'update'])->name('student.update');



//route to destroy/delete data
Route::delete( '/student/{id}', [StudentController::class, 'destroy'])->name('student.destroy');

//route for exporting the table to excel
Route::get('/student/export', [StudentController::class, 'export'])->name('student.export');



Route::get('/scan', [BarcodeController::class, 'index'])->name('scan.form');
Route::post('/scan', [BarcodeController::class, 'scan'])->name('scan.scan');
Route::get('/scans', [BarcodeController::class, 'showScans'])->name('scan.results');




