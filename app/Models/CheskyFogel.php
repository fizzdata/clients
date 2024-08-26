<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheskyFogel extends Model
{
    use HasFactory;

    public static function e_to_y_date($date)
    {

        #explode date from string   
        list($gregorianYear, $gregorianMonth, $gregorianDay) = explode('-', $date);

        #convert to a Julian Day Count
        $jdDate = gregoriantojd($gregorianMonth, $gregorianDay, $gregorianYear);

        #Get Heabrew Month Name
        $hebrewMonthName = jdmonthname($jdDate, 4);

        #Get Hebrew date ##/##/####
        $hebrewDate = jdtojewish($jdDate);

        list($hebrewMonth, $hebrewDay, $hebrewYear) = explode('/', $hebrewDate);

        return  $hebrewDay . ' ' . $hebrewMonthName . ' ' . $hebrewYear;
    }

    public static function get_y_date($date)
    {

        $singel_date = explode('-', $date);
        $j1_date = gregoriantojd($singel_date[1], $singel_date[2], $singel_date[0]);
        $j2_date = jdtojewish($j1_date, true, CAL_JEWISH_ADD_GERESHAYIM);
        $final_date = iconv('WINDOWS-1255', 'UTF-8', $j2_date);


        return $final_date;
    }

    public static function y_day_of_week($day)
    {
        $y_day = '';

        switch ($day) {
            case 'Sunday':
                $y_day = "זונטאג";
                break;
            case 'Monday':
                $y_day = "מאנטאג";
                break;
            case 'Tuesday':
                $y_day = "דינסטאג";
                break;
            case 'Wednesday':
                $y_day = "מיטוואך";
                break;
            case 'Thursday':
                $y_day = "דאנערשטאג";
                break;
            case 'Friday':
                $y_day = "פרייטאג";
                break;
            case 'Saturday':
                $y_day = "שב''ק";
                break;
        }
        return $y_day;
    }

    public static function parsha($date)
    {

        $ch = curl_init();

        $url = "https://www.hebcal.com/hebcal?v=1&cfg=json&ss=on&s=on&start=" . $date . "&end=" . $date;


        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);

        $response = curl_exec($ch);

        dump($response);

        if (curl_error($ch)) {
            return 'Request Error:' . curl_error($ch);
        } else {
            $response = json_decode($response, true);

            if (! empty($response['items'])):
                return $response['items'][0]['hebrew'];
            endif;
        }

        curl_close($ch);
    }

    public static function yom_tov($date)
    {

        $ch = curl_init();

        $url = "https://www.hebcal.com/hebcal?v=1&cfg=json&maj=on&min=on&nx=on&ss=on&start=" . $date . "&end=" . $date;


        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);

        $response = curl_exec($ch);

        dump('url: ' . $url . ', Response : ' . $response);

        if (curl_error($ch)) {
            return 'Request Error:' . curl_error($ch);
        } else {
            $response = json_decode($response, true);

            if (! empty($response['items'])):
                return $response['items'][0]['hebrew'];
            else:
                return '';
            endif;
        }

        curl_close($ch);
    }
}
