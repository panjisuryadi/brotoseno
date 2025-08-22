<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class UseTenantConnection
{
    public function handle($request, Closure $next)
    {
        $t = session('tenant_db');                  // dari LoginController
        if (!$t || empty($t['database'])) {
            return $next($request);                 // belum login / belum set tenant → tetap central
        }

        // Ambil nilai default dari koneksi central (mysql/.env)
        $central = config('database.connections.mysql');

        $host = $t['host'] ?? ($central['host'] ?? '127.0.0.1');
        $port = $t['port'] ?? ($central['port'] ?? 3306);
        $user = (!empty($t['username'])) ? $t['username'] : ($central['username'] ?? 'root');

        // ⚠️ KUNCI: kalau session punya key 'password' tapi nilainya ''/null,
        //          JANGAN kirim kosong — fallback ke central password (admin)
        $pass = (array_key_exists('password', $t) && $t['password'] !== '' && $t['password'] !== null)
            ? $t['password']
            : ($central['password'] ?? '');

        Config::set('database.connections.tenant', [
            'driver'    => 'mysql',
            'host'      => $host,
            'port'      => $port,
            'database'  => $t['database'],
            'username'  => $user,
            'password'  => $pass,
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
            'strict'    => true,
        ]);

        DB::purge('tenant');
        DB::reconnect('tenant');
        Config::set('database.default', 'tenant');

        if (Auth::check()) {
            $u = Auth::user();
            $u->setConnection('tenant');
            foreach ($u->getRelations() as $k => $v) $u->unsetRelation($k);
            Auth::setUser($u);
        }
        return $next($request);
    }
}
