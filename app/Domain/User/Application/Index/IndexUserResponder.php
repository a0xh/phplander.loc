<?php declare(strict_types=1);

namespace App\Domain\User\Application\Index;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\View;

final readonly class IndexUserResponder
{
    public function handle(LengthAwarePaginator $users): \Illuminate\View\View
    {
        return View::make('admin::user.index', ['users' => $users]);
    }
}
