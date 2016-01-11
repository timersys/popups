<?php 

/*
*  Spu Rules
*  Class that will compare rules and determine if popup needs to show
*  @since: 2.0
*/

class Spu_Rules
{
	/**
	 * post id used to check rules
	 * @var int
	 */
	protected $post_id;
	
	/**
	 * referrer using in ajax calls
	 * @var string
	 */
	protected $referrer;

	/**
	 * Is category using in ajax calls
	 * @var boolean
	 */
	protected $is_category = false;

	/**
	 * Is archive using in ajax calls
	 * @var boolean
	 */
	protected $is_archive = false;

	/**
	 * Is searchu sed in ajax calls
	 * @var boolean
	 */
	protected $is_search = false;

	/*
	*  __construct
	*  Add all the filters to use later
	*/
	
	function __construct()
	{
		global $post;
		
		// User
		add_filter('spu/rules/rule_match/user_type', array($this, 'rule_match_user_type'), 10, 2);
		add_filter('spu/rules/rule_match/logged_user', array($this, 'rule_match_logged_user'), 10, 2);
		add_filter('spu/rules/rule_match/left_comment', array($this, 'rule_match_left_comment'), 10, 2);
		add_filter('spu/rules/rule_match/search_engine', array($this, 'rule_match_search_engine'), 10, 2);
		add_filter('spu/rules/rule_match/same_site', array($this, 'rule_match_same_site'), 10, 2);

		// Post
		add_filter('spu/rules/rule_match/post_type', array($this, 'rule_match_post_type'), 10, 2);
		add_filter('spu/rules/rule_match/post_id', array($this, 'rule_match_post'), 10, 2);
		add_filter('spu/rules/rule_match/post', array($this, 'rule_match_post'), 10, 2);
		add_filter('spu/rules/rule_match/post_category', array($this, 'rule_match_post_category'), 10, 2);
		add_filter('spu/rules/rule_match/post_format', array($this, 'rule_match_post_format'), 10, 2);
		add_filter('spu/rules/rule_match/post_status', array($this, 'rule_match_post_status'), 10, 2);
		add_filter('spu/rules/rule_match/taxonomy', array($this, 'rule_match_taxonomy'), 10, 2);
		
		// Page
		add_filter('spu/rules/rule_match/page', array($this, 'rule_match_post'), 10, 2);
		add_filter('spu/rules/rule_match/page_type', array($this, 'rule_match_page_type'), 10, 2);
		add_filter('spu/rules/rule_match/page_parent', array($this, 'rule_match_page_parent'), 10, 2);
		add_filter('spu/rules/rule_match/page_template', array($this, 'rule_match_page_template'), 10, 2);

		//Other
		add_filter('spu/rules/rule_match/mobiles', array($this, 'rule_match_mobiles'), 10, 2);
		add_filter('spu/rules/rule_match/tablets', array($this, 'rule_match_tablets'), 10, 2);
		add_filter('spu/rules/rule_match/referrer', array($this, 'rule_match_referrer'), 10, 2);

		$this->post_id 	= isset( $post->ID ) ? $post->ID : '';
		$this->referrer = isset($_SERVER['HTTP_REFERRER']) ? $_SERVER['HTTP_REFERRER'] : '';
 
		if( defined('DOING_AJAX') ) {

			if( isset( $_REQUEST['pid'] ) ) {
				$this->post_id = $_REQUEST['pid'];
			}
			if( !empty( $_REQUEST['referrer'] ) ) {
				$this->referrer = $_REQUEST['referrer'];
			}
			if( !empty( $_REQUEST['is_category'] ) ) {
				$this->is_category = true;
			}
			if( !empty( $_REQUEST['is_archive'] ) ) {
				$this->is_archive = true;
			}
			if( !empty( $_REQUEST['is_search'] ) ) {
				$this->is_search = true;
			}
		}
		
	}
	
	
	/*
	*  check_rules
	*
	* @since 1.0.0
	*/
	
