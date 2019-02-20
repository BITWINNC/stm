<?php

function enleverCaracteresSpeciaux($text) {
$utf8 = array(
'/[�����]/u' => 'a',
'/[�����]/u' => 'A',
'/[����]/u' => 'I',
'/[����]/u' => 'i',
'/[����]/u' => 'e',
'/[����]/u' => 'E',
'/[������]/u' => 'o',
'/[�����]/u' => 'O',
'/[����]/u' => 'u',
'/[����]/u' => 'U',
'/�/' => 'c',
'/�/' => 'C',
'/�/' => 'n',
'/�/' => 'N',
'//' => '-', // conversion d'un tiret UTF-8 en un tiret simple
'/[]/u' => ' ', // guillemet simple
'/[��]/u' => ' ', // guillemet double
'/ /' => ' ', // espace ins�cable (�quiv. � 0x160)
);
return preg_replace(array_keys($utf8), array_values($utf8), $text);
}

function transformerEnURL($string) {
return strtolower(preg_replace(array( '#[s-]+#', '#[^A-Za-z0-9. -]+#' ), array( '-', '' ), enleverCaracteresSpeciaux(str_replace(array_keys($dict), array_values($dict), urldecode($string)))));
}


?>