[![Actions Status](https://github.com/AnastasiaYakushina/php-project-57/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/AnastasiaYakushina/php-project-57/actions)
[![php-project-57](https://github.com/AnastasiaYakushina/php-project-57/actions/workflows/php-project-57.yml/badge.svg)](https://github.com/AnastasiaYakushina/php-project-57/actions/workflows/php-project-57.yml)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=AnastasiaYakushina_php-project-57&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=AnastasiaYakushina_php-project-57)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=AnastasiaYakushina_php-project-57&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=AnastasiaYakushina_php-project-57)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=AnastasiaYakushina_php-project-57&metric=coverage)](https://sonarcloud.io/summary/new_code?id=AnastasiaYakushina_php-project-57)

Ссылка на проект: https://php-project-57-vwag.onrender.com

### Описание
**Менеджер задач** — веб-приложение на Laravel для управления задачами, их статусами и метками.


### Системные требования
- PHP 8.2+
- Composer
- Node.js & NPM
- SQLite


### Установка и запуск


1. **Клонирование репозитория**  
   `git clone git@github.com:AnastasiaYakushina/php-project-57.git`  
   *Копирует исходный код проекта в локальную папку.*


2. **Автоматическая сборка и развертывание**  
   `make install`  
   *Одной командой выполняет полную автоматическую настройку проекта: устанавливает PHP и JS зависимости, собирает фронтенд, создает файл `.env` из шаблона и генерирует уникальный ключ приложения, создает локальный файл базы данных SQLite, запускает миграции и наполняет БД начальными данными.*


3. **Запуск локального сервера**  
   `php artisan serve`  
   *Запускает встроенный веб-сервер Laravel для работы с приложением в браузере.*


### Тестирование
- Запуск тестов: `make test`  
- Запуск линтера: `make lint`
