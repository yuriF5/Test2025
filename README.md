<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

#もぎたてフルーツ製品一覧表示

![一覧検索](https://github.com/user-attachments/assets/6132fadb-3844-4d22-9582-997b16356877)

商品詳細・更新削除画面

<img src="https://github.com/user-attachments/assets/e958a178-24aa-4d48-8526-d425f192533a" width="30%">


## 作成した目的

ある会社のとあるアプリ開発の勉学の為に作成しました。

## 当アプリケーション URL と関連 URL

- https://github.com/yuriF5/Test2025

  ※PC：Chrome/Firefox/Safari 最新バージョンを使用対象の為不足していると意図した画面が表示されない可能性があります。

- 開発環境：http://localhost/
- phpMyAdmin:http://localhost:8080/

git clone git@github.com:estra-inc/confirmation-test-contact-form.git
※ご使用の php 等の version に適した version に必ず修正してください。意図しない表示がされます。

## 機能一覧

製品検索、価格で検索、strage を使用して画像を表示

> > > > > > > d4fb9ca (Initial commit)

## 仕様技術

docker、Laravel 7.x、PHP8.1.2、laravel-fortify、Stripe、javascript

## ER 図

<img src="https://github.com/user-attachments/assets/8fd32b20-68d0-4b80-aede-7182aa72f7b1" width="30%">

## 環境構築

### コマンドライン上

```php
$ docker compose up -d --build
$ docker compose exec php bash
```

### PHP コンテナ内

```php
$ composer install
```

### src 上

```php
$ cp .env.local .env
```

### PHP コンテナ内

```php
$ php artisan key:generate
$ php artisan migrate
$ php artisan db:seed
```

### 権限変更

```php
$ sudo chmod -R 777 *
```
