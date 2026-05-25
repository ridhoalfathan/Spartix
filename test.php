<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$req = new Illuminate\Http\Request();
$req->merge([
    'items' => [
        ['barang_id' => 1, 'qty' => 1, 'harga_jual' => 10000]
    ],
    'tanggal_keluar' => date('Y-m-d'),
    'customer' => 'test'
]);

$c = new App\Http\Controllers\BarangKeluarController();

try {
    auth()->loginUsingId(1);
    $res = $c->store($req);
    echo "Status: " . $res->getStatusCode() . "\n";
    $session = $res->getSession();
    if ($session) {
        print_r($session->get('success'));
        print_r($session->get('errors'));
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}
