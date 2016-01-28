This article discusses integrating [phpSprockets](http://code.google.com/p/phpsprockets/) with the [Zend Framework](http://framework.zend.com), a popular high-quality open source MVC framework for PHP.

## Sprockets ##
One of the nice things about phpSprockets is that it is a non-dogmatic library. Not only can you blend Sprockets with templating systems such as [Smarty](http://smarty.php.net/) on the output side, you can also integrate with existing code on the HTML generation side by inserting HTML directly into Sprockets.

This article is about one way that Sprockets can integrate with existing infrastructure; in this case, the impressive Zend Framework.

## Integration ##
The key to happy integration of tools is minimizing the number of points where integration needs to occur. In this case there is a single point of integration. Zend Framework is a Model:View:Controller architecture and phpSprockets is a code generator, so it makes sense for them to meet in the Zend Framework View mechanism.

```
require_once 'phpSprockets/Sprocket.php';

class Sprocket_View extends Zend_View
{
	protected $root_sprocket;

	public function __construct()
	{
		$this->root_sprocket = new Sprocket();
		parent::__construct();
	}
}
```

The approach we take here is to add to the view subclass a 'headless' Sprocket which will be the root for Sprockets and text added to the view during the view's render stage. The Sprocket is accessed by overriding the view's setter method, like this:

```
	public function __call( $name, $args )
	{
		return $this->content->__call( $name, $args );
	}
```

This means that any function calls that are otherwise undefined will be redirected to the Sprocket, where they will be interpreted as requests for new child Sprockets. This replaces the existing 'helper' method calls in the framework, which is not too dramatic as Sprockets have far more functionality than the helper classes.

We might also want to add already existing Sprockets, such as those created in a factory, or to add untagged text:

```
	public function add( $sprocket )
	{
		$this->root_sprocket->add( $sprocket );
 	}
```

## Using the view ##
The new view subclass is effectively a Sprocket; for instance, in the actual View file we can add a table like this:
```
/* TableView.php */

$a_table = $this->table();		// create the table Sprocket
$a_table->class = 'my_css_class';	// set the class attribute

// create a row
$header_row = $a_table->tr();

$header_row->th( "Category 1" );
$header_row->th( "Category 2" );
$header_row->th( "Category 3" );

// create another row
$data_row = $a_table->tr();

$data_row->td( "Cats" );
$data_row->td( "Dogs" );
$data_row->td( "Cadillacs" );

// lets add a ready-made button
$button = Sprocket_Forms::ScriptButton( "Click me", "alert( 'thanks for clicking me!' )" );
$this->add( $button );
 
```

## Output ##
To output the view contents, we override Zend\_View's _run() method:_

```
	protected function _run()
	{
		include func_get_arg( 0 );
		echo $this->root_sprocket->render();
	}
```

Rendering a view returns an HTML string just as before; our controller is going to do something like this:

```
	public function indexAction()
	{
		$view = new Sprocket_View();
		$view->setScriptPath( '../application/views' );

		echo $view->render( 'TableView.php' );
	}
```

(OK, this is example code; a more refined controller action will be just a matter of sandwiching the view's output between a header and footer, either as rendered HTML, or as a Sprocket if your page output routines use Sprockets, or with a template system such as Smarty).

The SprocketView class can be rendered successively, like this:
```
		$view->render( 'HeaderView.php' );
		$view->render( 'MenuView.php' );
		$view->render( 'ContentView.php' );
		$html = $view->render( 'FooterView.php' );
```

Incidentally, TableView.php would render this HTML:
```
<table class="my_css_class">
	<tr>
		<th>
			Category 1
		</th>
		<th>
			Category 2
		</th>
		<th>
			Category 3
		</th>
	</tr>
	<tr>
		<td>
			Cats
		</td>
		<td>
			Dogs
		</td>
		<td>
			Cadillacs
		</td>
	</tr>
</table>
<input type="button" value="Click me!" onclick="alert('thanks for clicking me!')" />
```

## Conclusion ##
phpSprockets adds to MVC architectures such as Zend Framework a lucid way of generating HTML. The points of integration are minimal and the integration is at will.

