<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dakota CMS - An open source CMS
 *
 * @author		Lev Savranskiy
 * @copyright	Copyright (c) 2010, Dakota CMS
 * @link		http://dakota-cms.com/
 * @since		Version 0.1
 */





/*
|--------------------------------------------------------------------------
| Именование ролей на сайте
 *
 * Вы можете переименовать роли.
 * Вы можете добавить сколько угодно ролей, но их использование  потребует дополнительного кодирования
 * Не меняйте существующие ключи 10, 50, 100
 * Роль Пользователь должа быть  = 10
|--------------------------------------------------------------------------
|
*/


$config['site_roles'] = array(
    '10' => 'Пользователь',
    '50' => 'Модератор',
    '100' => 'Администратор'
);



/*
|--------------------------------------------------------------------------
Падежи по шаблону (одна тема, две темы, много тем)
|--------------------------------------------------------------------------
|
*/

$config['site_thread_cases']  =  array('тема', 'темы' , 'тем');
$config['site_replies_cases']  =  array('ответ', 'ответа' , 'ответов');

/*
|--------------------------------------------------------------------------
| Настройки пользователя. Удалите/добавьте свои. Изменения вступят в силу сразу!
| При добавлении нового поля сделайте иконку  16x16  по пути   \templates\common\img\icon_[имя поля].png
|--------------------------------------------------------------------------
|
*/



$config['site_user_settings'] = array(
    'bday' => array('День рожд.(1 - 31)', 'trim|check_day|is_natural_no_zero'),
    'bmonth' => array('Месяц рожд.(1 - 12)', 'trim|check_month|is_natural_no_zero'),
    'byear' => array('Год рожд (' .  $config['birth_year_start'] . ' -  ' .  $config['birth_year_end'] .')' , 'trim|check_year|is_natural_no_zero'),
    'vk' => array('Вконтакте', 'trim|valid_url'),
    'moikrug' => array('moikrug', 'trim|valid_url'),
    'facebook' => array('facebook', 'trim|valid_url'),
    'linkedin' => array('linkedin', 'trim|valid_url'),
    'twitter' => array('twitter', 'trim|valid_url'),
    'habr' => array('habr', 'trim|valid_url'),
    'www' => array('www', 'trim|valid_url'),
    'skype' => array('skype', 'trim'),
    'about' => array('О себе', 'trim|min_length[6]'),
    // 'sex'=>array('Пол' , '?')
);


/*
|--------------------------------------------------------------------------
| Автозаполнение городов и стран в профиле.  Удалите/добавьте свои. Изменения вступят в силу сразу!
|--------------------------------------------------------------------------
|
*/
$config['citieslist'] = array(
    'Санкт-Петербург', 'Москва',
    'Алма-Ата', 'Архангельск', 'Астрахань',
    'Барнаул', 'Брянск',
    'Великий Новгород', 'Витебск', 'Владивосток', 'Волгоград', 'Вологда', 'Воронеж',
    'Днепропетровск', 'Донецк',
    'Запорожье',
    'Иркутск',
    'Екатеринбург',
    'Калуга', 'Казань', 'Калининград', 'Киев', 'Краснодар', 'Красноярск', 'Кременчуг',
    'Луганск', 'Львов',
    'Магадан', 'Магнитогорск', 'Минск', 'Мурманск',
    'Н.Новгород', 'Новосибирск',
    'Одесса', 'Омск', 'Оренбург',
    'Пенза', ' Пермь', 'Петрозаводск',
    'Ростов-на-Дону', 'Рязань',
    'Самара', 'Севастополь', 'Саратов', 'Смоленск', 'Сочи', 'Сургут', 'Старый оскол',
    'Тамбов', 'Ташкент', 'Тверь', 'Тула', 'Томск', 'Тольятти',
    'Уфа', 'Улан-удэ', 'Ульяновск',
    'Харьков',
    'Чита', 'Челябинск', 'Чернигов', 'Череповец',
    'Ярославль');

$config['countrieslist'] = array(

    'Россия',
    'Украина',
    'Беларусь',
    'Казахстан',
    'Германия',
    'США',
    'Канада',
    'Англия',
    'Израиль',
    "Азербайджан",
    "Армения",
    "Грузия",
    "Кыргызстан",
    "Молдова",
    "Таджикистан",
    "Туркмения",
    "Узбекистан",
    'Латвия',
    'Литва',
    'Эстония'
);
