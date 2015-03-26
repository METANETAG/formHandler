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
	 * @param callable $callback An optional callback which converts the given value to field compatible one
	 */
	public function attach($reference, callable $callback = null);

	/**
	 * @return bool
	 */
	public function isAttached();

	/**
	 * @return mixed
	 */
	public function getAttached();

	/**
	 * @param mixed $data
	 */
	public function setAttachedData($data);
}

/* EOF */