<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\component\Collection;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
abstract class CollectionComponentRenderer extends ComponentRenderer
{
	public abstract function render(Collection $component);
}

/* EOF */ 