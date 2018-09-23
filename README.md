# Puzzle App Newsletter Bundle
**=========================**

Puzzle app newsletter

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

`composer require webundle/puzzle-app-newsletter`

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles in the `app/AppKernel.php` file of your project:

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

    new Puzzle\App\NewsletterBundle\PuzzleAppNewsletterBundle(),
                    );

 // ...
}

 // ...
}
```

### Step 3: Register the Routes

Load the bundle's routing definition in the application (usually in the `app/config/routing.yml` file):

# app/config/routing.yml
```yaml
puzzle_app:
        resource: "@PuzzleAppNewsletterBundle/Resources/config/routing.yml"
```

### Step 4: Configure Bundle

Then, configure bundle by adding it to the list of registered bundles in the `app/config/config.yml` file of your project under:

```yaml
# Puzzle App Newsletter
puzzle_app_newsletter:
    title: newsletter.title
    description: newsletter.description
    icon: newsletter.icon
    templates:
        subscriber:
            subscribe: 'AppBundle:Newsletter:subscribe.html.twig'
```