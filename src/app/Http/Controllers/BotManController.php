<?php

namespace App\Http\Controllers;

use App\Domain\BotMan\Services\BotManHandleProcessRequest;

class BotManController extends Controller
{
    public function handle()
    {
        app(BotManHandleProcessRequest::class)->run();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('tinker');
    }
}
