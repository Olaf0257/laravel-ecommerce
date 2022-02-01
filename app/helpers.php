<?php 

function getCategories()
{
	return App\Category::all();
}

function checkoutErrorHandler($errno, $errstr, $errfile, $errline)
{
	define('CHECKOUT_ERROR', [
		"error" => "Error #{$errno}: {$errstr}. \nFile: {$errfile} \nLine: {$errline}",
		"userMessage" => "Something went wrong. Please try again later."
	]);
}

function convertCurrency($amount, $from_currency = null, $to_currency = null) 
{
	$apikey = config('services.currency_converter.apikey');
	$fromCurrency = urlencode($from_currency ?? config('services.currency_converter.from_currency'));
	$toCurrency = urlencode($to_currency ?? config('services.currency_converter.to_currency'));

	$response = json_decode(file_get_contents("http://data.fixer.io/api/latest?symbols=${fromCurrency},${toCurrency}&access_key=${apikey}"));
	// EX: EUR TO EGP
	$EUR_TO_BASE = $response->rates->{$fromCurrency};
	// EX: EUR TO USD
	$EUR_TO_TARGET = $response->rates->{$toCurrency};
	$BASE_TO_TARGET = $EUR_TO_TARGET / $EUR_TO_BASE;
	$total = $amount * $BASE_TO_TARGET;
	
	return number_format($total, 2, '.', '');
}

function deleteCookie($name)
{
    setcookie($name, '', time()-3600, '/');
}

function presentPrice($price) 
{
	if (! is_string($price)) {
    	$price = number_format($price, 2, '.', ',');
    }

	return $price . ' EGP';
}

/**
* returns a collection of all numbers related to payment
*/
function getNumbers()
{
    $subtotal = doubleval(Cart::subtotal(2, '.', ''));
    $tax = round((config('cart.tax') / 100) * $subtotal, 2);
    $newSubtotal = $subtotal + $tax;
    $couponSession = session()->get('coupon');
    $discount = $couponSession['discount'] ?? 0;
    $discountCode = $couponSession['code'] ?? null;
    $discountType = $couponSession['type'] ?? null;
    $discountPercent = $couponSession['percent'] ?? null;
    $total = $newSubtotal > $discount ? $newSubtotal - $discount : 0;

    return collect([
        "subtotal" => $subtotal,
        "tax" => $tax,
        "newSubtotal" => $newSubtotal,
        "discount" => $discount,
        "discountCode" => $discountCode,
        "discountType" => $discountType,
        "discountPercent" => $discountPercent,
        "total" => round($total, 2)
    ]);
}

function getProductLevel($quantity) 
{
	if ($quantity > setting('site.stock_threshold')) {
		return '<div class="badge badge-success">In Stock</div>';
	} else if ($quantity < setting('site.stock_threshold') && $quantity > 0) {
		return '<div class="badge badge-warning">Low Stock</div>';
	} else {
		return '<div class="badge badge-danger">Not Available</div>';
	}
}

