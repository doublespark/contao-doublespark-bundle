Doublespark Contao bundle
===========================
This bundle extends Contao 4 with the following features:

### Remote assets
Define remote assets that will be synced locally to web/local-assets

### Lowercase alias
Enforce lower case news and page alias

### Canonical URLs
Adds canonical meta tag to all pages. This can be manually overridden in the site structure.

### BoxLink content element
This is a custom content element that allows for the creation of a clickable box with an image.

### Double text element
A text element that contains two text inputs for two-column text sections.

### Parallax content element
A content element for creating parallax sections

### Meta import/export
Export and re-import page meta fields

### Page meta character counts
Count characters on meta title and meta description field

### Custom save button
A custom save button for the backend, fixed to the top right for easy access

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require doublespark/doublespark "~1"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new Doublespark\DoublesparkBundle(),
        );

        // ...
    }

    // ...
}
```
