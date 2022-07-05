<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'dashboard::index',  ['filter' => 'role:admin,bendahara']);
$routes->get('/index', 'dashboard::index', ['filter' => 'role:admin,bendahara']);
$routes->get('/dashboard', 'dashboard::index', ['filter' => 'role:admin,bendahara']);
$routes->get('/dashboard/index', 'dashboard::index', ['filter' => 'role:admin,bendahara']);
$routes->get('/dashboard/persewaan', 'dashboard::persewaan', ['filter' => 'role:admin,bendahara']);
$routes->get('/retribusi/list', 'retribusi::retribusi', ['filter' => 'role:admin,bendahara']);


$routes->get('/jabatan', 'petugas::jabatan', ['filter' => 'role:admin']);
$routes->get('/petugas', 'petugas::index', ['filter' => 'role:admin, bendahara, ketua']);
$routes->get('/petugas/index', 'petugas::index', ['filter' => 'role:admin, ketua']);
$routes->get('/users', 'users::index', ['filter' => 'role:admin']);
$routes->get('/profil/index', 'profil::index', ['filter' => 'role:admin,bendahara']);
$routes->get('/profil/printer', 'profil::printer', ['filter' => 'role:admin']);







// Bendahara-------------------------------------------------------------------------------------------

$routes->get('/pemasukan', 'operasional::pemasukan/', ['filter' => 'role:bendahara']);
$routes->get('/pemasukan/semua', 'operasional::pemasukan/semua', ['filter' => 'role:bendahara']);
$routes->get('/pemasukan/atk', 'operasional::pemasukan/atk', ['filter' => 'role:bendahara']);
$routes->get('/pemasukan/pasar', 'operasional::pemasukan/pasar', ['filter' => 'role:bendahara']);
$routes->get('/pemasukan/umum/', 'operasional::pemasukan/umum', ['filter' => 'role:bendahara']);

$routes->get('/pengeluaran', 'operasional::pengeluaran/', ['filter' => 'role:bendahara']);
$routes->get('/pengeluaran/umum/', 'operasional::pengeluaran/umum', ['filter' => 'role:bendahara']);
$routes->get('/pengeluaran/atk', 'operasional::pengeluaran/atk', ['filter' => 'role:bendahara']);
$routes->get('/pengeluaran/pasar', 'operasional::pengeluaran/pasar', ['filter' => 'role:bendahara']);
$routes->get('/pengeluaran/semua', 'operasional::pengeluaran/semua', ['filter' => 'role:bendahara']);






$routes->get('/laporan/penjualan/harian', 'laporan/Penjualan::harian');
$routes->get('/laporan/penjualan/bulanan', 'laporan/Penjualan::bulanan');
$routes->get('/laporan/penjualan/tahunan', 'laporan/Penjualan::tahunan');
$routes->get('/laporan/penjualan/data_harian', 'laporan/Penjualan::data_harian');
$routes->get('/laporan/penjualan/data_bulanan', 'laporan/Penjualan::data_bulanan');
$routes->get('/laporan/penjualan/data_tahunan', 'laporan/Penjualan::data_tahunan');
$routes->get('/laporan/penjualan/periode', 'laporan/Penjualan::periode');


$routes->get('/laporan/penjualan_produk/harian', 'laporan/Penjualan::produk_harian');
$routes->get('/laporan/penjualan_produk/bulanan', 'laporan/Penjualan::produk_bulanan');
$routes->get('/laporan/penjualan_produk/tahunan', 'laporan/Penjualan::produk_tahunan');
$routes->get('/laporan/penjualan/data_produk_harian', 'laporan/Penjualan::data_produk_harian');
$routes->get('/laporan/penjualan/data_produk_bulanan', 'laporan/Penjualan::data_produk_bulanan');
$routes->get('/laporan/penjualan/data_produk_tahunan', 'laporan/Penjualan::data_produk_tahunan');


$routes->get('/laporan/pembelian/index', 'laporan/pembelian::index');
$routes->get('/laporan/pembelian', 'laporan/pembelian::index');
$routes->get('/laporan/pembelian/data_pembelian', 'laporan/pembelian::data_pembelian');
$routes->get('/laporan/pembelian/per_produk', 'laporan/pembelian::produk');
$routes->get('/laporan/pembelian/data_produk', 'laporan/pembelian::data_produk');

$routes->get('/laporan/piutang/index', 'laporan/piutang::index');
$routes->get('/laporan/piutang', 'laporan/piutang::index');
$routes->get('/laporan/piutang/data_piutang', 'laporan/piutang::data_piutang');
$routes->get('/laporan/pembelian/per_produk', 'laporan/pembelian::produk');
$routes->get('/laporan/pembelian/data_produk', 'laporan/pembelian::data_produk');

$routes->get('/laporan/hutang/index', 'laporan/hutang::index');
$routes->get('/laporan/hutang', 'laporan/hutang::index');
$routes->get('/laporan/hutang/data_hutang', 'laporan/hutang::data_hutang');
$routes->get('/laporan/pembelian/per_produk', 'laporan/pembelian::produk');
$routes->get('/laporan/pembelian/data_produk', 'laporan/pembelian::data_produk');


$routes->get('/laporan/sewa/index', 'laporan/persewaan::index');
$routes->get('/laporan/sewa', 'laporan/persewaan::index');
$routes->get('/laporan/sewa/data_sewa', 'laporan/persewaan::data_sewa');
$routes->get('/laporan/sewa/pajak_bulanan', 'laporan/persewaan::pajak_bulanan');
$routes->get('/laporan/sewa/data_pajak_bulanan', 'laporan/persewaan::data_pajak_bulanan');

$routes->get('/laporan/retribusi/', 'laporan/retribusi::index');
$routes->get('/laporan/retribusi/index', 'laporan/retribusi::index');
$routes->get('/laporan/retribusi/data_retribusi', 'laporan/retribusi::data_retribusi');

$routes->get('/laporan/in_out/', 'laporan/in_out::index');
$routes->get('/laporan/in_out/data_in_out', 'laporan/in_out::data');

$routes->get('/laporan/laba/', 'laporan/laba::index');
$routes->get('/laporan/laba/data', 'laporan/laba::data');

$routes->get('/laporan/saldo/', 'laporan/saldo::index');
$routes->get('/laporan/saldo/data', 'laporan/saldo::data');


$routes->get('/laporan/keuangan/', 'laporan/keuangan::index');
$routes->get('/laporan/keuangan/data', 'laporan/keuangan::data');



// $routes->get('/penjualan/index', 'Penjualan::index');
$routes->get('/penjualan', 'Penjualan::index', ['filter' => 'role:bendahara,atk']);
$routes->get('/piutang_penjualan_atk', 'Penjualan::piutang', ['filter' => 'role:bendahara,atk']);

$routes->get('/pembelian', 'pembelian::index', ['filter' => 'role:bendahara,atk']);
$routes->get('/hutang_pembelian_atk', 'pembelian::hutang', ['filter' => 'role:bendahara,atk']);


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
