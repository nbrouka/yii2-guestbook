<?php
return [
    'name' => $faker->name,
	'ip'   => $faker->ipv4,
	'browser' => $faker->word,
	'email' => $faker->email,
	'homepage' => $faker->url,
	'message' => $faker->text,
	'msgputtime' => $faker->iso8601($max = 'now') ,
	'image' => $faker->imageUrl($width = 320, $height = 240),
	'file' => $faker->url 
];