<?php
/*------------------------------------------------------------------------------
**       ____________
**      /\  ________ \           phpSprockets
**     /  \ \______/\ \          TextSprocket.php v0.9
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
	
	/**
	 * The base class every Sprocket inhereits from -- no tag, just text
	 * 
	 * @package phpSprockets
	 */
	class TextSprocket
	{
		/**
		 * Text Content of the Sprocket
		 *
		 * @var string
		 */
		protected $content;
		
		/**
		 * If true, will omit formatting tabs in output
		 *
		 * @var bool
		 */
		protected $force_inline;
		
		/**
		 * Constructor
		 *
		 * @param string The content of the TextSprocket
		 */
		public function __construct( $text )
		{
			$this->content = $text;	
		}
		
		/**
		 * Returns indentation for the required depth
		 *
		 * @param int Depth of indentation
		 * @return string
		 */
		public function tabs( $depth )
		{
			return "\n" . str_repeat( "\t", $depth );
		}
		
		/**
		 * Renders this TextSprocket
		 * 
		 * Note that this will just return the text representation of the 
		 * TextSprocket, suitable for sending to browser.  It does not actually
		 * print or echo anything to anywhere.
		 * 
		 * You can set the second param ($force_inline) to true to suppress 
		 * indentation on this TextSprocket, same as if you'd called 
		 * forceInline() earlier.
		 *
		 * @param int The formatting depth to start at, defaults to 0 (no indent)
		 * @param bool If true, do not indent
		 * @return formatted TextSprocket ready for output
		 */		
		public function render( $depth = 0, $force_inline = false )
		{
			if( $this->force_inline )
			{
				$force_inline = true;
			}
			
			if( $force_inline )
			{
				return $this->content;
			}
			else
			{
				return $this->tabs( $depth ) . $this->content;
			}
		}
	
		/**
		 * Set the forceInline parameter on this TextSprocket
		 * 
		 * Some tags -- like textarea -- don't respond well 
		 * to formatting tabs, so use this to suppress tabs in the
		 * rendered output.
		 * 
		 * @param bool $inline
		 */
		public function forceInline( $inline = true )
		{
			$this->force_inline = $inline;
		}
	}
