<?php declare(strict_types=1);

namespace App\Application\Middleware;

use Illuminate\Http\Request;

final class EnsureXmlHttpRequest {

    public function handle(Request $request, $next): mixed {
        if($request->isXmlHttpRequest()) {
            return $next($request);
        }

        return redirect()->back();
    }

}