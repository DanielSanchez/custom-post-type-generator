<?php

global $wpdb;

$sql = "SELECT
		option_id, 
		option_name,
		option_value
	FROM 
		$wpdb->options 
	WHERE 
		option_name LIKE '%%cptg_tax%%'
	ORDER BY 
		option_id ASC
	";
		 
$results = $wpdb->get_results($sql);

?>

<div class="wrap">

<?php screen_icon( 'plugins' ); ?>

<h2>
	<?php _e('Custom Taxonomies', 'cptg'); ?>
	<a href="<?php echo admin_url('admin.php?page=regist_tax'); ?>" class="add-new-h2"><?php _e('Add New', 'cptg'); ?></a>
</h2>

<?php if ( isset($_GET['msg'] )) : ?>
<div id="message" class="updated below-h2">
	<?php if ( $_GET['msg'] == 'add') : ?>
		<p><?php _e('Custom Taxonomy is new added.', 'cptg'); ?></p>
	<?php elseif ( $_GET['msg'] == 'edit') : ?>
		<p><?php _e('Custom Taxonomy id edited.', 'cptg'); ?></p>
	<?php elseif ( $_GET['msg'] == 'del') : ?>
		<p><?php _e('Custom Taxonomy id deleted.', 'cptg'); ?></p>
	<?php endif; ?>
</div>
<?php endif; ?>

<p><?php _e('If you delete Custom Taxonomy, Contents will not delete which belong to that.', 'cptg') ?></p>

<table width="100%" class="widefat">
	<thead>
		<tr>
			<th><?php _e('Taxonomy', 'cptg');?></th>
			<th><?php _e('Label', 'cptg');?></th>
			<th><?php _e('Attached Post Types', 'cptg');?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th><?php _e('Taxonomy', 'cptg');?></th>
			<th><?php _e('Label', 'cptg');?></th>
			<th><?php _e('Attached Post Types', 'cptg');?></th>
		</tr>
	</tfoot>
	
	<tbody>
	<?php if ( is_array( $results ) ) : ?>
	
	<?php foreach ( $results as $result ) : ?>
	
		<?php
			$tax = unserialize( $result->option_value );
			
			$del_url = admin_url( 'admin.php?page=manage_tax' ) . '&action=del_tax&key=' .$result->option_name;
			$del_url = ( function_exists('wp_nonce_url') ) ? wp_nonce_url($del_url, 'nonce_del_tax') : $del_url;
		
			$edit_url = admin_url( 'admin.php?page=regist_tax' ) . '&action=edit_tax&key=' .$result->option_name;
			$edit_url = ( function_exists('wp_nonce_url') ) ? wp_nonce_url($edit_url, 'nonce_regist_tax') : $edit_url;
		?>
		<tr>
			<td valign="top">
				<strong><a class="row-title" href="<?php echo $edit_url; ?>" title="<?php _e('Edit this item'); ?>"><?php echo stripslashes($tax["taxonomy"]); ?></a></strong>
				<div class="row-actions">
					<span class="edit"><a href="<?php echo $edit_url; ?>" title="<?php _e('Edit this item'); ?>"><?php _e('Edit', 'cptg'); ?></a> | </span>
					<span class="trash"><a href="<?php echo $del_url; ?>" title="<?php _e('Move this item to the Trash'); ?>"><?php _e('Delete', 'cptg'); ?></a></span>
				</div>
			</td>
			<td valign="top"><?php echo stripslashes($tax["label"]); ?></td>
			<td valign="top">
			<?php
			if ( isset( $tax["cpt_name"] ) ) {
				echo stripslashes($tax["cpt_name"]);
			} elseif ( is_array( $tax["post_types"] ) ) {
				foreach ($tax["post_types"] as $post_type) {
					echo $post_type .'<br />';
				}
			}
			?>
			</td>
		</tr>
		
	<?php endforeach; ?>
	</tbody>
	
</table>
		
	<?php endif; ?>

</div>