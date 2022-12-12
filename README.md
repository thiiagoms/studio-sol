<p align="center">
  <a href="https://github.com/thiiagoms/studio-sol">
    <img src="assets/logo.png" alt="Logo" width="500" height="140">
  </a>
     <h3 align="center">Studio Sol - Exam :sun_with_face::black_heart:</h3>
</p>

- [Dependencies](#Dependencies)
- [Install](#Install)
## Dependencies
* Docker
* Composer and PHP8.1+ (If you don't have docker)

## Install

01 - Clone this repository:
```bash
$ git clone https://github.com/thiiagoms/studio-sol
```

02 - Change to this directory:
```bash
$ cd studio-sol
```
### With Docker :whale:

03 - To use this application with docker:
```bash
studio-sol $ docker-compose build app
```

04 - Run the containers:
```bash
studio-sol $ docker-compose up -d
```

05 - Install application dependencies and generate application secrets :lock:
```bash
studio-sol $ docker-compose exec app composer install
studio-sol $ docker-compose exec app cp .env.example .env
studio-sol $ docker-compose exec app php artisan key:generate
```

06 - Go to the endpoint `http://localhost:8000/verify` to use this application and send this payload as example :D:
```json
{
    "password": "TesteSenhaForte!123&",
    "rules": [
        {
            "rule": "minSize",
            "value": 8
        },
        {
            "rule": "minSpecialChars",
            "value": 2
        },
        {
            "rule": "noRepeted",
            "value": 0
        },
        {
            "rule": "minDigit",
            "value": 4
        }
    ]
}
```

And you should receive this response:
```json
{
  "verify": false,
  "noMatch": [
      "minDigit"
  ]
}
```

### With Composer :elephant:

03 - Install dependencies with composer:
```bash
studio-sol $ composer install
```
04 - Add `.env` file
```bash
studio-sol $ cp .env.example .env
```
05 - Generate application secret :lock:
```bash
studio-sol $ php artisan key:generate
```

06 - Use laravel build-in server 
```bash
studio-sol $ php artisan serve
```
07 - Go to  `http://localhost:8000/verify` and send this payload :smile::
```json
{
    "password": "TesteSenhaForte!123&",
    "rules": [
        {
            "rule": "minSize",
            "value": 8
        },
        {
            "rule": "minSpecialChars",
            "value": 2
        },
        {
            "rule": "noRepeted",
            "value": 0
        },
        {
            "rule": "minDigit",
            "value": 4
        }
    ]
}
```
And you shoull receive this response
```json
{
    "verify": false,
    "noMatch": [
        "minDigit"
    ]
}
```

