<?php

use App\Http\Controllers\Send;
use Illuminate\Support\Facades\DB;
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

Route::get('/', function () {
    return redirect('http://kuystudio.id');
});
Route::get('/test', function () {
    $router = DB::table('settings')->where('name', 'email_router')->value('value');
    if ($router == 0) {
        $new_value = 1;
    } else {
        $new_value = 0;
    }
    // update
    DB::table('settings')->where('name', 'email_router')->update(['value' => $new_value, 'updated_at' => date("Y-m-d H:i:s")]);
    return 'Value before: ' . $router . ' <br/><br/> New Value: ' . $new_value;
});