	function check_rules( $rules = '' )
	{
		
		//if no rules, add the box
		$add_box = true;

		if( !empty( $rules ) ) {
			// vars
			$add_box = false;
			

			foreach( $rules as $group_id => $group ) {
				// start of as true, this way, any rule that doesn't match will cause this varaible to false
				$match_group = true;
				
				if( is_array($group) )
				{

					foreach( $group as $rule_id => $rule )
					{	
						
						// $match = true / false
						$match = apply_filters( 'spu/rules/rule_match/' . $rule['param'] , false, $rule );

						if( !$match )
						{
							$match_group = false;
						}
						
					}
				}
				
				
				// all rules must havematched!
				if( $match_group )
				{
					$add_box = true;
				}
				
			}
				
			
		}
		
	
		return $add_box;
	}
	
	/**
	 * [rule_match_logged_user description]
	 * @param  bool $match false default
	 * @param  array $rule rule to compare
	 * @return boolean true if match
	 */
	function rule_match_logged_user( $match, $rule ) {

		if ( $rule['operator'] == "==" ) {
			
			return is_user_logged_in();

		} else {

			return !is_user_logged_in();

		}	

	}	

	/**
	 * [rule_match_mobiles description]
	 * @param  bool $match false default
	 * @param  array $rule rule to compare
	 * @return boolean true if match
	 */
	function rule_match_mobiles( $match, $rule ) {

		require_once 'Mobile_Detect.php';
		$detect = new Mobile_Detect;

		if ( $rule['operator'] == "==" ) {
			
			return $detect->isMobile();

		} else {

			return !$detect->isMobile();

		}	

	}
	/**
	 * [rule_match_tablets description]
	 * @param  bool $match false default
	 * @param  array $rule rule to compare
	 * @return boolean true if match
	 */
	function rule_match_tablets( $match, $rule ) {

		require_once 'Mobile_Detect.php';
		$detect = new Mobile_Detect;

		if ( $rule['operator'] == "==" ) {
			
			return $detect->isTablet();

		} else {

			return !$detect->isTablet();

		}		

	}
	
	/**
	 * [rule_match_left_comment description]
	 * @param  bool $match false default
	 * @param  array $rule rule to compare
	 * @return boolean true if match
	 */
	function rule_match_left_comment( $match, $rule ) {

		if ( $rule['operator'] == "==" ) {
			
			return !empty( $_COOKIE['comment_author_'.COOKIEHASH] ); 
		
		} else {

			return empty( $_COOKIE['comment_author_'.COOKIEHASH] );

		}	

	}	
	/**
	 * [rule_match_search_engine description]
	 * @param  bool $match false default
	 * @param  array $rule rule to compare
	 * @return boolean true if match
	 */
	function rule_match_search_engine( $match, $rule ) {

		$ref = $this->referrer;

		$SE = apply_filters( 'spu/rules/search_engines', array('/search?', '.google.', 'web.info.com', 'search.', 'del.icio.us/search', 'soso.com', '/search/', '.yahoo.', '.bing.' ) );

		foreach ($SE as $url) {
			if ( strpos( $ref,$url ) !==false ){
				
				return  $rule['operator'] == "==" ? true : false;
			}			
		}

		return $rule['operator'] == "==" ? false : true;

	}

	/**
	 * Check for user referrer
	 * @param  bool $match false default
	 * @param  array $rule rule to compare
	 * @return boolean true if match
	 */
	function rule_match_referrer( $match, $rule ) {

		$ref = $this->referrer;

		if ( strpos( $ref,$rule['value'] ) !==false ){
			return  $rule['operator'] == "==" ? true : false;
		}

		return $rule['operator'] == "==" ? false : true;

	}

	/**
	 * [rule_match_same_site description]
	 * @param  bool $match false default
	 * @param  array $rule rule to compare
	 * @return boolean true if match
	 */
	function rule_match_same_site( $match, $rule ) {

		
		$ref = $this->referrer;

		$internal = str_replace( array( 'http://','https://' ), '', site_url() );
		

		if( $rule['operator'] == "==" ) {

			return !preg_match( '~' . $internal . '~i', $ref );

		} else {

			return preg_match( '~' . $internal . '~i', $ref );

		}	

	}


	/*
	*  rule_match_post_type
	*
	* @since 1.0.0
	*/
	
	function rule_match_post_type( $match, $rule )
	{
		

		$post_type = $this->get_post_type();


        if( $rule['operator'] == "==" )
        {
        	$match = ( $post_type === $rule['value'] );
        }
        elseif( $rule['operator'] == "!=" )
        {
        	$match = ( $post_type !== $rule['value'] );
        }
        
	
		return $match;
	}
	
	
	/*
	*  rule_match_post
	*
	* @since 1.0.0
	*/
	