function countries() 
{
	return array(
	    array("val0"=>"Afghanistan","val2"=>"AFG"),
	    array("val0"=>"Albania","val2"=>"ALB"),
	    array("val0"=>"Algeria","val2"=>"DZA"),
	    array("val0"=>"American Samoa","val2"=>"ASM"),
	    array("val0"=>"Andorra","val2"=>"AND"),
	    array("val0"=>"Angola","val2"=>"AGO"),
	    array("val0"=>"Anguilla","val2"=>"AIA"),
	    array("val0"=>"Antarctica","val2"=>"ATA"),
	    array("val0"=>"Antigua and Barbuda","val2"=>"ATG"),
	    array("val0"=>"Argentina","val2"=>"ARG"),
	    array("val0"=>"Armenia","val2"=>"ARM"),
	    array("val0"=>"Aruba","val2"=>"ABW"),
	    array("val0"=>"Australia","val2"=>"AUS"),
	    array("val0"=>"Austria","val2"=>"AUT"),
	    array("val0"=>"Azerbaijan","val2"=>"AZE"),
	    array("val0"=>"Bahamas","val2"=>"BHS"),
	    array("val0"=>"Bahrain","val2"=>"BHR"),
	    array("val0"=>"Bangladesh","val2"=>"BGD"),
	    array("val0"=>"Barbados","val2"=>"BRB"),
	    array("val0"=>"Belarus","val2"=>"BLR"),
	    array("val0"=>"Belgium","val2"=>"BEL"),
	    array("val0"=>"Belize","val2"=>"BLZ"),
	    array("val0"=>"Benin","val2"=>"BEN"),
	    array("val0"=>"Bermuda","val2"=>"BMU"),
	    array("val0"=>"Bhutan","val2"=>"BTN"),
	    array("val0"=>"Bolivia, Plurinational State of","val2"=>"BOL"),
	    array("val0"=>"Bolivia","val2"=>"BOL"),
	    array("val0"=>"Bosnia and Herzegovina","val2"=>"BIH"),
	    array("val0"=>"Botswana","val2"=>"BWA"),
	    array("val0"=>"Bouvet Island","val2"=>"BVT"),
	    array("val0"=>"Brazil","val2"=>"BRA"),
	    array("val0"=>"British Indian Ocean Territory","val2"=>"IOT"),
	    array("val0"=>"Brunei Darussalam","val2"=>"BRN"),
	    array("val0"=>"Brunei","val2"=>"BRN"),
	    array("val0"=>"Bulgaria","val2"=>"BGR"),
	    array("val0"=>"Burkina Faso","val2"=>"BFA"),
	    array("val0"=>"Burundi","val2"=>"BDI"),
	    array("val0"=>"Cambodia","val2"=>"KHM"),
	    array("val0"=>"Cameroon","val2"=>"CMR"),
	    array("val0"=>"Canada","val2"=>"CAN"),
	    array("val0"=>"Cape Verde","val2"=>"CPV"),
	    array("val0"=>"Cayman Islands","val2"=>"CYM"),
	    array("val0"=>"Central African Republic","val2"=>"CAF"),
	    array("val0"=>"Chad","val2"=>"TCD"),
	    array("val0"=>"Chile","val2"=>"CHL"),
	    array("val0"=>"China","val2"=>"CHN"),
	    array("val0"=>"Christmas Island","val2"=>"CXR"),
	    array("val0"=>"Cocos (Keeling) Islands","val2"=>"CCK"),
	    array("val0"=>"Colombia","val2"=>"COL"),
	    array("val0"=>"Comoros","val2"=>"COM"),
	    array("val0"=>"Congo","val2"=>"COG"),
	    array("val0"=>"Congo, the Democratic Republic of the","val2"=>"COD"),
	    array("val0"=>"Cook Islands","val2"=>"COK"),
	    array("val0"=>"Costa Rica","val2"=>"CRI"),
	    array("val0"=>"Côte d'Ivoire","val2"=>"CIV"),
	    array("val0"=>"Ivory Coast","val2"=>"CIV"),
	    array("val0"=>"Croatia","val2"=>"HRV"),
	    array("val0"=>"Cuba","val2"=>"CUB"),
	    array("val0"=>"Cyprus","val2"=>"CYP"),
	    array("val0"=>"Czech Republic","val2"=>"CZE"),
	    array("val0"=>"Denmark","val2"=>"DNK"),
	    array("val0"=>"Djibouti","val2"=>"DJI"),
	    array("val0"=>"Dominica","val2"=>"DMA"),
	    array("val0"=>"Dominican Republic","val2"=>"DOM"),
	    array("val0"=>"Ecuador","val2"=>"ECU"),
	    array("val0"=>"Egypt","val2"=>"EGY"),
	    array("val0"=>"El Salvador","val2"=>"SLV"),
	    array("val0"=>"Equatorial Guinea","val2"=>"GNQ"),
	    array("val0"=>"Eritrea","val2"=>"ERI"),
	    array("val0"=>"Estonia","val2"=>"EST"),
	    array("val0"=>"Ethiopia","val2"=>"ETH"),
	    array("val0"=>"Falkland Islands (Malvinas)","val2"=>"FLK"),
	    array("val0"=>"Faroe Islands","val2"=>"FRO"),
	    array("val0"=>"Fiji","val2"=>"FJI"),
	    array("val0"=>"Finland","val2"=>"FIN"),
	    array("val0"=>"France","val2"=>"FRA"),
	    array("val0"=>"French Guiana","val2"=>"GUF"),
	    array("val0"=>"French Polynesia","val2"=>"PYF"),
	    array("val0"=>"French Southern Territories","val2"=>"ATF"),
	    array("val0"=>"Gabon","val2"=>"GAB"),
	    array("val0"=>"Gambia","val2"=>"GMB"),
	    array("val0"=>"Georgia","val2"=>"GEO"),
	    array("val0"=>"Germany","val2"=>"DEU"),
	    array("val0"=>"Ghana","val2"=>"GHA"),
	    array("val0"=>"Gibraltar","val2"=>"GIB"),
	    array("val0"=>"Greece","val2"=>"GRC"),
	    array("val0"=>"Greenland","val2"=>"GRL"),
	    array("val0"=>"Grenada","val2"=>"GRD"),
	    array("val0"=>"Guadeloupe","val2"=>"GLP"),
	    array("val0"=>"Guam","val2"=>"GUM"),
	    array("val0"=>"Guatemala","val2"=>"GTM"),
	    array("val0"=>"Guernsey","val2"=>"GGY"),
	    array("val0"=>"Guinea","val2"=>"GIN"),
	    array("val0"=>"Guinea-Bissau","val2"=>"GNB"),
	    array("val0"=>"Guyana","val2"=>"GUY"),
	    array("val0"=>"Haiti","val2"=>"HTI"),
	    array("val0"=>"Heard Island and McDonald Islands","val2"=>"HMD"),
	    array("val0"=>"Holy See (Vatican City State)","val2"=>"VAT"),
	    array("val0"=>"Honduras","val2"=>"HND"),
	    array("val0"=>"Hong Kong","val2"=>"HKG"),
	    array("val0"=>"Hungary","val2"=>"HUN"),
	    array("val0"=>"Iceland","val2"=>"ISL"),
	    array("val0"=>"India","val2"=>"IND"),
	    array("val0"=>"Indonesia","val2"=>"IDN"),
	    array("val0"=>"Iran, Islamic Republic of","val2"=>"IRN"),
	    array("val0"=>"Iraq","val2"=>"IRQ"),
	    array("val0"=>"Ireland","val2"=>"IRL"),
	    array("val0"=>"Isle of Man","val2"=>"IMN"),
	    array("val0"=>"Israel","val2"=>"ISR"),
	    array("val0"=>"Italy","val2"=>"ITA"),
	    array("val0"=>"Jamaica","val2"=>"JAM"),
	    array("val0"=>"Japan","val2"=>"JPN"),
	    array("val0"=>"Jersey","val2"=>"JEY"),
	    array("val0"=>"Jordan","val2"=>"JOR"),
	    array("val0"=>"Kazakhstan","val2"=>"KAZ"),
	    array("val0"=>"Kenya","val2"=>"KEN"),
	    array("val0"=>"Kiribati","val2"=>"KIR"),
	    array("val0"=>"Korea, Democratic People's Republic of","val2"=>"PRK"),
	    array("val0"=>"Korea, Republic of","val2"=>"KOR"),
	    array("val0"=>"South Korea","val2"=>"KOR"),
	    array("val0"=>"Kuwait","val2"=>"KWT"),
	    array("val0"=>"Kyrgyzstan","val2"=>"KGZ"),
	    array("val0"=>"Lao People's Democratic Republic","val2"=>"LAO"),
	    array("val0"=>"Latvia","val2"=>"LVA"),
	    array("val0"=>"Lebanon","val2"=>"LBN"),
	    array("val0"=>"Lesotho","val2"=>"LSO"),
	    array("val0"=>"Liberia","val2"=>"LBR"),
	    array("val0"=>"Libyan Arab Jamahiriya","val2"=>"LBY"),
	    array("val0"=>"Libya","val2"=>"LBY"),
	    array("val0"=>"Liechtenstein","val2"=>"LIE"),
	    array("val0"=>"Lithuania","val2"=>"LTU"),
	    array("val0"=>"Luxembourg","val2"=>"LUX"),
	    array("val0"=>"Macao","val2"=>"MAC"),
	    array("val0"=>"Macedonia, the former Yugoslav Republic of","val2"=>"MKD"),
	    array("val0"=>"Madagascar","val2"=>"MDG"),
	    array("val0"=>"Malawi","val2"=>"MWI"),
	    array("val0"=>"Malaysia","val2"=>"MYS"),
	    array("val0"=>"Maldives","val2"=>"MDV"),
	    array("val0"=>"Mali","val2"=>"MLI"),
	    array("val0"=>"Malta","val2"=>"MLT"),
	    array("val0"=>"Marshall Islands","val2"=>"MHL"),
	    array("val0"=>"Martinique","val2"=>"MTQ"),
	    array("val0"=>"Mauritania","val2"=>"MRT"),
	    array("val0"=>"Mauritius","val2"=>"MUS"),
	    array("val0"=>"Mayotte","val2"=>"MYT"),
	    array("val0"=>"Mexico","val2"=>"MEX"),
	    array("val0"=>"Micronesia, Federated States of","val2"=>"FSM"),
	    array("val0"=>"Moldova, Republic of","val2"=>"MDA"),
	    array("val0"=>"Monaco","val2"=>"MCO"),
	    array("val0"=>"Mongolia","val2"=>"MNG"),
	    array("val0"=>"Montenegro","val2"=>"MNE"),
	    array("val0"=>"Montserrat","val2"=>"MSR"),
	    array("val0"=>"Morocco","val2"=>"MAR"),
	    array("val0"=>"Mozambique","val2"=>"MOZ"),
	    array("val0"=>"Myanmar","val2"=>"MMR"),
	    array("val0"=>"Burma","val2"=>"MMR"),
	    array("val0"=>"Namibia","val2"=>"NAM"),
	    array("val0"=>"Nauru","val2"=>"NRU"),
	    array("val0"=>"Nepal","val2"=>"NPL"),
	    array("val0"=>"Netherlands","val2"=>"NLD"),
	    array("val0"=>"Netherlands Antilles","val2"=>"ANT"),
	    array("val0"=>"New Caledonia","val2"=>"NCL"),
	    array("val0"=>"New Zealand","val2"=>"NZL"),
	    array("val0"=>"Nicaragua","val2"=>"NIC"),
	    array("val0"=>"Niger","val2"=>"NER"),
	    array("val0"=>"Nigeria","val2"=>"NGA"),
	    array("val0"=>"Niue","val2"=>"NIU"),
	    array("val0"=>"Norfolk Island","val2"=>"NFK"),
	    array("val0"=>"Northern Mariana Islands","val2"=>"MNP"),
	    array("val0"=>"Norway","val2"=>"NOR"),
	    array("val0"=>"Oman","val2"=>"OMN"),
	    array("val0"=>"Pakistan","val2"=>"PAK"),
	    array("val0"=>"Palau","val2"=>"PLW"),
	    array("val0"=>"Palestinian Territory, Occupied","val2"=>"PSE"),
	    array("val0"=>"Panama","val2"=>"PAN"),
	    array("val0"=>"Papua New Guinea","val2"=>"PNG"),
	    array("val0"=>"Paraguay","val2"=>"PRY"),
	    array("val0"=>"Peru","val2"=>"PER"),
	    array("val0"=>"Philippines","val2"=>"PHL"),
	    array("val0"=>"Pitcairn","val2"=>"PCN"),
	    array("val0"=>"Poland","val2"=>"POL"),
	    array("val0"=>"Portugal","val2"=>"PRT"),
	    array("val0"=>"Puerto Rico","val2"=>"PRI"),
	    array("val0"=>"Qatar","val2"=>"QAT"),
	    array("val0"=>"Réunion","val2"=>"REU"),
	    array("val0"=>"Romania","val2"=>"ROU"),
	    array("val0"=>"Russian Federation","val2"=>"RUS"),
	    array("val0"=>"Russia","val2"=>"RUS"),
	    array("val0"=>"Rwanda","val2"=>"RWA"),
	    array("val0"=>"Saint Helena, Ascension and Tristan da Cunha","val2"=>"SHN"),
	    array("val0"=>"Saint Kitts and Nevis","val2"=>"KNA"),
	    array("val0"=>"Saint Lucia","val2"=>"LCA"),
	    array("val0"=>"Saint Pierre and Miquelon","val2"=>"SPM"),
	    array("val0"=>"Saint Vincent and the Grenadines","val2"=>"VCT"),
	    array("val0"=>"Saint Vincent & the Grenadines","val2"=>"VCT"),
	    array("val0"=>"St. Vincent and the Grenadines","val2"=>"VCT"),
	    array("val0"=>"Samoa","val2"=>"WSM"),
	    array("val0"=>"San Marino","val2"=>"SMR"),
	    array("val0"=>"Sao Tome and Principe","val2"=>"STP"),
	    array("val0"=>"Saudi Arabia","val2"=>"SAU"),
	    array("val0"=>"Senegal","val2"=>"SEN"),
	    array("val0"=>"Serbia","val2"=>"SRB"),
	    array("val0"=>"Seychelles","val2"=>"SYC"),
	    array("val0"=>"Sierra Leone","val2"=>"SLE"),
	    array("val0"=>"Singapore","val2"=>"SGP"),
	    array("val0"=>"Slovakia","val2"=>"SVK"),
	    array("val0"=>"Slovenia","val2"=>"SVN"),
	    array("val0"=>"Solomon Islands","val2"=>"SLB"),
	    array("val0"=>"Somalia","val2"=>"SOM"),
	    array("val0"=>"South Africa","val2"=>"ZAF"),
	    array("val0"=>"South Georgia and the South Sandwich Islands","val2"=>"SGS"),
	    array("val0"=>"Spain","val2"=>"ESP"),
	    array("val0"=>"Sri Lanka","val2"=>"LKA"),
	    array("val0"=>"Sudan","val2"=>"SDN"),
	    array("val0"=>"Suriname","val2"=>"SUR"),
	    array("val0"=>"Svalbard and Jan Mayen","val2"=>"SJM"),
	    array("val0"=>"Swaziland","val2"=>"SWZ"),
	    array("val0"=>"Sweden","val2"=>"SWE"),
	    array("val0"=>"Switzerland","val2"=>"CHE"),
	    array("val0"=>"Syrian Arab Republic","val2"=>"SYR"),
	    array("val0"=>"Taiwan, Province of China","val2"=>"TWN"),
	    array("val0"=>"Taiwan","val2"=>"TWN"),
	    array("val0"=>"Tajikistan","val2"=>"TJK"),
	    array("val0"=>"Tanzania, United Republic of","val2"=>"TZA"),
	    array("val0"=>"Thailand","val2"=>"THA"),
	    array("val0"=>"Timor-Leste","val2"=>"TLS"),
	    array("val0"=>"Togo","val2"=>"TGO"),
	    array("val0"=>"Tokelau","val2"=>"TKL"),
	    array("val0"=>"Tonga","val2"=>"TON"),
	    array("val0"=>"Trinidad and Tobago","val2"=>"TTO"),
	    array("val0"=>"Trinidad & Tobago","val2"=>"TTO"),
	    array("val0"=>"Tunisia","val2"=>"TUN"),
	    array("val0"=>"Turkey","val2"=>"TUR"),
	    array("val0"=>"Turkmenistan","val2"=>"TKM"),
	    array("val0"=>"Turks and Caicos Islands","val2"=>"TCA"),
	    array("val0"=>"Tuvalu","val2"=>"TUV"),
	    array("val0"=>"Uganda","val2"=>"UGA"),
	    array("val0"=>"Ukraine","val2"=>"UKR"),
	    array("val0"=>"United Arab Emirates","val2"=>"ARE"),
	    array("val0"=>"United Kingdom","val2"=>"GBR"),
	    array("val0"=>"United States","val2"=>"USA"),
	    array("val0"=>"United States Minor Outlying Islands","val2"=>"UMI"),
	    array("val0"=>"Uruguay","val2"=>"URY"),
	    array("val0"=>"Uzbekistan","val2"=>"UZB"),
	    array("val0"=>"Vanuatu","val2"=>"VUT"),
	    array("val0"=>"Venezuela, Bolivarian Republic of","val2"=>"VEN"),
	    array("val0"=>"Venezuela","val2"=>"VEN"),
	    array("val0"=>"Viet Nam","val2"=>"VNM"),
	    array("val0"=>"Vietnam","val2"=>"VNM"),
	    array("val0"=>"Virgin Islands, British","val2"=>"VGB"),
	    array("val0"=>"Virgin Islands, U.S.","val2"=>"VIR"),
	    array("val0"=>"Wallis and Futuna","val2"=>"WLF"),
	    array("val0"=>"Western Sahara","val2"=>"ESH"),
	    array("val0"=>"Yemen","val2"=>"YEM"),
	    array("val0"=>"Zambia","val2"=>"ZMB"),
	    array("val0"=>"Zimbabwe","val2"=>"ZWE")
	);
}