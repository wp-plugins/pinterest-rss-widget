<?php
/*
Plugin Name: Pinterest RSS Widget
Plugin URI: http://wordpress.org/extend/plugins/pinterest-rss-widget/
Description: Display up to 90 of your latest Pinterest Pins in your sidebar.
Author: bkmacdaddy designs
Version: 1.2
Author URI: http://bkmacdaddy.com/

/* License

    Pinterest RSS Widget
    Copyright (C) 2012 Brian McDaniel (brian at bkmacdaddy dot com)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
    
*/

add_action('wp_enqueue_scripts', 'add_pinterest_rss_css');

function add_pinterest_rss_css() {
	$pinterest_rss_myStyleUrl = plugins_url('style.css', __FILE__); // Respects SSL, Style.css is relative to the current file
	$pinterest_rss_myStyleFile = WP_PLUGIN_DIR . '/pinterest-rss-widget/style.css';
	if ( file_exists($pinterest_rss_myStyleFile) ) {
		wp_register_style('pinterestRSScss', $pinterest_rss_myStyleUrl);
		wp_enqueue_style( 'pinterestRSScss');
	}
}

function get_pins_feed_list($username, $maxfeeds=90, $divname='standard', $printtext=NULL, $target='samewindow', $useenclosures='yes', $thumbwidth='150', $thumbheight='150', $showfollow='yes') {

                // This is the main function of the plugin. It is used by the widget and can also be called from anywhere in your theme. See the readme file for example.

		// Get Pinterest Feed(s)
		include_once(ABSPATH . WPINC . '/feed.php');

                // Get a SimplePie feed object from the Pinterest feed source
				$pinsfeed = 'http://pinterest.com/'.$username.'/feed.rss';
                $rss = fetch_feed($pinsfeed);

                // Figure out how many total items there are. 
                $maxitems = $rss->get_item_quantity((int)$maxfeeds);

                // Build an array of all the items, starting with element 0 (first element).
                $rss_items = $rss->get_items(0,$maxitems);

                ?>
				
                <ul class="pins-feed-list"><?php
		// Loop through each feed item and display each item as a hyperlink.
		  foreach ( $rss_items as $item ) : ?>
		    <li class="pins-feed-item" style="width:<?php echo $thumbwidth; ?>px;">
				<div class="pins-feed-<?php echo $divname; ?>">
					<a href="<?php echo $item->get_permalink(); ?>"
					<?php if ($target == 'newwindow') { echo 'target="_BLANK" '; }; ?>
		            title="<?php echo $item->get_title().' - Pinned on '.$item->get_date('M d, Y'); ?>">
						
						<?php if ($thumb = $item->get_item_tags(SIMPLEPIE_NAMESPACE_MEDIARSS, 'thumbnail') ) {
                                $thumb = $thumb[0]['attribs']['']['url'];
	                        	echo '<img src="'.get_bloginfo('url').'/wp-content/plugins/pinterest-rss-widget/timthumb.php?src='.$thumb.'&a=t&w='.$thumbwidth.'&h='.$thumbheight.'"'; 
                                echo ' alt="'.$item->get_title().'"/>';
                             } else if ( $useenclosures == 'yes' && $enclosure = $item->get_enclosure() ) {
                                $enclosure = $item->get_enclosures();
								echo '<img src="'.get_bloginfo('url').'/wp-content/plugins/pinterest-rss-widget/timthumb.php?src='.$enclosure[0]->get_link().'&a=t&w='.$thumbwidth.'&h='.$thumbheight.'"'; 
                                echo ' alt="'.$item->get_title().'"/>';
                            }  else {
								preg_match('/src="([^"]*)"/', $item->get_content(), $matches);
								$src = $matches[1];
								
                                if ($matches) {
                                  echo '<img src="'.get_bloginfo('url').'/wp-content/plugins/pinterest-rss-widget/timthumb.php?src='.$src.'&a=t&w='.$thumbwidth.'&h='.$thumbheight.'"'; 
                                echo ' alt="'.$item->get_title().'"/>';
                                } else {
                                  echo "thumbnail not available";
                                }
                            } 
                            if ($printtext) {
                              if ($printtext != 'no') {
                                echo "<div class='imgtitle'>".$item->get_title()."</div>";
                              }
                            }?>
                          </a>
                      </div>
		    </li>
		  <?php endforeach; ?>
          <div class="pinsClear"></div>
		</ul>
        <?php 
			$pinterest_followButton = get_bloginfo('url') . '/wp-content/plugins/pinterest-rss-widget/follow-on-pinterest-button.png';
			if ($showfollow == 'yes') { ?>
            <a href="http://pinterest.com/<?php echo $username; ?>/" id="pins-feed-follow" target="_blank">
                <img src="http://passets-cdn.pinterest.com/images/follow-on-pinterest-button.png" width="156" height="26" alt="Follow Me on Pinterest" border="0" />
            </a>
		<?php } ?>
                <?php
}

