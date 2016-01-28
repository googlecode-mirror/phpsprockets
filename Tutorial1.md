## Hello world ##

Let's start with a div:

```
require_once 'phpSprockets/Sprocket.php';

$my_first_sprocket = new Sprocket('div');
```

And let's **give it an attribute**, such as a CSS class:

```
$my_first_sprocket->class = 'some_css_class';
```

## Add some tags to the div ##

```
$my_first_sprocket->h1( "Hello world" );
$my_first_sprocket->p( "This is the beginning of something really cool!" );
```

We can add any tag we like, even ones that don't exist in HTML.

## Output the HTML ##

```
echo $my_first_sprocket->render();
```

[Back to the tutorial page](tutorial.md)