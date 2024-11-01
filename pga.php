<?php
/*
Plugin Name: Fun games
Plugin URI: http://mclear.co.uk
Description: Displays the top 5 curriculum game from Primary Games Arena in an iframe
Author: John McLear
Version: 0.1
Author URI: http://mclear.co.uk

	My Widget is released under the GNU General Public License (GPL)
	http://www.gnu.org/licenses/gpl.txt

	This is a WordPress plugin (http://wordpress.org) and widget
	(http://automattic.com/code/widgets/).
*/

// We're putting the plugin's functions in one big function we then
// call at 'plugins_loaded' (add_action() at bottom) to ensure the
// required Sidebar Widget functions are available.
function widget_gamewidget_init() {

	// Check to see required Widget API functions are defined...
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return; // ...and if not, exit gracefully from the script.

	// This function prints the sidebar widget--the cool stuff!
	function widget_gamewidget($args) {

		// $args is an array of strings which help your widget
		// conform to the active theme: before_widget, before_title,
		// after_widget, and after_title are the array keys.
		extract($args);

		// Collect our widget's options, or define their defaults.
		$options = get_option('widget_gamewidget');
		$title = empty($options['title']) ? 'Fun games' : $options['title'];
		$color = empty($options['text']) ? '#ffffff' : $options['text'];
		//$color = $options['text'];

		$text = '<div><center><iframe frameborder=0 src="http://primarygamesarena.com/top5.php?font=black&bg=' . $color . '" 
		width="100%" height="545"></iframe></center></div>';
 		// It's important to use the $before_widget, $before_title,
 		// $after_title and $after_widget variables in your output.
		echo $before_widget;
		echo $before_title . $title . $after_title;
		echo $text;
		echo $after_widget;
	}

	// This is the function that outputs the form to let users edit
	// the widget's title and so on. It's an optional feature, but
	// we'll use it because we can!
	function widget_gamewidget_control() {

		// Collect our widget's options.
		$options = get_option('widget_gamewidget');

		// This is for handing the control form submission.
		if ( $_POST['gamewidget-submit'] ) {
			// Clean up control form submission options
			$newoptions['title'] = strip_tags(stripslashes($_POST['gamewidget-title']));
			$newoptions['text'] = strip_tags(stripslashes($_POST['gamewidget-text']));
		}

		// If original widget options do not match control form
		// submission options, update them.
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_gamewidget', $options);
		}

		// Format options as valid HTML. Hey, why not.
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$text = htmlspecialchars($options['text'], ENT_QUOTES);

// The HTML below is the control form for editing options.
?>
		<div>
		<label for="gamewidget-title" style="line-height:35px;display:block;">Widget title: <input type="text" id="gamewidget-title" name="gamewidget-title" value="<?php echo $title; ?>" /></label>
		<label for="gamewidget-text" style="line-height:35px;display:block;">Background colour: <input type="text" id="gamewidget-text" 
		name="gamewidget-text" value="<?php echo $text; ?>" /></label>
		<input type="hidden" name="gamewidget-submit" id="gamewidget-submit" value="1" />
		</div>
	<?php
	// end of widget_gamewidget_control()
	}

	// This registers the widget. About time.
	register_sidebar_widget('Fun games', 'widget_gamewidget');

	// This registers the (optional!) widget control form.
	register_widget_control('Fun games', 'widget_gamewidget_control');
}

// Delays plugin execution until Dynamic Sidebar has loaded first.
add_action('plugins_loaded', 'widget_gamewidget_init');
?>
