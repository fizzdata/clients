<?php

namespace App\Http\Controllers;

use DatePeriod;
use DateInterval;
use Nette\Utils\DateTime;
use App\Models\CheskyFogel;
use App\Exports\exportDates;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CheskyFogelController extends Controller
{
    function export_date()
    {
        return Excel::download(new ExportDates('2024-10-06', '2024-11-10'), 'dates.xlsx');
    }
}
