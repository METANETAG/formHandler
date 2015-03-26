<?php

namespace ch\metanet\formHandler\mappable;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2015, METANET AG
 */
interface Mappable
{
	/**
	 * Maps a components value to an object or a property and vice versa
	 * 
	 * @param mixed $reference
	 */
	public function map($reference);

	/**
	 * Returns true if the component is mapped or false if not
	 * 
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