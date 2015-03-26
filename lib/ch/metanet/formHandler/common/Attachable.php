<?php

namespace ch\metanet\formHandler\common;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2015, METANET AG
 */
interface Attachable
{
	/**
	 * @param mixed $reference
	 */
	public function attach($reference);

	/**
	 * @return bool
	 */
	public function isAttached();
}

/* EOF */