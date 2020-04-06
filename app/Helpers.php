<?php
function toDigits($n) {
	return str_replace(['+7',' ','(',')','-'], '', $n);
}