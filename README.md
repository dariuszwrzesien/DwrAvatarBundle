[![SensioLabsInsight](https://insight.sensiolabs.com/projects/12b57070-5a37-4bdb-a8b3-aeddfdddcfff/big.png)](https://insight.sensiolabs.com/projects/12b57070-5a37-4bdb-a8b3-aeddfdddcfff)
======================
[![Build Status](https://travis-ci.org/dariuszwrzesien/DwrAvatarBundle.svg?branch=master)](https://travis-ci.org/dariuszwrzesien/DwrAvatarBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dariuszwrzesien/DwrAvatarBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dariuszwrzesien/DwrAvatarBundle/?branch=master)
[![Coverage Status](https://coveralls.io/repos/dariuszwrzesien/DwrAvatarBundle/badge.png)](https://coveralls.io/r/dariuszwrzesien/DwrAvatarBundle)
DwrAvatarBundle
======================

This bundle provides easy image avatar generator support for Symfony2.
If you want to generate Avatar you can:

**In Controller**

``` php
public function indexAction()
    {
        
        $avatar = new AvatarFactory();

        //for plainAvatar
        $plainAvatar = $avatar->generate(new PlainAvatar(140, 140)); 

        //for profileAvatar
        $profileAvatar = $avatar->generate(new ProfileAvatar(140, 140));
        
        return array(
            'plainAvatar'   => $plainAvatar->render()
            'profileAvatar' => $profileAvatar->render()
        );
    }
```

And in a **view** file (twig):

``` jinja
<img src="data:image/jpg;base64,{{ plainAvatar }}" >
<img src="data:image/jpg;base64,{{ profileAvatar }}" >
```

## **Installation**

Installation is a quick 3 steps process:

1. Download DwrAvatarBundle using composer
2. Enable the Bundle
3. Add routing to routing.yml in order to can open example in your browser

### Step 1: Download DwrAvatarBundle using composer

Add DwrAvatarBundle in your composer.json:

```js
{
    "require": {
        "dwr/avatar-bundle": "0.2"
    }
}
```

Download the bundle by running the command:

``` bash
$ php composer.phar update dwr/avatar-bundle
```

Composer will install the bundle into your project's `vendor/dwr/avatar-bundle` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Dwr\AvatarBundle\DwrAvatarBundle(),
    );
}
```

### Step 3: Add routing to routing.yml in order to can open example in your browser

``` yml
dwr_avatar:
    resource: "@DwrAvatarBundle/Controller/"
    type:     annotation
    prefix:   /dwr_avatarbundle
```

Congratulations! You're ready to generate avatars in your symfony2 application.
Example how PlainAvatar looks like you can find on: yours-application-url/dwr_avatarbundle/avatar .

## **Usage**
## **Generate avatar in base64 stream**

**Controller**

``` php
public function indexAction()
    {
        
        $avatar = new AvatarFactory();

        //for plainAvatar
        $plainAvatar = $avatar->generate(new PlainAvatar(140, 140)); 

        //for profileAvatar
        $profileAvatar = $avatar->generate(new ProfileAvatar(140, 140));
        
        return array(
            'plainAvatar'   => $plainAvatar->render()
            'profileAvatar' => $profileAvatar->render()
        );
    }
```

**View (twig)**

``` jinja
<img src="data:image/jpg;base64,{{ plainAvatar }}" >
<img src="data:image/jpg;base64,{{ profileAvatar }}" >
```

Example how to generate avatars in base64 stream is also stored in AvatarBundle/Controller/DefaultController.php.

## **Generate avatar and save it to file**

``` php
public function indexAction()
    {
        
        $avatar = new AvatarFactory();
        $plainAvatar = $avatar->generate(new PlainAvatar(140, 140));
        
        return array(
            'plainAvatar' => $plainAvatar->save('web/images/avatar/directory')
        );
    }
```

Above example generates avatar file into directory. Directory name is passed in function save as parameter.
File name will be generated automatically based on this:

``` php
$filename = date('YmdHis') . uniqid() . '.jpg';
```

In order to generate avatar with your own filename you can pass filename (e.g *image.jpg*) as second argument of save method.

``` php
public function indexAction()
    {
        
        $avatar = new AvatarFactory();
        $plainAvatar = $avatar->generate(new PlainAvatar(140, 140));
        
        return array(
            'plainAvatar' => $plainAvatar->save('web/images/avatar/directory', 'image.jpg')
        );
    }
```

### Troubleshooting

1. Make sure you have [GD](http://php.net/manual/en/book.image.php) installed on your web server.
    http://php.net/manual/en/function.gd-info.php

