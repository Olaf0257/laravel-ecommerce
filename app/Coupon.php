<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
	public const FIXED_VALUE = 'fixed_value';
	public const PERCENT_OFF = 'percent_off';

	public function discount($total)
	{
		if ($this->type == self::FIXED_VALUE) {
			return $this->{self::FIXED_VALUE};
		} else if ($this->type == self::PERCENT_OFF) {
			return ($this->{self::PERCENT_OFF} / 100) * doubleval($total);
		} else {
			return 0;
		}
	}
}