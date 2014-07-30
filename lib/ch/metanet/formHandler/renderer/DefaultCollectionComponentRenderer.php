<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\component\Collection;
use ch\metanet\formHandler\component\Component;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class DefaultCollectionComponentRenderer extends CollectionComponentRenderer {
	public function render(Collection $collectionComponent) {
		$componentCount = count($collectionComponent->getComponents());
		$emptyCssClass = ($componentCount === 0)?' collection-empty':null;
		
		$html = '<div class="collection collection-' . $collectionComponent->getName() . $emptyCssClass . '">';
		
		foreach($collectionComponent->getComponents() as $component) {
			/** @var Component $component */
			$html .= $component->render();
		}
		
		$html .= '</div>';
		
		return $html;
	}
}

/* EOF */