	function rule_match_post( $match, $rule )
	{
		
		$post_id = $this->post_id;
		
        if($rule['operator'] == "==")
        {
        	$match = ( $post_id == $rule['value'] );
        }
        elseif($rule['operator'] == "!=")
        {
        	$match = ( $post_id != $rule['value'] );
        }
        
        return $match;

	}
	
	
	/*
	*  rule_match_page_type
	*
	* @since 1.0.0
	*/
	
	function rule_match_page_type( $match, $rule )
	{
		

		$post_id 		= $this->post_id;

		$post 			= get_post( $post_id );

		$post_parent 	= isset( $post->post_parent ) ? $post->post_parent : ''; 
		
		$post_type 		= $this->get_post_type();
		        
        if( $rule['value'] == 'front_page') {
        	
	        $front_page = (int) get_option('page_on_front');

	      	if( $front_page !== 0 ) {

		        if($rule['operator'] == "==") {
		       
		        	$match = ( $front_page == $post_id );
		       
		        } elseif($rule['operator'] == "!=") {
		       
		        	$match = ( $front_page != $post_id );
		       
		        }
	      	} else {
	      		// if doing ajax is_home won't work so we do a workaround
	      		if( defined( 'DOING_AJAX') ) {
	      		
			      	$front_page = get_option( 'show_on_front' );	
		      		
		      		if($rule['operator'] == "==") {
			       
			        	$match = ( 'posts' == $front_page && $post_id == 0 );
			       
			        } elseif($rule['operator'] == "!=") {
			       
			        	$match = !( 'posts' == $front_page && $post_id == 0 );
			       
			        }
	      			

	      		} else {
	      			
		      		if($rule['operator'] == "==") {
			       
			        	$match = is_home();
			       
			        } elseif($rule['operator'] == "!=") {
			       
			        	$match = !is_home();
			       
			        }
	      		}

	      	}
	        
        }
        elseif( $rule['value'] == 'category_page') {

	        if( defined( 'DOING_AJAX') ) {
		        if($rule['operator'] == "==") {

			        $match = $this->is_category;

		        } elseif($rule['operator'] == "!=") {

			        $match = !$this->is_category;

		        }
	        } else {
		        if ( $rule['operator'] == "==" ) {

			        $match = is_category();

		        } elseif ( $rule['operator'] == "!=" ) {

			        $match = ! is_category();

		        }
	        }
        }
        elseif( $rule['value'] == 'archive_page') {
	        if( defined( 'DOING_AJAX') ) {
		        if($rule['operator'] == "==") {

			        $match = $this->is_archive;

		        } elseif($rule['operator'] == "!=") {

			        $match = !$this->is_archive;

		        }
	        } else {
		        if ( $rule['operator'] == "==" ) {

			        $match = is_archive();

		        } elseif ( $rule['operator'] == "!=" ) {

			        $match = ! is_archive();

		        }
	        }
        }
        elseif( $rule['value'] == 'search_page') {
	        if( defined( 'DOING_AJAX') ) {
		        if($rule['operator'] == "==") {

			        $match = $this->is_search;

		        } elseif($rule['operator'] == "!=") {

			        $match = !$this->is_search;

		        }
	        } else {
		        if ( $rule['operator'] == "==" ) {

			        $match = is_search();

		        } elseif ( $rule['operator'] == "!=" ) {

			        $match = ! is_search();

		        }
	        }
        }
        elseif( $rule['value'] == 'posts_page') {
        
	        $posts_page = (int) get_option('page_for_posts');

	        if( $posts_page !== 0 ) {
		        if($rule['operator'] == "==") {
		        	
		        	$match = ( $posts_page == $post_id );
		       
		        } elseif($rule['operator'] == "!=") {
		        
		        	$match = ( $posts_page != $post_id );
		       
		        }
	    	} else {	      		
	      		// if doing ajax is_home won't work so we do a workaround
	      		if( defined( 'DOING_AJAX') ) {
	      		    	
		      		
		      		if($rule['operator'] == "==") {
			       
			        	$match = ( 0 === $posts_page && $post_id == 0 );
			       
			        } elseif($rule['operator'] == "!=") {
			       
			        	$match = !( 0 === $posts_page && $post_id == 0 );
			       
			        }
	      			

	      		} else {
		      		if($rule['operator'] == "==") {
			       
			        	$match = is_home();
			       
			        } elseif($rule['operator'] == "!=") {
			       
			        	$match = !is_home();
			       
			        }
				}		   		
	    	}
	        
        }
        elseif( $rule['value'] == 'top_level') {
        	
        	
        	if( $options['page_parent'] )
        	{
	        	$post_parent = $options['page_parent'];
        	}
        	
        	
	        if($rule['operator'] == "==")
	        {
	        	$match = ( $post_parent == 0 );
	        }
	        elseif($rule['operator'] == "!=")
	        {
	        	$match = ( $post_parent != 0 );
	        }
	        
        }
        elseif( $rule['value'] == 'parent') {
        
        	$children = get_pages(array(
        		'post_type' => $post_type,
        		'child_of' =>  $post_id,
        	));
        	
	        
	        if($rule['operator'] == "==") {
	        	$match = ( count($children) > 0 );
	        }
	        elseif($rule['operator'] == "!=")
	        {
	        	$match = ( count($children) == 0 );
	        }
	        
        }
        elseif( $rule['value'] == 'child') {
        
        	$post_parent = $post_parent;
        	if( $options['page_parent'] )
        	{
	        	$post_parent = $options['page_parent'];
        	}
	        
	        
	        if($rule['operator'] == "==")
	        {
	        	$match = ( $post_parent != 0 );
	        }
	        elseif($rule['operator'] == "!=")
	        {
	        	$match = ( $post_parent == 0 );
	        }
	        
        } elseif( $rule['value'] == 'all_pages') {
        	
	        	$match = true;
	 
        }
        
        return $match;

	}
	
	
	/*
	*  rule_match_page_parent
	*
	* @since 1.0.0
	*/
	
