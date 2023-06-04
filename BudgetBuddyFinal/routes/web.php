<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Tarjeta;
use App\Http\Controllers\TarjetaController;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\GastoController;
use Illuminate\Support\Facades\DB;
use App\Models\Ingreso;
use App\Models\Gasto;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CuentaBancariaController;
use App\Models\Transferencia;
use App\Http\Controllers\TransferenciaController;
use App\Http\Controllers\TransaccionController;
use App\Models\CuentaBancaria;
use Illuminate\Support\Facades\Artisan;

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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

//Chart

Route::get('/ingresos-chart-data', function () {
    $data = Ingreso::select('monto', 'fecha')
        ->orderBy('fecha', 'asc')
        ->get();

    return response()->json($data);
});

Route::get('/gastos-chart-data', function () {
    $data = Gasto::select('monto', 'fecha')
        ->orderBy('fecha', 'asc')
        ->get();

    return response()->json($data);
});
// CHARTJS

// Route::get('/gi-total-chart', [CuentaBancariaController::class, 'GastoIngresoTotal']);

Route::get('/pie-chart', function(){
    $userId = Auth::id();
    $data = [
        'gastos' => Gasto::where('usuario_id', $userId)->sum('monto'),
        'ingresos' => Ingreso::where('usuario_id', $userId)->sum('monto'),
    ];
    return response()->json($data);

});

Route::get('/cuenta-chart-data', function () {
    $userId = Auth::id(); // Obtener el ID del usuario autenticado
    $data = CuentaBancaria::select('monto', 'created_at')
        ->where('usuario_id', $userId) // Filtrar por el ID del usuario
        ->orderBy('created_at', 'asc')
        ->get();

    return response()->json($data);
})->middleware('auth');
//

Route::get('/api/ingresos-events', [CalendarController::class, 'getIngresosEvents']);
Route::get('/api/gastos-events', [CalendarController::class, 'getGastosEvents']);

Route::get('/events', function () {
    return Inertia::render('Events');
})->middleware(['auth', 'verified'])->name('events');


Route::get('/ingresos-json', [IngresoController::class, 'getIngresosAsJson']);


Route::get('/', function () {
    if (auth()->check()) {
        return Inertia::render('Dashboard');
    } else {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
});

Route::post('/guardar-datos', [CuentaBancariaController::class, 'store'])->name('guardar-datos');
// Ingresos
Route::get('/ingresos-json', [IngresoController::class, 'index'])->name('ingresos.index');

Route::get('/incomes/{ingreso}', [IngresoController::class, 'show'])->name('ingresos.show');
Route::post('/incomes/add-income', [IngresoController::class, 'store'])->name('ingresos.store');
Route::put('/incomes-update/{id}', [IngresoController::class, 'update'])->name('ingresos.update');
Route::get('/incomes-destroy/{id}', [IngresoController::class, 'destroy'])->name('ingresos.destroy');


Route::get('/RegisterCuenta', function () {
    return Inertia::render('RegisterCuenta');
})->middleware(['auth', 'verified'])->name('registercuenta');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/RegisterCuenta', function () {
    return Inertia::render('RegisterCuenta');
})->middleware(['auth', 'verified'])->name('registercuenta');


// Obtener JSON
Route::get('/ingresos-json', [IngresoController::class, 'index'])->name('ingresos.index');
Route::get('/gastos-json', [GastoController::class, 'index'])->name('gastos.index');

Route::get('/balance-cuenta-json', [CuentaBancariaController::class, 'balanceCuenta'])->name('cuentas.balanceCuenta');

// Botón DB SEED
Route::post('/db-seed', function () {
    Artisan::call('db:seed');
    return redirect('/dashboard');
})->middleware(['auth', 'verified'])->name('db-seed');

Route::get('/total-gastos-json', [GastoController::class, 'sumaTotal'])->name('gastos.sumaTotal');

Route::get('/gastos-pdf', [GastoController::class, 'exportarPDF'])->name('gastos.pdf');

Route::get('/ingresos-pdf', [IngresoController::class, 'exportarPDF'])->name('ingresos.pdf');

Route::get('/ingresos-excel', [IngresoController::class, 'exportarExcel'])->name('ingresos.excel');

Route::get('/gastos-excel', [GastoController::class, 'exportarExcel'])->name('gastos.excel');

Route::get('/total-ingresos-json', [IngresoController::class, 'sumaTotal'])->name('ingresos.sumaTotal');

Route::get('/tarjetas-json', [TarjetaController::class, 'index'])->name('tarjetas.index');

Route::get('/cuentas-json', [CuentaBancariaController::class, 'index'])->name('cuentas.index');

Route::get('/expenses', function () {
    return Inertia::render('Expenses');
})->middleware(['auth', 'verified'])->name('expenses');

