<?php

$zass_search_params = array(
	'placeholder'  	=> esc_attr__('Search','zass'),
	'search_id'	   	=> 's',
	'form_action'	=> zass_wpml_get_home_url(),
	'ajax_disable'	=> false
);

?>

<form action="<?php echo esc_url($zass_search_params['form_action']); ?>" id="searchform" method="get">
	<div>
		<input type="submit" id="searchsubmit"  value="<?php esc_attr_e('Search', 'zass') ?>"/>
		<input type="text" id="s" name="<?php echo esc_attr($zass_search_params['search_id']); ?>" value="<?php if(!empty($zass__GET['s'])) echo esc_attr(get_search_query()); ?>" placeholder='<?php echo esc_attr($zass_search_params['placeholder']); ?>' />
	</div>
</form>