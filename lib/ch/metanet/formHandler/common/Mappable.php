<?php

namespace ch\metanet\formHandler\common;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2015, METANET AG
 */
interface Mappable
{
	/**
	 * @param mixed $reference
	 * @param callable $callback An optional callback which converts the given value to field compatible one
	 */
	public function map($reference, callable $callback = null);

	/**
	 * @return bool
	 */
	public function isMapped();

	/**
	 * @return mixed
	 */
	public function getMapped();

	/**
	 * @param mixed $data
	 */
	public function setMappedData($data);

	/**
	 * @return mixed
	 */
	public function getMappedData();
}

/* EOF */