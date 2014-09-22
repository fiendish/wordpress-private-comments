<?php 
/* Plugin Name: Private Comments
Plugin URI: https://www.github.com/fiendish/wordpress-private-comments
Description: Comments are only visible to the allowed group.
Author: Avi Kelman
Version: 1.0.0
Author URI: https://www.github.com/fiendish
*/ 
?>
<?php 

function plugin_private_allowed_group()
{
    return is_super_admin( get_current_user_id() );
}

function plugin_private_comments_filter($content) 
{ 
    if (plugin_private_allowed_group())   // user is admin
    {
        return $content;
    }
    else
    {
        return '';
    }
} 

function plugin_private_comments_array_filter($comments)
{
    if ( plugin_private_allowed_group() ) 
    {
        return $comments;
    }
    else
    {
        return array();
    }
}

function plugin_private_comments_number()
{
    if ( plugin_private_allowed_group() )
    {
        $num_comments = get_comments_number();
        if ($num_comments == 0)
        {
            return 'No Comments';
        }
        elseif ($num_comments == 1)
        {
            return '1 Comment';
        }
        else
        {
            return $num_comments . ' Comments';
        }
    }
    else 
    {
        return 'No Comments';
    }
}

add_filter('comment_text', 'plugin_private_comments_filter'); 
add_filter('comment_text_rss', 'plugin_private_comments_filter'); 
add_filter('comment_excerpt', 'plugin_private_comments_filter'); 
add_filter('comments_array', 'plugin_private_comments_array_filter');
add_filter('comments_open', 'plugin_private_allowed_group');
add_filter('comments_number', 'plugin_private_comments_number');

?>