	function rule_match_page_parent( $match, $rule )
	{
		
		// validation
		if( !$this->post_id )
		{
			return false;
		}
		
		
		// vars
		$post = get_post( $this->post_id );
		
		$post_parent = $post->post_parent;
    	if( $options['page_parent'] )
    	{
        	$post_parent = $options['page_parent'];
    	}
        
        
        if($rule['operator'] == "==")
        {
        	$match = ( $post_parent == $rule['value'] );
        }
        elseif($rule['operator'] == "!=")
        {
        	$match = ( $post_parent != $rule['value'] );
        }
        
        
        return $match;

	}
	
	
	/*
	*  rule_match_page_template
	*
	* @since 1.0.0
	*/
	
	function rule_match_page_template( $match, $rule )
	{
		

		$page_template = get_post_meta( $this->post_id, '_wp_page_template', true );

		
		if( ! $page_template ) {
			
			if( 'page' == get_post_type( $this->post_id ) ) {

				$page_template = "default";

			}
		}
			
		
        if($rule['operator'] == "==")
        {
        	$match = ( $page_template === $rule['value'] );
        }
        elseif($rule['operator'] == "!=")
        {
        	$match = ( $page_template !== $rule['value'] );
        }
                
        return $match;

	}
	
	
	/*
	*  rule_match_post_category
	*
	* @since 1.0.0
	*/
	
	function rule_match_post_category( $match, $rule )
	{
		

		// validate
		if( !$this->post_id )
		{
			return false;
		}

		
		// post type
		$post_type = $this->get_post_type();
		
		// vars
		$taxonomies = get_object_taxonomies( $post_type );

		$all_terms = get_the_terms( $this->post_id, 'category' );
		if($all_terms)
		{
			foreach($all_terms as $all_term)
			{
				$terms[] = $all_term->term_id;
			}
		}

		// no terms at all? 
		if( empty($terms) )
		{
			// If no ters, this is a new post and should be treated as if it has the "Uncategorized" (1) category ticked
			if( is_array($taxonomies) && in_array('category', $taxonomies) )
			{
				$terms[] = '1';
			}
		}
		

        if($rule['operator'] == "==")
        {
        	$match = false;
        	
        	if(!empty($terms))
			{
				if( in_array($rule['value'], $terms) )
				{
					$match = true; 
				}
			}
  
        }
        elseif($rule['operator'] == "!=")
        {
        	$match = true;
        	
        	if($terms)
			{
				if( in_array($rule['value'], $terms) )
				{
					$match = false; 
				}
			}

        }
    
        
        return $match;
        
    }
    
    
    /*
	*  rule_match_user_type
	*
	* @since 1.0.0
	*/
	
