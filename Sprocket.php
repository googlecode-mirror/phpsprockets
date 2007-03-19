<?php
/*------------------------------------------------------------------------------
**       ____________
**      /\  ________ \           phpSprockets
**     /  \ \______/\ \          Sprocket.php v0.9
**    / /\ \ \  / /\ \ \       
**   / / /\ \ \/ / /\ \ \        The neat way to generate HTML and XML
**  / / /__\_\/ / /__\_\ \     
** / /_/_______/ /________\    
** \ \ \______ \ \______  /    
**  \ \ \  / /\ \ \  / / /       by Eddie Bowen, Keith Avery and Jon Canady
**   \ \ \/ / /\ \ \/ / /        
**    \ \/ / /__\_\/ / /       
**     \  / /______\/ /          
**      \/___________/           Email: ebowen at innova-partners dot com
**
**------------------------------------------------------------------------------
** Copyright (c) 2007, Innova Partners
** Permission is hereby granted, free of charge, to any person obtaining 
** a copy of this software and associated documentation files (the 
** "Software"), to deal in the Software without restriction, including 
** without limitation the rights to use, copy, modify, merge, publish, 
** distribute, sublicense, and/or sell copies of the Software, and to 
** permit persons to whom the Software is furnished to do so, subject to 
** the following conditions:

** The above copyright notice and this permission notice shall be included 
** in all copies or substantial portions of the Software.

** THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
** OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF 
** MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. 
** IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY 
** CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, 
** TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE 
** SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
**------------------------------------------------------------------------------
*/
	
	require_once 'TextSprocket.php';

	/**
	 * This is the main class you interact with while using phpSprockets.
	 * 
	 * @package phpSprockets
	 */
	class Sprocket extends TextSprocket
	{
		/**
		 * The XML tag this Sprocket represents.  
		 *
		 * @var string
		 */
		protected $tag;
		
		/**
		 * A map of tag attributes.  In the form "attribute" => "value"
		 *
		 * @var array
		 */
		protected $attributes;
		
		/**
		 * Constructor
		 * 
		 * The parameter specifies the XML tag to represent.  We do no 
		 * validation here, so a tag can be any legal string.
		 * 
		 * Note that the parameter is optional.  You can have a Sprocket that
		 * doesn't have an XML tag associated with it, in which case it acts
		 * mostly like a TextSprocket.
		 *
		 * @param string $tag
		 */
		public function __construct( $tag = null )
		{
			
			if( $tag )
			{
				$this->tag = $tag;
			}
		}
		
		/**
		 * Appends or prepends a child element to this Sprocket.
		 * 
		 * If the parameter is another Sprocket, it simply adds the 
		 * Sprocket as a child of this Sprocket.  If it is not, we assume it
		 * is a string and wrap it in a TextSprocket.
		 *
		 * Returns a reference back to this Sprocket to support fluid notation.
		 * 
		 * @param mixed THe item to add to this Sprocket
		 * @param bool If true, prepend, if false, append
		 * @return $this for fluid notation
		 */
		protected function execAdd( $item, $prepend = false )
		{
			// this function abstracted out to allow prepends
			
			// lazily construct the content array
			if( !$this->content )
			{
				$this->content = array();
			}
			
			// encapsulate any non-tag objects
			if( !is_a( $item, 'Sprocket' ) )
			{
				// make a text object
				$text_item = new TextSprocket($item);
				
				// add the text object to the content
				$child = $text_item;
			}
			else
			{
				// add the tag to the content
				$child = $item;
			}
			
			if( $prepend )
			{	
				array_unshift( $this->content, $child );
			}
			else
			{		
				$this->content[] = $child;
			}
			
			return $this;
		}
		
		/**
		 * Append a child element to this sprocket.
		 *
		 * Returns a reference back to this Sprocket to support fluid notiation.
		 * 
		 * @param mixed The sprocket or text to append
		 * @return $this, for fluid notation
		 */
		public function add( $item )
		{
			return $this->execAdd( $item );
		}
		
		/**
		 * Prepend a child element to this sprocket.
		 *
		 * @param mixed The sprocket or text to prepend
		 * @return $this, for fluid notation
		 */
		public function prepend( $item )
		{
			return $this->execAdd( $item, true );
		}
		
		/**
		 * Append each element of an array to this Sprocket.
		 *
		 * @param array The array of sprockets or text to append
		 * @return $this, for fluid notation
		 */
		public function addArray( $array )
		{
			foreach( $array as $item )
			{
				$this->add( $item );
			}
			
			return $this;
		}
		
		/**
		 * Magic Method that appends a new Sprocket to this one.
		 * 
		 * Takes the name of the method and creates a new sprocket of that
		 * tag name.  ($div->p() would create a new <p> tag under $div, 
		 * assuming $div is a Sprocket.)
		 * 
		 * Takes the parameter and appends it to the new Sprocket.  
		 * ($div->p('This is a test'); would add the text "This is a test" to 
		 * the new <p> tag.)
		 * 
		 * Then, appends the new sprocket to this Sprocket.
		 * 
		 * Finally, returns a reference to the new Sprocket, so you can 
		 * fluidly chain these.  $sprocket->div('This is a bold ')->b('example');
		 *
		 * @param string name of the tag to append (the called method)
		 * @param mixed Data to add  (the parameter on the called method)
		 * @return refernce to the newly appended sprocket, for fluid notation
		 */
		public function __call( $name, $values )
		{
			// this is the default tag constructor
			$new_tag = new Sprocket( $name );
			
			// pass the values to the tag
			$new_tag->addArray( $values );
			$this->add( $new_tag );
			
			return $new_tag;
		}
		
		/**
		 * Magic Method that sets an attribute on this sprocket.
		 * 
		 * Takes the property that's being referenced, turns it into an 
		 * attribute of this sprocket, and assigns the value to the new 
		 * attribute.
		 * 
		 * ($p is a Sprocket <p> tag)
		 * $p->class = 'sprocket_test';
		 * Creates: <p class="sprocket_test">
		 *
		 * @param string the attribute name (the called property)
		 * @param string the attribute value (the value assigned to the called prop)
		 */
		public function __set( $name, $value )
		{
			if( !$this->attributes )
			{
				$this->attributes = array();
			}
			
			$this->attributes[$name] = $value;
		}
		
		/**
		 * Renders the Sprocket for output.
		 *
		 * render slightly differenty with force inline:
		 * if a tag is set to render inline, it still renders the tabs
		 * before the opening tag. If a tag's parent is set to inline,
		 * don't render any tabs
		 * 
		 * Also, if a Sprocket has no content it will be rendered as a 
		 * short tag (like <hr />) for XML compliance.
		 * 
		 * @param int The rendering depth to begin at, defaults to 0
		 * @param bool Suppress formatting tabs inside the tag? defaults to false
		 * @return string Rendered output of the Sprocket and all children.
		 */
		public function render( $depth = 0, $force_inline = false )
		{
			
			if( $force_inline )
			{
				$tabs = '';
			}
			else
			{
				$tabs = $this->tabs($depth);
				
				if( $this->force_inline )
				{
					$force_inline = true;
				}
			}
			
			// assemble the output non-inline:
			$html = $tabs;
			
			// short tags are tags that have no children:
			if( $this->content )
			{
				// full tag
				$html .= $this->renderOpeningTag();
				$html .= $this->renderContent( $depth, $force_inline );
				
				if( !$force_inline )
				{
					$html .= $tabs;
				}
				
				$html .= $this->renderClosingTag();
			}
			else
			{
				// short tag
				$html .= $this->renderOpeningTag();
			}
			return $html;
		}
		
		
		/**
		 * Renders the opening tag of the Sprocket, along with all attributes.
		 *
		 * @return string The rendered opening tag
		 */
		private function renderOpeningTag()
		{
			if( $this->tag )
			{
				$html = sprintf( "<%s", $this->tag );
			
				if( $this->attributes )
				{
					// if we're adding attributes, add them
					$html .= ' ' . $this->renderAttributes(); 
				}
				
				if( $this->content )
				{
					// long tag
					$html .= ">";
				}
				else
				{
					// short tag
					$html .= " />";
				}
			}
			else
			{
				$html = null;
			}
			
			return $html;
		}
		
		/**
		 * Renders the attributes for the opening tag.
		 *
		 * Use double quotes for the attributes so that
		 * javascript functions can use single quotes
		 *		
		 * if an attribute is null, just pass the key
		 * so we have a way to make oddly formed attributes
		 * such as 'selected' or 'checked' (HTML-style)
		 * 
		 * @return rendered string of attributes
		 */
		private function renderAttributes()
		{
			// make an array of the attributes as they will appear:
			$html_array = array();
			
			foreach( $this->attributes as $key => $value )
			{
				
				if( $value === null )
				{
					$html_array[] = $key;
				}
				else
				{
					$html_array[] = sprintf( "$key=\"$value\"" );
				}
			}
			
			// join the array with spaces
			return implode( ' ', $html_array );
		}
		
		/**
		 * Render the content of the Sprocket
		 * 
		 *
		 * @param int Current tab depth, defaults to 0
		 * @param bool Suppress indentation tabs in output?  Defaults to false.
		 * @return string Rendered content of this Sprocket.
		 */
		public function renderContent( $depth = 0, $force_inline = false )
		{
			// now add the content
			$html = '';
			
			if( $this->content )
			{
				foreach( $this->content as $item )
				{
					$html .= $item->render( $depth + 1, $force_inline );
				}
			}
			
			return $html;
		}
		
		/**
		 * Renders the closing tag on this Sprocket.
		 *
		 * @return string the formatted closing tag.
		 */
		private function renderClosingTag()
		{	
			// now close the tag
			if( $this->tag )
			{
				return sprintf( "</%s>", $this->tag );
			}
			else
			{
				return null;
			}
		}
	}
	