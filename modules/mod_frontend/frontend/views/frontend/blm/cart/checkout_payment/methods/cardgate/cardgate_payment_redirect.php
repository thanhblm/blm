<?php
use core\Lang;
use core\utils\SessionUtil;
$url = SessionUtil::get ( 'payment_redirect_url' );

if (! empty ( $url )) {
	?>
<script>
var url = '<?php echo $url; ?>';
window.location.href = url;
</script>
<?php
	echo '<h3>' . Lang::get ( 'Redirecting to payment gateway... Please do not refresh page.' ) . '</h3>';
} else {
	echo '<h3>' . Lang::get ( 'Payment gateway error, please try again later or contact our customer support.' ) . '</h3>';
}

?>