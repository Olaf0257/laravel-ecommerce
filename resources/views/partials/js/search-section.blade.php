{{-- Related to meilisearch --}}
<script src="https://cdn.jsdelivr.net/npm/docs-searchbar.js/dist/cdn/docs-searchbar.min.js"></script>
<script>
  docsSearchBar({
    hostUrl: '{{ config('meilisearch.host') }}',
    apiKey: '{{ config('meilisearch.key') }}',
    indexUid: 'searchable_products',
    inputSelector: '#search-bar-input',
    debug: true // Set debug to true if you want to inspect the dropdown
  });
</script>

{{-- Custom js --}}
<script>
	var inputValue = '';
	var selectedEl = '';

	document.querySelector('#search-bar-input').addEventListener('keyup', (e) => {
		var suggestions = document.querySelectorAll('.dsb-suggestion');

		if (e.keyCode == 13 && selectedEl == null) {
			window.location = '/search?query=' + inputValue;
		} else {
			inputValue = e.target.value;
			selectedEl = Array.from(suggestions).find(el => el.hasAttribute('aria-selected'));
		}
	});

	// Hide results list
	document.addEventListener('click', e => {
		var meilisearchList = document.querySelector('#meilisearch-autocomplete-listbox-0');
		var isDisplayed = meilisearchList.style.display == 'block';

		if (e.target.id != 'meilisearch-autocomplete-listbox-0' && e.target.id != 'search-form' && e.target.id != 'search-bar-input' && isDisplayed) {
			meilisearchList.style.display = 'none';
		}
	});
</script>