<div class="contact-container">
	<div class="contact-overlay">
		<i id="close-contact" class="fas fa-times"></i>

		<div class="contact-content">
			<div>
				<h2>GET IN TOUCH</h2>
				<h4>Let us know how we can help.</h4>
				<form action="{{ route('contact') }}" method="POST">
					@csrf
					<input type="text" name="name" placeholder="Full Name">
					<input type="email" name="email" placeholder="E-Mail">
					<textarea name="message" placeholder="Message"></textarea>
					<button type="submit" class="button button-black">SEND MESSAGE</button>
				</form> <!-- end form -->

				<div class="social-links">
			        {{ menu('footer', 'partials.menus.footer') }}
				</div>
			</div>
		</div>
	</div>
</div>