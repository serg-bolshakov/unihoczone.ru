<p align="left">
<a href="https://unihoczone.ru" target="_blank"><img src="https://unihoczone.ru/storage/icons/logo56.png" alt="logo" title="Перейти на главную страницу сайта" style="margin-right: 20px"></a>
Интернет-магазин спортивных товаров (флорбольная экипировка) <strong>UnihocZoneRussia</strong>
</p>

## Программное обеспечение

Приложение написано на JavaScript и PHP с использованием фреймворка Laravel. База данных реализована в SQLite.

## Пользовательский функционал приложения

Посетитель <a href="https://unihoczone.ru" target="_blank">сайта</a>:

- получает возможность ознакомиться с ассортиментом товаров магазина, может просмотреть отдельные категории, выбрать интересующую позицию. Предельная информация предоставлена в <a href="https://www.unihoczone.ru/products/card/10374-klyushka-dlya-florbola-unihoc-sniper-white-blue-96cm-right">карточке</a> товара, включая варианты исполнения выбранной для просмотра модели (по размеру/цвету/модификации). 
- видит недавно просмотренные товары, в блоке отслеживаются 6 последних просмотренных (процедура реализована на JS с использованием локального хранилища браузера пользователя)...
- может понравившийся товар отметить "кнопкой" и поместить его в хранилище "Избранных", где далее для каждого товара из этой категории отслеживаются доступное для продажи количество, актуальные цены. Кнопкой можно либо удалить товар из "Избранного", либо перенести его в "Корзину для покупки"...
- при желании совершить покупку, может перенести выбранный товар в "Корзину" либо из карточки товара, либо из "Избранного", либо набрать желаемый ассортимент и количество из таблицы товаров в личном кабинете профиля (если пользователь зарегистрирован в приложении и авторизован на сайте)...
- в "Корзине" всегда видит актуальные цены и количество доступного для покупки товара. Может сразу оценить потенциальный размер выгоды (скидки), которую он может получить при оформлении сделки, изменить желаемое количество товара и посмотреть изменения в стоимости корзины и сразу увидеть свою выгоду (возможности манипуляций в корзине покупок реализованы на JS)...
- может совершить покупку 
    1. без регистрации и авторизации в приложении (как физическое лицо). В этом случае отслеживать статус заказа (оплата, доставка...) можно только на том устройстве, с которого он оформлял заказ (история хранится в локальном хранилище браузера пользователя)
    2. как зарегистрированный пользователь (физическое ИЛИ юридическое лицо). Авторизованные покупатели получают дополнительные скидки на цены в зависимости от ранга (предусмотрена реализация системы скидок). Юридические лица получают счёт на предварительную оплату в теле письма и во вложении, в файле формата .pdf. Физические могут зарезервировать товар на 3 дня, также получить по почте счёт, передать его на оплату другому лицу...
- может зарегистрироваться в качестве пользователя и отслеживать в личном кабинете историю заказов, оформлять покупки и резервировать товары, видеть возможные поступления новых товаров и сменить пароль, логин (электронную почту)... корректировать личные данные...



<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
