<?php

namespace App\Helpers;

class Status
{
    static public function company($status): string
    {
        switch ($status){
            case 'new':
                return 'Новый';
            case 'waiting_start':
                return 'Ожидает запуска';
            case 'stopped':
                return 'Приостановлено';
            case 'dispatching':
                return 'Рассылается';
            case 'error_phone_banned':
                return 'Номер заблокирован';
            default:
                return '';
        }

    }
    static public function client($status): string
    {
        switch ($status){
            case 'new':
                return 'Новый';
            case 'waiting_start':
                return 'Ожидает запуска';
            case 'done':
                return 'отправлено';
            case 'dispatching':
                return 'Рассылается';
            case 'error_phone_banned':
                return 'Телефон заблокирован';
            case 'error_not_found':
                return 'клиент не найден';
            case 'on_stop_list':
                return 'клиент в стоп листе';
            default:
                return 'ошибка';
        }

    }
    static public function res_client($status): string
    {
        switch (true){
            case ($status['error'] == false):
                return 'done';
//                $status['data']['validation']['client'][0] == 'Пользователь не зарегистрирован в WhatsApp'
            case ($status['error'] == 'Некорректные данные.' ?? isset($status['data']['validation']['client'])):
                return 'error_not_found';
            case ($status['error'] == 'Некорректные данные.' ?? $status['data']['validation']['source']):
                return 'error_phone_banned';
            default:
                return 'unknown';
        }

    }
}
