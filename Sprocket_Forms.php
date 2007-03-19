<?php
/*------------------------------------------------------------------------------
**       ____________
**      /\  ________ \           phpSprockets
**     /  \ \______/\ \          Sprocket_Forms.php v0.9
**    / /\ \ \  / /\ \ \       
**   / / /\ \ \/ / /\ \ \        HTML form element factory 
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
	
	require_once 'Sprocket.php';
	
	/**
	 * This is the first Sprocket Factory written, so it's sort of the 
	 * reference implementation.  An example of how to extend Sprockets
	 * to make life even easier.
	 * 
	 * This class has convenience functions to create [X]HTML Forms.  Rather
	 * than constructing the Sprockets by hand, or worse yet writing HTML by
	 * hand with string concatenation, this class provides methods that
	 * assemble the appropriate Sprockets and returns a composite Sprocket.
	 * 
	 * @package phpSprockets
	 */
	class Sprocket_Forms extends Sprocket
	{
		
		/**
		 * Creates an HTML Form
		 *
		 * @param string The name attribute of the form
		 * @param string the action attribute of the form
		 * @return Sprocket the parent Form Sprocket
		 */
		public static function Form( $name = null, $action = null )
		{
			
			$tag = new Sprocket( 'form' );	
			
			if( $name )
			{
				$tag->name = $name;
			}
			
			$tag->method = 'post';
			
			if( $action )
			{
				$tag->action = $action;
			}
			
			return $tag;
		}
		
		
		/**
		 * Builds an HTML Input tag
		 *
		 * Note that we don't do any validation (yet) on the parameters, so
	     * just like when writing your own HTML you can create input tags with
	     * invalid "type" attributes.
		 * 
		 * @param string The type parameter of the input tag
		 * @param string The name parameter of the input tag
		 * @param string the Value parameter of the input tag
		 * @return Sprocket the Input Sprocket
		 */
		public static function Input( $type, $name = null, $value = null )
		{
			// <input type="$type" name="$name" value="$value"  />
			
			$tag = new Sprocket( 'input' );
			
			if( $name !== null )
			{
				$tag->name = $name;
			}
			
			$tag->type = $type;
			
			if( $value !== null )
			{
				$tag->value = $value;
			}
			
			return $tag;
		}
		
		/**
		 * Convenience function for creating Password fields.  Same as
		 * Input() but provides the type="password" for you
		 *
		 * @param string The name of your input field
		 * @param string The value of your input field
		 * @return Sprocket The Input Sprocket
		 */
		public static function PasswordInput( $name, $value = null )
		{
			// <input type="password" name="$name" value="$value"  />
			
			return self::Input( 'password', $name, $value );
		}
		
		/**
		 * Convenience function to create a Text Input field.
		 *
		 * @param string The name of your input field
		 * @param string The value of your input field
		 * @return Sprocket The Input Sprocket
		 */
		public static function TextInput( $name, $value = null )
		{
			# <input type="text" name="$name" value="$value"  />
			
			return self::Input( 'text', $name, $value );
		}
		
		/**
		 * Convenience function to create an Input Button 
		 *
		 * @param string The name of your input button
		 * @param string The value of your input button
		 * @return Sprocket The Input Sprocket
		 */
		public static function ButtonInput( $name, $value )
		{
			// <input type="button" name="$name" value="$value"  />
			
			return self::Input( 'button', $name, $value );
		}
		
		
		/**
		 * Convenience function to create a Hidden Input
		 *
		 * <input type="hidden" name="$name" value="$value"  />
		 * 
		 * @param string The name of your hidden field
		 * @param string The value of your hidden field
		 * @return Sprocket The Input Sprocket
		 */
		public static function HiddenInput( $name, $value )
		{
			
			return self::Input( 'hidden', $name, $value );
		}
		
		/**
		 * Builds an HTML image input field
		 *
		 * <input type="image" name="$name" src="src" alt="$alt" />
		 * 
		 * @param string The name of your hidden field
		 * @param string The value of your hidden field
		 * @return Sprocket The Input Sprocket
		 */
		public static function ImageInput( $name, $src, $alt = null )
		{
			
			$input = self::Input( 'image', $name );
			$input->src = $src;
			
			// try to put something in the alt field
			if( $alt == null )
			{
				$alt = $name;
			}
			
			$input->alt = $alt;
			
			return $input;
		}
		
		
		/**
		 * Builds an HTML Submit button
		 *
		 * Note: the Submit button has no name, so will not show up in the 
		 * GET or POST data.
		 * 
		 * <input type="submit" value="$value" />
		 * 
		 * @param string The Value (label) of the Submit Button 
		 * @return Sprocket the Submit Sprocket
		 */
		public static function SubmitInput( $value = null )
		{ 	
			return self::Input( 'submit', null, $value );
		}
		
		/**
		 * Convenience function to create an HTML File Input field
		 *
		 * <input name="$name" type="file" />
		 * 
		 * @param string the name of the file input field
		 * @return Sprocket the Sprocket Input Field
		 */
		public static function FileInput( $name )
		{
			return self::Input( 'file', $name );
		}
		
		
		/**
		 * Builds an HTML Select (dropdown)
		 * 
		 * $options (second param) is in $value => $label format:
		 *  'OH' => 'Ohio'
		 *  '1'  => 'January'
		 * and so on.
		 * 
 		 *	<select name="$name">
		 *		<option>...</option>
		 *		...
		 *	 </select>
		 *
		 * @param string The name attribute of the select 
		 * @param array The options for the select, $value => $label
		 * @param string The default value, matches a key in the Options map
		 * @return Sprocket the Sprocket Select tag, with all options
		 */
		public static function SelectInput( $name, $options, $default = null )
		{

			
			$tag = new Sprocket( 'select' );
			$tag->name = $name;	
			
			foreach( $options as $value => $label )
			{
				$option = $tag->option( $label );
				
				if( $value == $default )
				{
					$option->selected = 'selected';
				}
				
				$option->value = $value;
			}
			
			return $tag;
		}
		
		/**
		 * Builds an HTML Select (dropdown) with 
		 * grouped options.
		 * 
		 * The $array parameter that specifies the options looks like this:
		 * 
		 *  $array = array(
		 * 		['Group 1'] = array(
		 * 			['1'] => 'Group 1 Option 1'
		 * 			['2'] => 'Group 1 Option 2'
		 * 		)
		 *		['Group 2'] = array(
		 * 			['3'] => 'Group 2 Option 1'
		 * 			['4'] => 'Group 2 Option 2'
		 * 		)
		 * 	)
		 * 
 		 *	 <select name="$name">
	 	 *	 	<optgroup label="...">
	 	 *			<option>...</option>
	 	 *			...
	 	 *		</optgroup>
	 	 *	 	<optgroup label="...">
	 	 *			<option>...</option>
	 	 *			...
	 	 *		</optgroup>
	 	 *		...
	 	 *	 </select>
		 *
		 * @param string The name attribute on the select tag
		 * @param string the default option, matches a key in one of the sub-arrays
		 * @param array Nested arrays of option groups and options
		 * @return Sprocket the Sprocket Select tag, with all options
		 */
		public static function GroupedSelect( $name, $default, $array )
	 	{
	 		
 			// build a select with optgroup headers
 			$select = new Sproket( 'select' );
 			$select->name = $name;
 			
 			foreach( $array as $optgroup_name => $options )
 			{
 				$optgroup = $select->optgroup();
 				$optgroup->label = $optgroup_name;
 				
 				foreach( $options as $option_value => $option_label )
 				{
 					$option	= $optgroup->option( $option_label );
 					$option->value = $option_value;
 					
 					if( $option_value == $default )
 					{
 						$option->selected = null;	
 					}
 				}
 			}
 			return $select;
 		}
 		
 		/**
 		 * Builds a new HTML input field with a label wrapped around it,
 		 * useful for making radio buttons.
 		 * 
 		 * <label><input type="$type" name="$name" value="$value" />$title</label>
 		 * 
 		 * @param string The name attribute of the input tag
 		 * @param string the text for the label
 		 * @param string The type attribute of the input tag
 		 * @param string The value attribute of the input tag
 		 * @param string If this parameter is the same as the value parameter, set this as default
 		 * @return Sprocket The label tag, with Input tag nested
 		 */
		public static function LabeledInput( $name, $title, $type, $value, $default )
		{
			
			$label = new Sprocket( 'label' );
			$input = $label->input();
			$input->type = $type;
			$input->name = $name;
			$input->value = $value;
			
			if( $value == $default ) $input->selected = 'selected';
			$label->add( $title );
			
			return $label;
		}
		
		/**
		 * Builds an HTML radio button  wrapped in a label
		 * 
		 * <label><input type="radio" name="$name" value="$value" />$title</label>
		 *
		 * @param string The name of the input tag
		 * @param string The text for the label
		 * @param string The value of the input tag
		 * @param string If this string matches the value, this will be selected
		 * @return Sprocket the sprocket input tag
		 */
		public static function LabeledRadio( $name, $title, $value, $default )
		{
			return self::LabeledInput( $name, $title, 'radio', $value, $default );
		}
		
		
		/**
		 * Builds an HTML checkbox wrapped in an HTML label
		 * 
		 * <label><input type="checkbox" name="$name" value="$value" />$title</label>
		 *
		 * @param string The name of the input tag
		 * @param string The text for the label
		 * @param string The value of the input tag
		 * @param string If this string matches the value, this will be selected
		 * @return Sprocket the sprocket input tag
		 */
		public static function LabeledCheckbox( $name, $title, $value, $default = null )
		{
			return self::LabeledInput($name, $title, 'checkbox', $value, $default);
		}
		
		/**
		 * Builds an HTML Textarea (multi-line text field)
		 *
		 * <textarea name="$name">$content</textarea>
		 *
		 * @param string The name of the textarea tag
		 * @param string The content of the textarea (defaults to empty)
		 * @return Sprocket the Sprocket textarea tag
		 */
 		public static function TextArea( $name, $content = '' )
 		{
 			$textarea = new Sprocket( 'textarea' );
 			$textarea->forceInline();
 			$textarea->name = $name;
 			$textarea->add( $content );
 			
 			return $textarea;
 		}
	}

