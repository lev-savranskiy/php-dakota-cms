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
| Site User Roles
| User must have role = 10
------------------------------------------------------------------------
|
*/

$config['site_roles'] = array('10' => 'User', '50' => 'Moderator', '100' => 'Admin');



/*
 * TODO delete (moved to Menu Model)
|--------------------------------------------------------------------------
| Site Urls (for admin center)
------------------------------------------------------------------------
|


$config['site_urls'] = array(
    'admin' => 'Admin-center',
    'articles' => 'Articles',
    'forums' => 'Forums',
    'gallery' => 'Gallery',
    'login' => 'Login',
    'logout' => 'Logout',
    'register' => 'Register',
    'rss' => 'RSS',
    'search' => 'Search',
    'users' => 'Users',
    'users/myprofile' => 'My Profile',
    'user_guide_dakota' => 'Dakota-CMS User guide',
 //    'index/setlang/russian/' => 'По русски'
);
*/
/*
|--------------------------------------------------------------------------
Word cases (ONE thread, TWO threads , MANY threads)
|--------------------------------------------------------------------------
|
*/

$config['site_thread_cases']  =  array('thread', 'threads' , 'threads');
$config['site_replies_cases']  =  array('reply', 'replies' , 'replies');

/*
|--------------------------------------------------------------------------
| Site User Settings and Form Rules. You can add/delete  some. No other coding required!
 Create 16x16 icon for new field like   \templates\common\img\icon_[name].png
|--------------------------------------------------------------------------
|
*/

$config['site_user_settings'] = array(
    'bday' => array('Birth day .(1 - 31)', 'trim|check_day|is_natural_no_zero'),
    'bmonth' => array('Birth month (1 - 12)', 'trim|check_month|is_natural_no_zero'),
    'byear' => array('Birth Year (' .  $config['birth_year_start'] . ' -  ' .  $config['birth_year_end']  .')', 'trim|check_year|is_natural_no_zero'),
    'vk' => array('Vkontakte', 'trim|valid_url'),
    'moikrug' => array('moikrug', 'trim|valid_url'),
    'facebook' => array('facebook', 'trim|valid_url'),
    'linkedin' => array('linkedin', 'trim|valid_url'),
    'twitter' => array('twitter', 'trim|valid_url'),
    'habr' => array('habr', 'trim|valid_url'),
    'www' => array('www', 'trim|valid_url'),
    'skype' => array('skype', 'trim'),
    'about' => array('About me', 'trim|min_length[6]'),
    // 'sex'=>array('sex' , '?')
);


/*
|--------------------------------------------------------------------------
| Autocomplete User Location Lists. You can add/delete  some. No other coding required!
|--------------------------------------------------------------------------
|
*/
$config['citieslist'] = array(

    "Abidjan","Abu Dhabi","Abuja","Accra","Adamstown","Addis Ababa","Adelaide","Algiers","Alofi","Amman","Amsterdam","Andorra la Vella","Ankara","Antananarivo","Apia","Ashgabat","Asmara","Astana","Asuncion","Athens","Auckland","Avarua",
    "Baghdad","Baku","Bamako","Bandar Seri Begawan","Bankok","Bangui","Banjul","Basel","Basseterre","Beijing","Beirut","Belgrade","Belmopan","Berlin","Bern","Bishkek","Bissau","Bloemfontein","Bogota","Brasilia","Bratislava","Brazzaville","Bridgetown","Brisbane","Brussels","Bucharest","Budapest","Buenos Aires","Bujumbura",
    "Cairo","Calgary","Canberra","Cape Town","Caracas","Castries","Charlotte Amalie","Chicago","Chisinau","Cockburn Town","Colombo","Conakry","Copenhagen","Cotonou",
    "Dakar","Damascus","Dar es Salaam","Dhaka","Dili","Djibouti","Dodoma","Doha","Dubai","Dublin","Dushanbe",
    "Fagatogo","Fongafale","Freetown",
    "Gaborone","Geneva","George Town","Georgetown","Gibraltar","Glasgow","Guatemala la Nueva",
    "Hagatna","Hague","Hamilton","Hanoi","Harare","Havana","Helsinki","Honiara",
    "Islamabad","Istanbul",
    "Jakarta","Jamestown","Jerusalem","Johannesburg",
    "Kabul","Kampala","Kathmandu","Khartoum","Kigali","Kingston","Kingstown","Kinshasa","Kolkata","Kuala Lumpur","Kuwait City","Kiev",
    "La Paz","Libreville","Lilongwe","Lima","Lisbon","Ljubljana","Lobamba","Lome","London","Los Angeles","Luanda","Lusaka","Luxembourg",
    "Madrid","Majuro","Malabo","Managua","Manama","Manila","Maputo","Maseru","Mbabane","Melbourne","Melekeok","Mexiko City",   "Minsk","Mogadishu","Monaco","Monrovia","Montevideo","Montreal","Moroni","Moscow","Muscat",
    "Nairobi","Nassau","N'Djamena","New Dehli","New York","Newcastle","Niamey","Nicosia","Nouakchott","Noumea","Nuuk",
    "Oranjestad","Oslo","Ouagadougou",
    "Palikir","Panama City","Papeete","Paramaribo","Paris","Perth","Phnom Penh","Podgorica","Port Louis","Port Moresby","Port-au-Prince","Port of Spain","Porto-Novo","Prague","Praia","Pretoria","Pyongyang",
    "Quito",
    "Rabat","Reykjavik","Riga","Rio de Janero","Road Town","Rome","Roseau","Rotterdam",
    "Saint-Petersburg", "Salvador","San Jose","San Juan","San Marino","San Salvador","Sanaa","Santa Cruz","Santiago","Santo Domingo","Sao Paulo","Sarajevo","Seoul","Shanghai","Sydney","Singapore","Skopje","Sofia","Stanley","Stockholm","Suva",
    "Taipei","Tallinn","Tashkent","Tbilisi","Tegucigalpa","Tehran","Thimphu","Tirana","Tiraspol","Tokyo","Toronto","Torshavn","Tripoli","Tunis",
    "Ulaanbaatar",
    "Vaduz","Valletta","Valparaiso","Vancouver","Vatican City","Victoria","Vienna","Vientaine","Vilnius",
    "Warsaw","Washington dc","Wellington","Willemstad","Windhoek",
    "Yamoussoukro","Yaounde","Yerevan","Zurich",
    "Zagreb"
     );




