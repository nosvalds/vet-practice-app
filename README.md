# Wildlife Sumpreme Veterinary Practice

This mock veterinary practice database web application and API was developed over 2 weeks of the developme bootcamp learning and applying the skills listed in the gitHub topics. It uses Laravel Blade to display lists of owners and their animals from the MySQL database. It contains forms that allow for adding/updating these based on your user role. We also developed an API (using a test driven development approach) with Laravel that can be used to query and update the database (based on OAUTH and user role). Finally we deployed the site on AWS and set up Capistrano to enable Continuous Deployment of updates to the site.

# Website
https://wildlifesupreme.developme.space

# API
https://wildlifesupreme.developme.space/api/

## Wildlife Supreme Veterinary Practice Database API

## Base URL
`https://wildlifesupreme.developme.space/api/`

## Authentication

In order to use the service you'll need to have an account created for you. Email me at nosvalds@gmail.com and I'll get you set up.

Once you have the account information, make the following request to recieve a Bearer Token:

`POST https://wildlifesupreme.developme.space/oauth/token`

### Request

```json
{
    "grant_type": "password",
    "client_id": "<your_client_id>",
    "client_secret": "<your_client_secret>",
    "username": "your_username@example.com",
    "password": "password"
}
```

### Response

```json
{
    "token_type": "Bearer",
    "expires_in": 31535999,
    "access_token": "...",
    "refresh_token": "..."
}
```

### Usage

You'll need to use your token for all requests.

For example, if your response was:

```json
{
    "token_type": "Bearer",
    "expires_in": 31535999,
    "access_token": "massivelylongaccesstoken",
    "refresh_token": "..."
}
```

All your requests should have the following header:

```
Authorization: Bearer massivelylongaccesstoken
```


## Owners

### `GET /owners`

Will return a list of all animal owners, their details, and the animals they own.

```json
{
    "data": [
        {
            "id": 1,
            "name": "Helena Beahan",
            "address": "Adah Villages, Suite 833, West Hudson, 52447-8504",
            "animals": [
                "Dr. Destiny Crist",
                "Hardy Luettgen",
                "Doogo"
            ]
        },
        {
            "id": 2,
            "name": "Grayce Graham",
            "address": "Dicki Vista, Apt. 837, Lake Elouiseport, 14515-7225",
            "animals": [
                "Felipe Walsh Sr.",
                "Nyasia Reynolds",
                "Dr. Dina Fadel PhD"
            ]
        },
    ]
}
```

### `POST /owners`

Will create a new owner

#### Request

```json
{	
    "first_name": "<first name>", // REQ - String
    "last_name" : "<last name>", // REQ - String
    "address_1": "<address_1>", // REQ - String
    "address_2": "<address_2>", // REQ - String
    "town": "<town>", // REQ - String
    "telephone": "+XXXXXXXXXXX", // REQ - String
    "postcode": "<postcode>", // REQ - String
    "user_id": {id} // // REQ - integer creating user, 
}
```

### `GET /owners/<id>`

Will return an owner with the given `id`.
 
```json
{
        "id": 1,
        "name": "Helena Beahan",
        "address": "Adah Villages, Suite 833, West Hudson, 52447-8504",
        "animals": [
            "Dr. Destiny Crist",
            "Hardy Luettgen",
            "Doogo"
        ]
}
```

### `PUT /owners/<id>`

Will update an existing owner. 

#### Request

Use the same request format as `POST /owners`.

### `DELETE /owners/<id>`

Will delete an existing owner


## Animals

### `GET /animals`

Will return a list of all animals and their details.

```json
{
    "data": [
        {
            "id": 1,
            "name": "Ludwig Walter",
            "dob": "1974-12-29",
            "weight": 76.47,
            "height": 283.58,
            "biteyness": 3,
            "owner": "Christ Williamson",
            "treatments": [
                "Neuter",
                "de-clawing",
                "spay"
            ]
        },
        {
            "id": 2,
            "name": "Felipe Walsh Sr.",
            "dob": "1979-10-06",
            "weight": 129.47,
            "height": 367.74,
            "biteyness": 1,
            "owner": "Grayce Graham",
            "treatments": [
                "spay",
                "spay",
                "shaving"
            ]
        },
    ]
}
```

### `POST /animals`

Will create a new animal. Similar to using `POST /owners/<id>/animals`, but in this case you must include the owner_id in the request.

#### Request

```json
{	
    "name": "<animal name>", // REQ - string
    "date_of_birth": "YYYY-MM-DD", // REQ - date
    "type": "<type of animal>", // REQ - string
    "weight": n.nn, // REQ - float in kg
    "height": n.nn, // REQ - float in cm
    "biteyness": n, // REQ - integer 1-5
    "owner_id": int, // REQ - owner ID
    "treatments": ["treatment 1", "treatment 2"] // OPT - array of strings
}
```

### `GET /animals/<id>`

Will return an animal with the given `id`.
 
```json
{
    "data": {
        "id": 5,
        "name": "Chloe Raynor",
        "dob": "1988-10-05",
        "weight": 175.61,
        "height": 495.78,
        "biteyness": 5,
        "owner": "Arvel Bauch",
        "treatments": [
            "de-clawing",
            "Neuter",
            "Toenail Removal"
        ]
    }
}
```

### `PUT /animals/<id>`

Will update an existing owner. 

#### Request

Use the same request format as `POST /animals`.

### `DELETE /animals/<id>`

Will delete an existing animal

## Animals and Owners

### `GET /owners/<id>/animals`

Get the animals for an owner

### Response
```json
{
    "data": [
        {
            "id": 39,
            "name": "Dr. Destiny Crist",
            "dob": "2011-02-20",
            "weight": 33.39,
            "height": 86.05,
            "biteyness": 2,
            "owner": "Helena Beahan",
            "treatments": [
                "Flea Treatment",
                "spay",
                "petting therapy"
            ]
        },
        {
            "id": 82,
            "name": "Hardy Luettgen",
            "dob": "2015-09-01",
            "weight": 185.6,
            "height": 16.07,
            "biteyness": 5,
            "owner": "Helena Beahan",
            "treatments": [
                "petting therapy",
                "shaving",
                "petting therapy"
            ]
        },
        {
            "id": 101,
            "name": "Doogo",
            "dob": "2020-01-01",
            "weight": 4,
            "height": 12,
            "biteyness": 2,
            "owner": "Helena Beahan",
            "treatments": []
        }
    ]
}
```

### `POST /owners/<id>/animals`

Add a new animal to an owner

#### Request

```json
{	
    "name": "<animal name>", // REQ - string
    "date_of_birth": "YYYY-MM-DD", // REQ - date
    "type": "<type of animal>", // REQ - string
    "weight": n.nn, // REQ - float in kg
    "height": n.nn, // REQ - float in cm
    "biteyness": n, // REQ - integer 1-5
    "treatments": ["treatment 1", "treatment 2"] // OPT - array of strings
}
```

# Deployment
- Hosted on free AWS EC2 instance
```bash
bundle exec cap production deploy
```

# Laravel Documentation

<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
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

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)
- [We Are The Robots Inc.](https://watr.mx/)
- [Understand.io](https://www.understand.io/)
- [Abdel Elrafa](https://abdelelrafa.com)
- [Hyper Host](https://hyper.host)
- [Appoly](https://www.appoly.co.uk)
- [OP.GG](https://op.gg)
- [云软科技](http://www.yunruan.ltd/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
