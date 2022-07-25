<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Jobs\FinanceExport;

class ExportController extends Controller
{
    public function export_deals()
    {
        FinanceExport::dispatch();
        Log::debug('Queued FinanceExport job');

        return response('OK', 200);
    }
}
