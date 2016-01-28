You can add text, html and Sprockets to a Sprocket. The Sprocket figures out what you are adding.

## Set up some Sprockets ##

For example, suppose you have made a table, a table row and a table data cell, like this:

```
require_once 'phpSprockets/Sprocket.php';

$table = new Sprocket( 'table' );
$table_row = $table->tr();
$table_data = $table_row->td();
```

## Adding text ##
And suppose that we want to insert an image and some text into $table\_data. We can easily make the image part, like this:

```
$image = $table_data->img();
$image->src = 'images/an_image.jpg';
```

We can then add some plain text, by using the **add** function:

```
$table_data->add( "Hey everyone look at this image!" );
```

## Adding Sprockets ##
If we have Sprockets created elsewhere - from a factory or from a function, we can just add those too:

```
$another_sprocket = superCoolTitle( "I said LOOK" );
$table_data->add( $another_sprocket );
```

We can even add HTML from other functions, so you don't have to refactor your entire application to use Sprockets!

[Back to the tutorial page](tutorial.md)