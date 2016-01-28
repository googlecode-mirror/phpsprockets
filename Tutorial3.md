Sprocket factories are great for producing code without writing the same thing over and over. A factory is a collection of static functions.

## Create a form using Sprocket\_Forms ##

```
require_once 'phpSprockets/Sprocket_Forms.php';

$my_form = Sprocket_Forms::Form( 'form_name' );
```
You should consult the factory documentation or code to see what arguments are needed.

## Add some form elements ##

Sprocket\_Forms has a whole bunch of functions to make common and not-so-common form elements. When we make an element, we just add it to the form we made:

```
$name_input = Sprocket_Forms::textInput( 'name' );
$my_form->add( $name_input );

$password_input = Sprocket_Forms::passwordInput( 'pswd' );
$my_form->add( $password_input );
```


## Add a Select ##

Sprocket\_Forms lets you define a select using an associative array:

```
$options = array( 
              'cc' => "Credit card",
              'gc' => "Gift card",
              'gb' => "Gold bullion" );

$payment_menu = Sprocket_Forms::SelectInput( 'payment', $options );
$my_form->add( $payment_menu );
```

_Look how clean that code is compared to most PHP Select routines !_

[Back to the tutorial page](tutorial.md)