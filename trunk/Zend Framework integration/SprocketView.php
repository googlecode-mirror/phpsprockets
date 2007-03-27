<?php
/*------------------------------------------------------------------------------
**       ____________
**      /\  ________ \           phpSprockets
**     /  \ \______/\ \          SprocketView.php v0.9.2
**    / /\ \ \  / /\ \ \       
**   / / /\ \ \/ / /\ \ \        The neat way to generate HTML and XML
**  / / /__\_\/ / /__\_\ \     
** / /_/_______/ /________\    
** \ \ \______ \ \______  /    
**  \ \ \  / /\ \ \  / / /       by Eddie Bowen
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
	 * Embeds a Sprocket in a Zend_View subclass
	 * 
	 * @package phpSprockets
	 */
 	class Sprocket_View extends Zend_View
 	{
 		protected $root_sprocket;
 		
 		public function __construct()
 		{
	 		$this->root_sprocket = new Sprocket();
	 		parent::__construct();
 		}
 		
 		/**
	     * Replaces helper objects with Sprockets
	     *
	     * @param mixed $incoming_content untyped content to insert
	     */
 		public function add( $incoming_content )
 		{
 			// we're adding something to the root sprocket
 			$this->root_sprocket->add( $incoming_content );
 		}
 		
	 	/**
	     * Replaces helper objects with Sprockets
	     *
	     * @param string $name The helper name.
	     * @param array $args The parameters for the helper.
	     * @return string The result of the helper output.
	     */
	    public function __call($name, $args)
	    {
	        return $this->root_sprocket->__call($name, $args);
	    }
	    
	    /**
	     * Zend Framework standard rendering action
	     *
	     * @return string The rendered output of the Sprocket.
	     */
 		protected function _run()
 		{
 			include func_get_arg(0);
 			echo $this->root_sprocket->render();
 		}
 	}

