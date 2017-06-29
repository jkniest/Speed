<p align="center">
    <img src="docs/logo.png" width="258"><br>
    Icon made by <a href="http://www.iconarchive.com/artist/itzikgur.html">Itzik Gur</a>
</p>

<p align="center">
    <a href="https://travis-ci.com/jkniest/Speed">
        <img src="https://travis-ci.com/jkniest/Speed.svg?token=V2HFFCLc6NVnxsqjqD9v&branch=develop">
    </a> <a href="https://speed.genadev.de">
        <img src="https://img.shields.io/badge/Version-1.0%20(DEV)-yellow.svg">
    </a> <a href="https://laravel.com">
        <img src="https://img.shields.io/badge/Laravel-5.4.27-blue.svg">
    </a> 
    
## About Speed

Speed is a simple tool to keep track of the average internet connection speed across multiple
computers or servers.


## Installation

Install this project by cloning this repository and install like every other laravel application

- Run `composer install` inside the root directory of your project
- Run `npm install` inside the root directory of your project
- Copy `.env.example` to `.env` and modify the database connection (and other data)
- Run `php artisan key:generate` to generate a new encryption key
- Run `php artisan migrate` to generate the database structure
- Add a cron entry: `* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1`
- Run `./vendor/bin/phpunit` to test if everything is working

## License
Copyright (c) 2017 Jordan Kniest   
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit
persons to whom the Software is furnished to do so, subject to the following conditions:   
   
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
Software.   
   
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

## Roadmap
#### Version 1.0.0
 - [ ] Authentication (Simple Login)
 - [ ] Dashboard with average speed 
 - [ ] Dashboard-Widgets for every server
 - [ ] Add new servers
 - [ ] Ubuntu / Debian / Windows Software 
 
