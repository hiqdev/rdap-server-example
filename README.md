# RDAP server application example

This is a sample application uses the [HiQDev RDAP library](https://github.com/hiqdev/rdap) which packs domain info into PHP objects and can serialize it to JSON string.

This implementation fetches public WHOIS servers, parses the response by [HiQDev RDAP-Whois proxy](https://github.com/hiqdev/rdap-whois-proxy), fills RDAP objects and responds according to the RFC7483.

# Install and run 

The preferred way to install this project is through [composer](http://getcomposer.org/download/).

```sh
php composer.phar create-project "hiqdev/rdap-server-example:*" directory2install
```

Then run ``php composer.phar update`` to setup all dependencies

## Setup project

You can run this application by two ways.

1. With build-in PHP web server:

        php -S {host}:{port} -t public/ public/index.php
        

2.  With docker-compose:

        docker-compose up -d --build


Now you can check you app on ``localhost:8080`` or on your custom port and see

    Hello world!
        
## Usage
        
You can use this application to find domain names by URL

    localhost:8080/domain/example.com

And see something like
    
      "ldhName": "example.com",
      "unicodeName": "example.com",
      "entities": [
        {
          "vcardArray": [
            [
                ...