$config['countrieslist'] =  array(
		"Afghanistan",
		"Albania",
		"Algeria",
		"Andorra",
		"Angola",
		"Antigua and Barbuda",
		"Argentina",
		"Armenia",
		"Australia",
		"Austria",
		"Azerbaijan",
		"Bahamas",
		"Bahrain",
		"Bangladesh",
		"Barbados",
		"Belarus",
		"Belgium",
		"Belize",
		"Benin",
		"Bhutan",
		"Bolivia",
		"Bosnia and Herzegovina",
		"Botswana",
		"Brazil",
		"Brunei",
		"Bulgaria",
		"Burkina Faso",
		"Burundi",
		"Cambodia",
		"Cameroon",
		"Canada",
		"Cape Verde",
		"Central African Republic",
		"Chad",
		"Chile",
		"China",
		"Colombi",
		"Comoros",
		"Congo (Brazzaville)",
		"Congo",
		"Costa Rica",
		"Cote d'Ivoire",
		"Croatia",
		"Cuba",
		"Cyprus",
		"Czech Republic",
		"Denmark",
		"Djibouti",
		"Dominica",
		"Dominican Republic",
		"East Timor",
		"Ecuador",
		"Egypt",
		"El Salvador",
		"Equatorial Guinea",
		"Eritrea",
		"Estonia",
		"Ethiopia",
		"Fiji",
		"Finland",
		"France",
		"Gabon",
		"Gambia, The",
		"Georgia",
		"Germany",
		"Ghana",
		"Greece",
		"Grenada",
		"Guatemala",
		"Guinea",
		"Guinea-Bissau",
		"Guyana",
		"Haiti",
		"Honduras",
		"Hungary",
		"Iceland",
		"India",
		"Indonesia",
		"Iran",
		"Iraq",
		"Ireland",
		"Israel",
		"Italy",
		"Jamaica",
		"Japan",
		"Jordan",
		"Kazakhstan",
		"Kenya",
		"Kiribati",
		"Korea, North",
		"Korea, South",
		"Kuwait",
		"Kyrgyzstan",
		"Laos",
		"Latvia",
		"Lebanon",
		"Lesotho",
		"Liberia",
		"Libya",
		"Liechtenstein",
		"Lithuania",
		"Luxembourg",
		"Macedonia",
		"Madagascar",
		"Malawi",
		"Malaysia",
		"Maldives",
		"Mali",
		"Malta",
		"Marshall Islands",
		"Mauritania",
		"Mauritius",
		"Mexico",
		"Micronesia",
		"Moldova",
		"Monaco",
		"Mongolia",
		"Morocco",
		"Mozambique",
		"Myanmar",
		"Namibia",
		"Nauru",
		"Nepa",
		"Netherlands",
		"New Zealand",
		"Nicaragua",
		"Niger",
		"Nigeria",
		"Norway",
		"Oman",
		"Pakistan",
		"Palau",
		"Panama",
		"Papua New Guinea",
		"Paraguay",
		"Peru",
		"Philippines",
		"Poland",
		"Portugal",
		"Qatar",
		"Romania",
		"Russia",
		"Rwanda",
		"Saint Kitts and Nevis",
		"Saint Lucia",
		"Saint Vincent",
		"Samoa",
		"San Marino",
		"Sao Tome and Principe",
		"Saudi Arabia",
		"Senegal",
		"Serbia and Montenegro",
		"Seychelles",
		"Sierra Leone",
		"Singapore",
		"Slovakia",
		"Slovenia",
		"Solomon Islands",
		"Somalia",
		"South Africa",
		"Spain",
		"Sri Lanka",
		"Sudan",
		"Suriname",
		"Swaziland",
		"Sweden",
		"Switzerland",
		"Syria",
		"Taiwan",
		"Tajikistan",
		"Tanzania",
		"Thailand",
		"Togo",
		"Tonga",
		"Trinidad and Tobago",
		"Tunisia",
		"Turkey",
		"Turkmenistan",
		"Tuvalu",
		"Uganda",
		"Ukraine",
		"United Arab Emirates",
		"United Kingdom",
		"United States",
		"USA",
		"U.S.A.",
		"Uruguay",
		"Uzbekistan",
		"Vanuatu",
		"Vatican City",
		"Venezuela",
		"Vietnam",
		"Yemen",
		"Zambia",
		"Zimbabwe"
	);