Route::get('/expenses/{gasto}', [GastoController::class, 'show'])->name('gastos.show');
Route::post('/expenses/add-expense', [GastoController::class, 'store'])->name('gastos.store');
Route::put('/expenses/update/{id}', [GastoController::class, 'update'])->name('gastos.update');
Route::get('/expenses/destroy/{id}', [GastoController::class, 'destroy'])->name('gastos-destroy');

Route::get('/incomes', function () {
    return Inertia::render('Incomes');
})->middleware(['auth', 'verified'])->name('incomes');

Route::get('/incomes/{ingreso}', [IngresoController::class, 'show'])->name('ingresos.show');
Route::post('/incomes/add-income', [IngresoController::class, 'store'])->name('ingresos.store');
Route::put('/incomes/update/{id}', [IngresoController::class, 'update'])->name('ingresos.update');
Route::get('/incomes/edit/{id}', [IngresoController::class, 'edit'])->name('ingresos-edit');
Route::get('/incomes/destroy/{id}', [IngresoController::class, 'destroy'])->name('ingresos-destroy');

// Transacciones
Route::get('/transacciones', function () {
    return Inertia::render('Transacciones');
})->middleware(['auth', 'verified'])->name('transacciones');

Route::post('/transacciones/add-transaccion', [TransaccionController::class, 'transferir'])->name('transaccion.transferir');

Route::get('/transacciones-json', [TransaccionController::class, 'index'])->name('transaccion.index');

// Route::post('/transacciones/realizar-transferencia', [TransferenciaController::class, 'transferir'])->name('transacciones.transferir');
// Route::post('/transacciones/add-transaccion', [TransferenciaController::class, 'transferir'])->name('transacciones.transferir');

Route::get('/cuentas-bancarias', function () {
    return Inertia::render('BankAccounts');
})->middleware(['auth', 'verified'])->name('cuentas-bancarias');

Route::get('/my-cards', function () {
    return Inertia::render('MyCards');
})->middleware(['auth', 'verified'])->name('my-cards');

Route::get('/my-cards', function () {
    $user = Auth::user();
    $tarjetas = Tarjeta::where('usuario_id', $user->id)->get();
    // $tarjetas = Tarjeta::all();
    return Inertia::render('MyCards', ['tarjeta' => $tarjetas]);
})->middleware(['auth', 'verified'])->name('my-cards');


Route::post('/my-cards/add-card', [TarjetaController::class, 'store'])->name('tarjetas.store');

// Eliminar tarjetas
Route::get('/my-cards/destroy/{id}', [TarjetaController::class, 'destroy'])->name('tarjetas-destroy');

// Route::get('/my-cards/edit/{id}', [TarjetaController::class, 'update'])->name('tarjetas-edit');


// PRUEBAS
// Route::get('/tarjetas', [TarjetaController::class, 'index']);
// Route::get('/pruebas', function () {
//     return Inertia::render('Tarjeta');
// })->middleware(['auth', 'verified'])->name('tarjeta-todas');


// END PRUEBAS
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// RUTAS DEL LANDING PAGE
Route::get('/about-us', function () {
    return Inertia::render('About', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/contact', function () {
    return Inertia::render('Contact');
});
Route::get('/blog', function () {
    return Inertia::render('Blog');
});

// AUTHENTICATION USING LARAVEL SOCIALITE
Route::get('/login-google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/google-callback', function () {
    $user = Socialite::driver('google')->user();
    // dd($user);
    // Usamos el campo id que acabamos de crear
    $userExists = User::where('external_id', $user->id)->where('external_auth', 'google')->first();
    // Consulta a la base de datos para buscar un registro en la tabla "User" que tenga un valor "external_id" igual a $user->id y un valor "external_auth" igual a "google"

    // "first" se utiliza para obtener el primer registro que cumpla con las condiciones

    // Si un registro coincide con los valores proporcionados, se almacenará en la variable "$userExists"

    if ($userExists) {
        // Si existe el usuario, hacemos login
        Auth::login($userExists);
        return redirect('/dashboard');
        # code...
    } else {
        // Si no, creamos el usuario
        $userNew = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'external_id' => $user->id,
            'external_auth' => 'google'
        ]);
        Auth::login($userNew);
    }
    // return redirect('/dashboard');
    return redirect('/RegisterCuenta');
    // $user->token
});

// GITHUB
Route::get('/login-github', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('/github-callback', function () {
    $user = Socialite::driver('github')->user();
    $userExists = User::where('external_id', $user->id)->where('external_auth', 'github')->first();

    if ($userExists) {
        // Si existe el usuario, hacemos login
        Auth::login($userExists);
        return redirect('/dashboard');
        # code...
    } else {
        $userNew = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'external_id' => $user->id,
            'external_auth' => 'github'
        ]);
        Auth::login($userNew);
    }

    // dd($user);

    // $user->token
    return redirect('/RegisterCuenta');
});

require __DIR__ . '/auth.php';
