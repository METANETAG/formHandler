<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\component\Collection;
use ch\metanet\formHandler\component\Component;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class NullCollectionComponentRenderer extends CollectionComponentRenderer {
	public function render(Collection $collectionComponent) {
		$html = '';
		
		foreach($collectionComponent->getComponents() as $component) {
			/** @var Component $component */
			$html .= $component->render();
		}
		
		return $html;
	}
}

/* EOF */