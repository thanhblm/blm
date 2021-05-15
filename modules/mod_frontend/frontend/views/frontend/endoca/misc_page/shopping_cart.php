<main id="main">
<div class="light">
	<div>
		<article class="box _1of1">
			<h1>Cart</h1>
			<div class="checkout-step">
				<a href="/en/shopping-cart" class="active">1. Cart</a><a href="/en/checkout">2. Shipping</a><span>3. Payment</span><span>4. Complete</span>
			</div>
			<div class="shopping-cart cart_block">
				<form name="cart" action="/en/shopping-cart?action=update" method="post" class="purlForm">
					<div class="cart-products-reload">
						<table>
							<tbody>
								<tr>
									<th></th>
									<th>Product</th>
									<th class="center">Price</th>
									<th style="width: 75px;" class="center">Amount</th>
									<th class="center">Sum</th>
									<th class="center">Subscription</th>
									<th class="center">Remove</th>
								</tr>
							</tbody>
						</table>
					</div>
				</form>
				<form name="coupon" action="/en/shopping-cart?action=coupon" method="post" class="purlForm">
					<div class="discount col-sm-4">
						<h4>Do you have a discount code? Enter it here.</h4>
						<span class="frm_field frm_text"><input type="text" name="coupon_code" value="" placeholder="Discount code..." required=""></span>
						<button type="submit">
							<span>Submit</span>
						</button>
						<div id="coupon_list_container">
							<table class="coupons2 cpb1"></table>
						</div>
					</div>
				</form>
				<div class="suma col-sm-6">
					<div id="order_price_summary">
						<span>Subtotal</span>
						<div class="price" id="cart_total_price">€0.00</div>
						<span>Grand Total</span>
						<div class="price sum" id="cart_total_price2">€0.00</div>
						<a href="/en/checkout" class="button continue"><span>Proceed to Checkout</span></a>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</article>
	</div>
</div>
</main>