<style>
.tutsup-modal-bg {
	width: 100%;
	height: 100%;
	position: fixed;
	top: 0;
	left: 0;
	background: rgba(0,0,0,.6);
	z-index: 999;
	display: none;
}
.tutsup-modal {
	width: <?php 
		$width = (int) tutsup_check_option( $tutsup_style, 'width' );
		if ( ! empty( $width ) ) {
			echo $width;
		} else {
			echo 500;
		}		
	?>px;
	height: <?php 
		$height = (int) tutsup_check_option( $tutsup_style, 'height' );
		if ( ! empty( $height ) ) {
			echo $height;
		} else {
			echo 300;
		}		
	?>px;
	position: fixed;
	top: 50%;
	left: 50%;
	margin-top: -150px;
	margin-left: -250px;
	background: #fff;
	z-index: 1000;
	box-shadow: 0 0 10px #000;
	display: none;
}
.tutsup-modal-inner{
	position: relative;
}
.tutsup-modal-content{
	margin: 20px;
	overflow: auto;
	height: 260px;
}
.tutsup-modal-close {
	display: block;
	font-size: 12px;
	line-height: 12px;
	padding: 5px;
	border-radius: 50%;
	background: #000;
	color: #fff;
	text-align: center;
	position: absolute;
	top: -30px;
	right: -13px;
	font-weight: 700;
	font-family: sans-serif;
	z-index: 1001;
	cursor: pointer;
}
<?php echo tutsup_check_option( $tutsup_option, 'tutsup-modal-css' );?>
</style>

<div class="tutsup-modal-bg"></div>
<div class="tutsup-modal">
	<div class="tutsup-modal-inner">
		<div class="tutsup-modal-close">&#10005;</div>
		<div class="tutsup-modal-content">
			<?php echo tutsup_check_option( $tutsup_option, 'tutsup-modal-html' );?>
		</div>
	</div>
</div>

<script>
function tutsup_modal_init($) {
	var tutsup_modal_cookies = document.cookie;
	
	$('.tutsup-modal').css({
		'margin-top'  : '-' + ( $('.tutsup-modal').height() / 2 ) + 'px',
		'margin-left' : '-' + ( $('.tutsup-modal').width() / 2 ) + 'px'
	});
	
	if ( tutsup_modal_cookies.indexOf( 'tutsup-modal' ) == -1 ) {
		$('.tutsup-modal-bg').css('display', 'block');
		$('.tutsup-modal').css('display', 'block');
		document.cookie = 'tutsup-modal=1';
	}
}

jQuery(function($){
	$('.tutsup-modal-close').click(function(){
		$('.tutsup-modal-bg').css('display', 'none');
		$('.tutsup-modal').css('display', 'none');
		document.cookie = 'tutsup-modal=1';
	});

	<?php 
	$modal_seconds = tutsup_check_option( $tutsup_option, 'tutsup-modal-seconds' );
	
	if ( empty( $modal_seconds ) ): 
	?>
		$('body').mouseleave(function() {
			tutsup_modal_init($);
		});
	<?php else: ?>
		setTimeout(function(){
			tutsup_modal_init($);
		}, <?php echo ( (int)tutsup_check_option( $tutsup_option, 'tutsup-modal-seconds' ) ) * 1000; ?>);
	<?php endif; ?>
});
</script>