class Pinterest_RSS_Widget extends WP_Widget {
  function Pinterest_RSS_Widget() {
    $widget_ops = array('classname' => 'pinterest_rss_widget', 'description' => 'A widget to display latest Pinterest Pins via RSS feed' );
    $this->WP_Widget('pinterest_rss_widget', 'Pinterest_RSS_Widget', $widget_ops);
  }

  function widget($args, $instance) {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;

    $title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
    $user_name = empty($instance['user_name']) ? '&nbsp;' : $instance['user_name'];
    $maxnumber = empty($instance['maxnumber']) ? '&nbsp;' : $instance['maxnumber'];
    $thumb_height = empty($instance['thumb_height']) ? '&nbsp;' : $instance['thumb_height'];
    $thumb_width = empty($instance['thumb_width']) ? '&nbsp;' : $instance['thumb_width'];
    $target = empty($instance['target']) ? '&nbsp;' : $instance['target'];
    $displaytitle = empty($instance['displaytitle']) ? '&nbsp' : $instance['displaytitle'];
    $useenclosures = empty($instance['useenclosures']) ? '&nbsp;' : $instance['useenclosures'];
    $showfollow = empty($instance['showfollow']) ? '&nbsp;' : $instance['showfollow'];
 
    if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };

    if ( empty( $target ) ) { $target = 'samewindow'; };

    if ( empty( $displaytitle ) ) { $displaytitle = 'no'; };

    if ( empty( $useenclosures ) ) { $useenclosures = 'yes'; };

    if ( empty( $showfollow ) ) { $showfollow = 'yes'; };

    if ( !empty( $user_name ) ) {

      get_pins_feed_list($user_name, $maxnumber, 'small', $displaytitle, $target, $useenclosures, $thumb_width, $thumb_width, $showfollow); ?>

                <div style="clear:both;"></div>

                <?php }

    echo $after_widget;
  }
 
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['user_name'] = strip_tags($new_instance['user_name']);
    $instance['maxnumber'] = strip_tags($new_instance['maxnumber']);
    $instance['thumb_height'] = strip_tags($new_instance['thumb_height']);
    $instance['thumb_width'] = strip_tags($new_instance['thumb_width']);
    $instance['target'] = strip_tags($new_instance['target']);
    $instance['displaytitle'] = strip_tags($new_instance['displaytitle']);
    $instance['useenclosures'] = strip_tags($new_instance['useenclosures']);
    $instance['showfollow'] = strip_tags($new_instance['showfollow']);
 
    return $instance;
  }
 
  function form($instance) {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'user_name' => '', 'maxnumber' => '', 'thumb_height' => '', 'thumb_width' => '', 'target' => '', 'displaytitle' => '', 'useenclosures' => '', 'showfollow' => '') );
    $title = strip_tags($instance['title']);
    $user_name = strip_tags($instance['user_name']);
    $maxnumber = strip_tags($instance['maxnumber']);
    $thumb_height = strip_tags($instance['thumb_height']);
    $thumb_width = strip_tags($instance['thumb_width']);
    $target = strip_tags($instance['target']);
    $displaytitle = strip_tags($instance['displaytitle']);
    $useenclosures = strip_tags($instance['useenclosures']);
    $showfollow = strip_tags($instance['showfollow']);
