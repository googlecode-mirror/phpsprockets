## Typical HTML generation by string concatenation ##
_from Mediawiki_

```
$anchoropen  = "<a href=\"{$full_url}\">";
$anchorclose = "</a><br />";
[...]
$wgOut->addHTML( '<div class="fullImageLink" 
        id="file">' . $anchoropen . "<img border=\"0\" 
        src=\"{$url}\" width=\"{$width}\" height=\"{$height}\"
        alt=\"" . htmlspecialchars( $this->img->getTitle()->getPrefixedText() )
        .'" />' . $anchorclose . '</div>' );
```

The code is part of a complex HTML generation process.

## How to do the same thing with phpSprockets ##

```
// include the library
require_once 'phpSprockets/Sprocket.php';

// create the root sprocket
$output = new Sprocket('div');
$output->class = 'fullImageLink';
$output->id = 'file';

// add an anchor inside the root div
$anchor = $output->a();
$anchor->href = $full_url;

// add an image inside the anchor and then add attributes to it
$link_image = $anchor->img();
$link_image->src = $url;
$link_image->height = $height;
$link_image->width = $width;
$link_image->alt = $alt_text;

// output the HTML to the existing application infrastructure
$wgOut->addHTML( $output->render() );
```

Although the Sprockets code is longer, it is more readable because there is no need for escaping quotes, curly braces or string concatenation. There are no closing quotes, and each attribute is expressly declared on its own line.

## Where's the beef? ##

The above is an example of HTML generation at its simplest. When HTML generation becomes more complex, keeping track of tags can become burdonsome. We have all encountered functions with lines like this:

```
    }
}
if( $is_heading) echo "</th>";
else echo "</td>";
echo "</tr></table>";
if( $use_form ) echo "</form>";
```

Sprockets equivalent:

```
// you don't need to close tags with Sprockets
```

Keeping track of closing tags can make code hard to read. Once you have (say) client-side validating form elements inside a table inside a form inside a tabbed interface, HTML decorated with PHP can easily become incomprehensible even to the person who wrote it.