<?php
/**
 * The template for displaying the footer
 *
 * @package WordPress
 * @subpackage Voisen_theme
 * @since Voisen Themes 1.0
 */
?>
<?php $voisen_opt = get_option( 'voisen_opt' ); ?>
		
		</div><!--.site-content-->
		<footer id="site-footer">
			<?php
			if(isset($voisen_temp['footer']) && $voisen_temp['footer']){
				get_footer($voisen_temp['footer']);
			}else{
				if ( !isset($voisen_opt['footer_layout']) || $voisen_opt['footer_layout']=='default' ) {
					get_footer('first');
				} else {
					get_footer($voisen_opt['footer_layout']);
				}
			}
			?>
		</footer>
		<?php if ( isset($voisen_opt['back_to_top']) && $voisen_opt['back_to_top'] ) { ?>
		<div id="back-top" class="hidden-xs"><i class="fa fa-angle-up"></i></div>
		<?php } ?>
	</div><!--.main wrapper-->
	<?php wp_footer(); ?>
</body>
</html>