?>
      <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
								    
      <p><label for="<?php echo $this->get_field_id('user_name__title'); ?>">Pinterest Username: <input class="widefat" id="<?php echo $this->get_field_id('user_name'); ?>" name="<?php echo $this->get_field_name('user_name'); ?>" type="text" value="<?php echo attribute_escape($user_name); ?>" /></label></p>
		     
      <p><label for="<?php echo $this->get_field_id('maxnumber'); ?>">Max number of pins to display: <input class="widefat" id="<?php echo $this->get_field_id('maxnumber'); ?>" name="<?php echo $this->get_field_name('maxnumber'); ?>" type="text" value="<?php echo attribute_escape($maxnumber); ?>" /></label></p>
      
      <p><label for="<?php echo $this->get_field_id('thumb_height'); ?>">Thumbnail Height (defaults to 150px): <input class="widefat" id="<?php echo $this->get_field_id('thumb_height'); ?>" name="<?php echo $this->get_field_name('thumb_height'); ?>" type="text" value="<?php echo attribute_escape($thumb_height); ?>" /></label></p>
      
      <p><label for="<?php echo $this->get_field_id('thumb_width'); ?>">Thumbnail Width (defaults to 150px): <input class="widefat" id="<?php echo $this->get_field_id('thumb_width'); ?>" name="<?php echo $this->get_field_name('thumb_width'); ?>" type="text" value="<?php echo attribute_escape($thumb_width); ?>" /></label></p>

      <p><label for="<?php echo $this->get_field_id('target'); ?>">Where to open the links: <select id="<?php echo $this->get_field_id('target'); ?>" name="<?php echo $this->get_field_name('target'); ?>">
        <?php 
  	  echo '<option ';
          if ( $instance['target'] == 'samewindow' ) { echo 'selected '; }
          echo 'value="samewindow">';
	  echo 'Same Window</option>';
  	  echo '<option ';
          if ( $instance['target'] == 'newwindow' ) { echo 'selected '; }
          echo 'value="newwindow">';
	  echo 'New Window</option>'; ?>
      </select></label></p>

      <p><label for="<?php echo $this->get_field_id('displaytitle'); ?>">Display title below pins? <select id="<?php echo $this->get_field_id('displaytitle'); ?>" name="<?php echo $this->get_field_name('displaytitle'); ?>">
        <?php 
  	  echo '<option ';
          if ( $instance['displaytitle'] == 'yes' ) { echo 'selected '; }
          echo 'value="yes">';
	  echo 'Yes</option>';
  	  echo '<option ';
          if ( $instance['displaytitle'] == 'no' ) { echo 'selected '; }
          echo 'value="no">';
	  echo 'No</option>'; ?>
      </select></label></p>
      
      <p><label for="<?php echo $this->get_field_id('showfollow'); ?>">Show "Follow Me On Pinterest" button <select id="<?php echo $this->get_field_id('showfollow'); ?>" name="<?php echo $this->get_field_name('showfollow'); ?>">
        <?php 
  	  echo '<option ';
          if ( $instance['showfollow'] == 'yes' ) { echo 'selected '; }
          echo 'value="yes">';
	  echo 'Yes</option>';
  	  echo '<option ';
          if ( $instance['showfollow'] == 'no' ) { echo 'selected '; }
          echo 'value="no">';
	  echo 'No</option>'; ?>
      </select></label></p>

      <p><label for="<?php echo $this->get_field_id('useenclosures'); ?>">Use RSS enclosures? (leave yes if unsure) <select id="<?php echo $this->get_field_id('useenclosures'); ?>" name="<?php echo $this->get_field_name('useenclosures'); ?>">
        <?php 
  	  echo '<option ';
          if ( $instance['useenclosures'] == 'yes' ) { echo 'selected '; }
          echo 'value="yes">';
	  echo 'Yes</option>';
  	  echo '<option ';
          if ( $instance['useenclosures'] == 'no' ) { echo 'selected '; }
          echo 'value="no">';
	  echo 'No</option>'; ?>
      </select></label></p>

<?php
																			}
}

// register_widget('Pinterest_RSS_Widget');
add_action( 'widgets_init', create_function('', 'return register_widget("Pinterest_RSS_Widget");') );

?>