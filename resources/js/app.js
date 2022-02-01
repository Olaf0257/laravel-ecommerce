/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });








/*******************************
 * custom Javascript
 */
(function() {
	let main = document.querySelector('.main');
	let html = document.querySelector('html');
	let footer = document.querySelector('footer');
	let diabledButton = document.querySelector('.can-be-disabled');
	let closeContact = document.querySelector('#close-contact');
	let contactContainer = document.querySelector('.contact-container');
	let navContact = document.querySelectorAll('.nav-contact');
	let navbarToggler = document.querySelector('.navbar-toggler-container');
	let navbarItems = document.querySelector('.small-devices-navbar-items');

	// Stick footer element to the bottom
	if (main) {
		if (main.offsetHeight + footer.offsetHeight < window.innerHeight) {
			html.style.height = "100%";
			main.style.marginBottom = '-' + footer.offsetHeight + 'px';
			main.style.height = "100%";
		}
	}


    // Make checkout submit button disabled after submitting the form
	if (diabledButton) {
	    diabledButton.addEventListener('click', (e) => {
	        diabledButton.disabled = true;
	    });
	}


	// Toggle contact page
	if (navContact) {
		navContact.forEach(el => {
				el.addEventListener('click', () => {
				contactContainer.style.display = 'block';
			});
		});

		closeContact.addEventListener('click', () => {
			contactContainer.style.display = 'none';
		});
	}


	// Toggle checkbox
	document.querySelectorAll('.checkbox').forEach(el => {
		el.addEventListener('click', (e) => {
		  	if (e.target.classList.contains('checkbox')) {
			  	e.target.classList.toggle('checked');
				e.target.querySelector('.check-mark').classList.toggle('show');
			} else if (e.target.classList.contains('check-mark')) {
			  	e.target.parentElement.click();
			}
		});
	});


	// Toggle navbar items in small devices
	navbarToggler.addEventListener('click', (e) => {
		e.target.classList.toggle('close');
		navbarItems.classList.toggle('toggle-down');
	});
}());