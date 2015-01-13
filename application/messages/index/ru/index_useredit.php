<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'unique'        => '":field" со значением ":value" уже существует',
    'min_length'    => 'Поле ":field" должно иметь больше :param2 символов',
    'max_length'    => 'Поле ":field" не должно превышать  более :param2 символов',
    'not_empty'     => 'Поле ":field" должно быть не пустым',
    'email'         => 'Поле ":field" должно быть email адресом',
    'alpha_dash'    => 'Поле ":field" должен содержать только цифры, буквы и тире',
    'matches'       => 'Поле ":field" должно быть как ":param2"',
    
    'ava.Upload::size'   => 'Размер загружаемого файла должен быть менее ":param2"',
    'ava.Upload::type'   => 'Тип загружаемого файла должен быть с расширением ":param2"',
);
