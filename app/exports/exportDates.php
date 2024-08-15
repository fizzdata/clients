<?php

namespace App\Exports;

use DatePeriod;
use DateInterval;
use App\Models\CheskyFogel;
use Nette\Utils\DateTime;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportDates implements FromCollection, WithHeadings
{

    protected $date_from;
    protected $date_to;


    function __construct($date_from, $date_to)
    {

        $this->date_from = $date_from;

        $this->date_to = $date_to;
    }

    public function collection()
    {

        // Define start and end dates
        $startDate = new DateTime($this->date_from);
        $endDate = new DateTime($this->date_to);

        // Create DatePeriod object
        $interval = new DateInterval('P1D');

        // 1 day interval
        $dateRange = new DatePeriod($startDate, $interval, $endDate->modify('+1 day'));

        // Collect dates in an array
        $dates = [];
        $i = 0;

        foreach ($dateRange as $date) {
            //$date->format('Y-m-d');
            $dates[$i][$date->format('l') . ' day'] = $date->format('l') . ' - ' . CheskyFogel::y_day_of_week($date->format('l'));


            $dates[$i][$date->format('l') . ' english'] = $date->format('F j, y');
            $dates[$i][$date->format('l') . ' yiddish'] = CheskyFogel::get_y_date($date->format('Y-m-d'));

            if ($date->format('l') == 'Saturday'):
                $dates[$i][$date->format('l') . ' Parsha'] = CheskyFogel::parsha($date->format('Y-m-d'));
                $i = $i + 1;
            endif;
        }

        // Print the array of dates
        print_r($dates);
        die();

        return collect($dates);
    }

    public function headings(): array
    {
        return [
            "Sunday day",
            "Sunday english",
            "Sunday yiddish",
            "Monday day",
            "Monday english",
            "Monday yiddish",
            "Tuesday day",
            "Tuesday english",
            "Tuesday yiddish",
            "Wednesday day",
            "Wednesday english",
            "Wednesday yiddish",
            "Thursday day",
            "Thursday english",
            "Thursday yiddish",
            "Friday day",
            "Friday english",
            "Friday yiddish",
            "Saturday day",
            "Saturday english",
            "Saturday yiddish",
        ];
    }
}
