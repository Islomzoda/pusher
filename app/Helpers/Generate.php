<?php

namespace App\Helpers;

use App\Models\Client;
use App\Models\Company;
use Carbon\Carbon;

class Generate
{
    static public function save($company_id)
    {
        // Получите список всех клиентов
        $clients = Client::where('company_id', $company_id)->where('status', "!=", 'done')->get();
        // Получите задачи с параметрами, выбранными пользователем
        $task = Company::where('id', $company_id)->first(); // Здесь предполагается, что у вас есть только одна задача
        $startDay = Carbon::parse($task->start_day);
        $selectedDaysOfWeek = json_decode($task->days_of_week, true);
        // Преобразуйте начальное и конечное время в объекты Carbon для клиента
        $times = self::generateUniqueTimes($startDay, $selectedDaysOfWeek, $task->start_time, $task->end_time, $task->interval_min, $task->interval_max,count($clients));
        foreach ($clients as $key => $client) {
            $client->send_at = Carbon::parse($times[$key]);
            $client->status = 'waiting_start';
            $client->save();
        }
        $task->status = 'waiting_start';
        $task->save();
        return back();
    }


    static public function generateUniqueTimes($startDay, $daysOfWeek, $startTime, $endTime, $intervalMinSecond, $intervalMaxSecond, $count) {
        // Массив для хранения уникальных временных меток
        $uniqueTimestamps = [];
        // Переводим дни недели на английский для Carbon
        $daysOfWeekMap = ['пн' => 'понедельник', 'вт' => 'вторник', 'ср' => 'среда', 'чт' => 'четверг', 'пт' => 'пятница', 'сб' => 'суббота', 'вс' => "воскресенье"];
        $daysOfWeek = array_map(function($day) use ($daysOfWeekMap) {
            return $daysOfWeekMap[$day];
        }, $daysOfWeek);
        // Начинаем с указанного дня
        $date = Carbon::parse($startDay)->format('d-m-Y');
        // Если текущий день недели входит в список разрешенных дней недели
        while (true){
            if (in_array(strtolower(Carbon::parse($date)->dayName), $daysOfWeek)) {
                // Начинаем с указанного времени начала
                $time = Carbon::createFromTimeString($startTime);
                while ($time->lessThan(Carbon::createFromTimeString($endTime))) {
                    // Генерируем случайный интервал времени
                    $interval = rand($intervalMinSecond, $intervalMaxSecond);
                    // Добавляем интервал к текущему времени
                    $time->addSeconds($interval);
                    // Формируем уникальную временную метку
                    $timestamp = $date . ' ' . $time->format('H:i:s');
                    // Если такой временной метки еще нет в массиве, добавляем ее
                    if (!in_array($timestamp, $uniqueTimestamps)) {
                        $uniqueTimestamps[] = $timestamp;
                    }
                }
        }
            if (count($uniqueTimestamps) >= $count){
                break;
            }
            $date = Carbon::parse($date)->addDay()->format('d-m-Y');

        }

        return $uniqueTimestamps;
    }


}
