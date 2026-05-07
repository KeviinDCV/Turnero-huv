<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$u = App\Models\User::where('nombre_usuario', 'Kechavarro')->first();
if (!$u) {
    echo "NOT_FOUND\n";
    exit(1);
}
$u->password = bcrypt('admin123');
$u->save();
echo "OK: usuario={$u->nombre_usuario} id={$u->id}\n";
