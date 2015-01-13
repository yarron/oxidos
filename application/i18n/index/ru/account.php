<?php defined('SYSPATH') or die('No direct script access.');

return array(
    
    'reg_title'                     => 'Регистрация',
    'auth_title'                    => 'Авторизация',
    'auth_new_heading'              => 'Новый пользователь',
    'auth_reg_heading'              => 'Зарегистрированный пользователь',
    
    'forgotten_title'               => 'Забыли пароль',
    'reset_title'                   => 'Сброс пароля',
    'account_title'                 => 'Личный Кабинет',
    'edit_title'                    => 'Учетная запись',
    'password_title'                => 'Смена пароля',
    'newsletter_title'              => 'Подписка на новости',
    
    'text_your_details'             => 'Основные данные',
    'text_your_password'            => 'Ваш пароль',
    'text_code'                     => 'Подтверждение кода безопасности',
    
    'text_reg_account'              => 'Зарегистрируйтесь и получите доступ к своему личному кабинету',
    'text_username'                 => 'Введите логин:',
    'text_password'                 => 'Введите пароль:',
    'text_remember'                 => 'Запомнить меня',
    'text_captcha'                  => 'Код безопасности:',
    'text_captcha_enter'            => 'Введите код:',
    'text_forgotten'                => 'Забыли пароль?',
    'text_enter'                    => 'Войти',
    'text_description'              => 'Введите адрес электронной почты, связанный с Вашей учетной записью. Перейдите по ссылке сброса пароля, отправленной вам по электронной почте.',
    'text_email'                    => 'E-Mail:',
    'text_reset_description'        => 'Введите новый пароль!',
    'text_reset_password'           => 'Пароль:',
    'text_reset_confirm'            => 'Подтвердите пароль:',
    'text_newsletter'               => 'Я прочитал %s и согласен с условиями',
    
    'text_name'                     => 'ФИО:',
    'text_email'                    => 'E-Mail:',
    'text_phone'                    => 'Телефон:',
    'text_confirm'                  => 'Подтверждение:',
    
    //текст учетной записи
    'text_my_account'               => 'Моя учетная запись',
    'text_edit_title'               => 'Информация',
    'text_edit_description'         => 'Изменить мою контактную информацию',
    'text_password_title'           => 'Пароль',
    'text_password_description'     => 'Изменить мой пароль',
    'text_my_settings'              => 'Мои настройки',
    'text_newsletter_title'         => 'Подписка',
    'text_newsletter_description'   => 'Подписаться или отказаться от подписки на рассылку новостей',
    
    //текст изменения учетной записи
    'text_edit_account'             => 'Ваша учетная запись',
    'text_edit_username'            => 'Логин:',
    'text_edit_name'                => 'ФИО:',
    'text_edit_email'               => 'Email:',
    'text_edit_phone'               => 'Телефон:',
    'text_edit_skype'               => 'Скайп:',
    'text_edit_icq'                 => 'Номер ICQ:',
    'text_edit_info'                => 'О себе:',
    'text_edit_ava'                 => 'Аватар:',
    'text_edit_noava'               => 'Удалить фотографию',
    
    //текст изменения пароля
    'text_password_title'           => 'Ваш пароль',
    'text_password_old'             => 'Старый пароль:',
    'text_password_password'        => 'Новый пароль:',
    'text_password_confirm'         => 'Подтвердите пароль:',
    
    //текст изменения подписки
    'text_newsletter_newsletter'    => 'Подписаться:',
    'text_newsletter_yes'           => 'Да',
    'text_newsletter_no'            => 'Нет',
    
        
    //кнопки
    'button_reset'                  => 'Сброс',
    'button_abort'                  => 'Отменить',
    'button_save'                   => 'Сохранить',
    'button_check'                  => 'Проверить логин',
    'button_download'               => 'Скачать',
    'button_register'               => 'Зарегистрироваться',
    
    //ошибки
    'error_captcha'                 => 'Не верно введен Код безопасности!',
    'error_newsletter'              => 'Для завершения регистрации Вы должны быть согласны с документом %s!',
    'error_password_old'            => 'Введенный пароль не соответствует старому паролю!',
    'error_status'                  => 'Статус пользователя выключен администрацией!',
    'error_no_user'                 => 'Такой логин и/или пароль не существует!',
    'error_username'                => 'Длина поля \"Логин\" должна быть от 3-х символов!',
    'error_password'                => 'Длина поля \"Пароль\" должна быть от 8-ми символов!',
    'error_email'                   => 'Такой E-Mail не найден',
    
    //метки
    'label_username'                => 'Логин',
    'label_email'                   => 'E-mail',
    'label_name'                    => 'ФИО',
    'label_password'                => 'Пароль',
    'label_confirm'                 => 'Подтвердите пароль',
    
    'email_theme'                   => 'Изменение пароля',
    'email_text'                    => 'Новый пароль для ',
    'email_link'                    => '<p>Чтобы изменить пароль, нажмите ссылку:</p>',
    'email_ip'                      => '<p>IP этого запроса: '.$_SERVER['REMOTE_ADDR'].'</p>',
    
    //сообщения
    'message_success'               => 'Ссылка для подтверждения отправлена на ваш адрес электронной почты.',
    'message_update'                => 'Ваш пароль успешно обновлен!',
    'message_edit'                  => 'Ваша учетная запись была успешно обновлена!',
    'message_password'              => 'Ваш пароль успешно изменен!',
    'message_newsletter'            => 'Ваша подписка успешно обновлена!',
    'message_register'              => 'Поздравляем! Ваша учетная запись успешно создана.<br />Письмо с данными о регистрации было отправлено на Ваш E-Mail.',

);