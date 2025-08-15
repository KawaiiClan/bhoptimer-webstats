<?php
//titles (change the favicon by replacing "assets/img/favicon.png")
define('HOMEPAGE_TITLE', 'KawaiiClan Stats');
define('TOPLEFT_TITLE', 'KawaiiClan Stats');

//limits for number of times retrieved/displayed on different pages
define('RECORD_LIMIT', '100');
define('RECORD_LIMIT_LATEST', '100');
define('PLAYER_TOP_RANKING_LIMIT', '100');
define('PLAYER_PAGE_LIMIT', '100');

//API key (https://steamcommunity.com/dev) used for getting steam profile info on user page
define('API_KEY', '');

//link to your website home page (ie. directory above /stats) if you don't have one, you can just use "index.php" to go to the main stats page
define('HOME_SITE', 'https://kawaiiclan.com');

//directory to use for map screenshot files. by default, it will use "assets/img/maps/". the trailing "/" is required!
//if you use sourcebans or something you can use that folder instead so they are unified (ie. "../sourcebans/images/maps/")
//valid file types to fill this folder with are .jpg or .png
define('MAP_SC_DIR', '../sourcebans/images/maps/');

//silly timer, so many tracks.. remove some if you don't use them
$tracks =
[
	-1 => 'All Tracks',
	0 => 'Main',
	1 => 'Bonus',
	2 => 'Bonus2',
	3 => 'Bonus3',
	4 => 'Bonus4',
	5 => 'Bonus5',
	6 => 'Bonus6',
	7 => 'Bonus7',
	8 => 'Bonus8',
];

//db
define('DB_HOST', '');
define('DB_USER', '');
define('DB_PASSWORD', '');
define('DB_SCHEMA', '');
//this one is often left blank, unless you have a prefix in your db (i guess some server hosts do this?)
define('MYSQL_PREFIX', '');

//steam link to join game server with (just replace "kawaiiclan.com:27015" with your game server IP:port
define('SERVER_IP', 'steam://connect/kawaiiclan.com:27015');

//the style IDs must match what you have set in shavit-styles.cfg
$styles =
[
	-1 => "All Styles",
	0 => "Normal",
	8 => "Scroll",
	5 => "EZScroll",
	15 => "Strafe",
	20 => "10aa",
	3 => "Stamina",
	1 => "Sideways",
	2 => "W-Only",
	4 => "Half-Sideways",
	6 => "Surf HSW",
	9 => "A/D Only",
	18 => "WA/WD Only",
	10 => "Backwards",
	7 => "Prespeed",
	13 => "Low Gravity",
	11 => "Parkour",
	12 => "Unreal",
	17 => "Thanos",
	19 => "Speedrun",
	14 => "Segmented",
	16 => "TAS"
];

//if you use the shavit-challenge plugin for races, change this to 1
$races = 0;

//if your timer version supports style ranks, enable this for "top" page style functionality
$styleranks = false;

//default track and style displayed on the map page
define('DEFAULT_TRACK', 0);
define('DEFAULT_STYLE', 0);

//options for sorting times, logic needed for these, so you can't really add to it easily. more to come probably
$filters =
[
	0 => "Most Points",
	1 => "Least Points",
	2 => "Most Recent",
	3 => "Oldest",
	4 => "Fastest",
	5 => "Slowest",
];

