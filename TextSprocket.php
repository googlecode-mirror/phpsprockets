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
**     \  / /______\/ /          Email: ebowen at innova-partners dot com
**      \/___________/           Copyright (c) 2007, Innova Partners
**
**------------------------------------------------------------------------------
** The source code included in this package is free software; you can
** redistribute it and/or modify it under the terms of the GNU General Public
** License as published by the Free Software Foundation. This license can be
** read at:
**
** http://www.opensource.org/licenses/gpl-license.php
**
** This program is distributed in the hope that it will be useful, but WITHOUT 
** ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
** FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. 
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