	function rule_match_user_type( $match, $rule )
	{
		$user = wp_get_current_user();
 
        if( $rule['operator'] == "==" )
		{
			if( $rule['value'] == 'super_admin' )
			{
				$match = is_super_admin( $user->ID );
			}
			else 
			{
				$match = in_array( $rule['value'], $user->roles );
			}
			
		}
		elseif( $rule['operator'] == "!=" )
		{
			if( $rule['value'] == 'super_admin' )
			{
				$match = !is_super_admin( $user->ID );
			}
			else 
			{
				$match = ( ! in_array( $rule['value'], $user->roles ) );
			}
		}
        
        return $match;
        
    }
    
    
    
    
    /*
	*  rule_match_post_format
	*
	* @since 1.0.0
	*/
	
	function rule_match_post_format( $match, $rule )
	{
		
		
		// validate
		if( !$this->post_id )
		{
			return false;
		}
			
		$post_type = $this->get_post_type();
			
	
		// does post_type support 'post-format'
		if( post_type_supports( $post_type, 'post-formats' ) )
		{
			$post_format = get_post_format( $this->post_id );
			
			if( $post_format === false )
			{
				$post_format = 'standard';
			}
		}
		

       	
       	if($rule['operator'] == "==")
        {
        	$match = ( $post_format === $rule['value'] );
        	 
        }
        elseif($rule['operator'] == "!=")
        {
        	$match = ( $post_format !== $rule['value'] );
        }
        
        
        
        return $match;
        
    }
    
    
    /*
	*  rule_match_post_status
	*
	* @since 1.0.0
	*/
	
	function rule_match_post_status( $match, $rule )
	{
		

		// validate
		if( !$this->post_id )
		{
			return false;
		}
		
					
		// vars
		$post_status = get_post_status( $this->post_id );
	    
	    
	    // auto-draft = draft
	    if( $post_status == 'auto-draft' )
	    {
		    $post_status = 'draft';
	    }
	    
	    
	    // match
	    if($rule['operator'] == "==")
        {
        	$match = ( $post_status === $rule['value'] );
        	 
        }
        elseif($rule['operator'] == "!=")
        {
        	$match = ( $post_status !== $rule['value'] );
        }
        
        
        // return
	    return $match;
        
    }
    
    
    /*
	*  rule_match_taxonomy
	*
	* @since 1.0.0
	*/
	
	function rule_match_taxonomy( $match, $rule )
	{
		
		// validate
		if( !$this->post_id )
		{
			return false;
		}
		
		
		// post type
		$post_type = $this->get_post_type();
		
		// vars
		$taxonomies = get_object_taxonomies( $post_type );
		
    	if( is_array($taxonomies) )
    	{
        	foreach( $taxonomies as $tax )
			{
				$all_terms = get_the_terms( $this->post_id, $tax );
				if($all_terms)
				{
					foreach($all_terms as $all_term)
					{
						$terms[] = $all_term->term_id;
					}
				}
			}
		}
				
		// no terms at all? 
		if( empty($terms) )
		{
			// If no ters, this is a new post and should be treated as if it has the "Uncategorized" (1) category ticked
			if( is_array($taxonomies) && in_array('category', $taxonomies) )
			{
				$terms[] = '1';
			}
		}
		

        
        if($rule['operator'] == "==")
        {
        	$match = false;
        	
        	if($terms)
			{
				if( in_array($rule['value'], $terms) )
				{
					$match = true; 
				}
			}
  
        }
        elseif($rule['operator'] == "!=")
        {
        	$match = true;
        	
        	if($terms)
			{
				if( in_array($rule['value'], $terms) )
				{
					$match = false; 
				}
			}

        }
    
        
        return $match;
        
    }
    
 	/**
 	 * Helper function to get post type
 	 * @since 1.2.3
 	 * @return  string
 	 * 
 	 */
 	function get_post_type(){
 		global $wp_query;

		$post_type = isset( $wp_query->query_vars['post_type'] ) ? $wp_query->query_vars['post_type'] : '';

		$post_type = empty( $post_type ) ? get_post_type($this->post_id) : ''; 
	
		return $post_type;
 	}
			
}

?>