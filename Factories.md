## What is a Sprocket factory? ##

A Sprocket factory is a class containing static functions that generate sprockets. For example, an image factory might have a function like this:

```
Sprocket_Image::Image( $image_src, $width, $height, $alt_text );
```

Which would return a single Sprocket that would render an <img /> tag. A more complex example might be a factory making image links:

```
Sprocket_Image::ImageLink( $href, $src, $width, $height, $alt_text )
```

Which would return a Sprocket that would render an img tag nested within an anchor tag.

## Why use factories? ##

### Enforce standards ###
Besides the obvious advantage of code reuse, factories can enforce standards. For example, an <img /> tag is not valid W3C HTML without an alt attribute. A factory can enforce validation compliance according to your project standards.

### Code Segregation ###
Even if you are using an MVC structured framework, there is a persistent tendency for reusable code to be developed in the application domain. Factories make it easy to keep reusable code separate and portable, and help keep your presentation-layer code short and readable.

### Refactoring ###
Factories focus code generation in a single place, making refactoring for external standards easier.

## Available factories ##

The phpSprockets library currently contains the following factories:

  * `Sprocket_Forms`: _HTML form and form element factory_

Since the Sprockets code is simple and stable, most development of this library will be in the form of new factories. You are encouraged to submit factories to the library.