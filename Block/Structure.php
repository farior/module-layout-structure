<?php
/**
 * @author      Sergey Babko <srgbabko@gmail.com>
 * @copyright   © 2017 farior (https://github.com/farior)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Farior\LayoutStructure\Block;

class Structure extends \Magento\Framework\View\Element\Template
{
    const ROOT_ELEMENT_NAME = 'root';

    /**
     * @param string $rootElement
     * @return array
     */
    public function renderStructureJsonConfig($rootElement = self::ROOT_ELEMENT_NAME)
    {
        return $this->getNodeConfig($this->buildStructureTree($rootElement));
    }

    /**
     * @param array $structureTree
     * @return array
     */
    protected function getNodeConfig(array $structureTree)
    {
        $config = [];

        foreach ($structureTree as $element) {
            $node = [
                'text' => [
                    'name' => $element['type']
                ]
            ];

            $node['text']['title'] = $element['alias'] && $element['alias'] != $element['name']
                ? sprintf('%s (%s)', $element['name'], $element['alias'])
                : $element['name'];

            if (isset($element['block'])) {
                $node['text']['desc'] = $element['block']['type'];
                $node['text']['contact'] = $element['block']['template'] ? $element['block']['template'] : '';
            }

            if (isset($element['children'])) {
                $node['children'] = $this->getNodeConfig($element['children']);
            }

            $config[] = $node;
        }

        return $config;
    }

    /**
     * @param string $rootElement
     * @return array
     */
    protected function buildStructureTree($rootElement)
    {
        $structureTree = [];

        $layoutStructure = $this->getLayoutStructure();

        if (!$layoutStructure) {
            return $structureTree;
        }

        $layoutElements = $layoutStructure->exportElements();

        $this->addChildren($structureTree, $layoutElements, $rootElement, $layoutElements[$rootElement]);

        return $structureTree;
    }

    /**
     * @param array  $structureTree
     * @param array  $layoutElements
     * @param string $name
     * @param array  $element
     * @param string $alias
     */
    protected function addChildren(array &$structureTree, array $layoutElements, $name, array $element, $alias = '')
    {
        $structureTree[$name] = [
            'type'      => $element['type'],
            'name'      => $name,
            'alias'     => $alias,
            'label'     => isset($element['label']) ? $element['label'] : '',
            'htmlTag'   => isset($element['htmlTag']) ? $element['htmlTag'] : '',
            'htmlId'    => isset($element['htmlId']) ? $element['htmlId'] : '',
            'htmlClass' => isset($element['htmlClass']) ? $element['htmlClass'] : '',
            'display'   => isset($element['display']) ? $element['display'] : ''
        ];

        if ($element['type'] == 'block') {
            $block = $this->getLayout()->getBlock($name);

            if ($block instanceof \Magento\Framework\View\Element\Template) {
                $structureTree[$name]['block'] = [
                    'type'     => $block->getData('type'),
                    'template' => $block->getTemplate()
                ];
            }
        }

        if (isset($element['children'])) {
            $structureTree[$name]['children'] = [];

            foreach ($element['children'] as $childName => $childAlias) {
                $this->addChildren(
                    $structureTree[$name]['children'],
                    $layoutElements,
                    $childName,
                    $layoutElements[$childName],
                    $childAlias
                );
            }
        }
    }

    /**
     * @return \Magento\Framework\View\Layout\Data\Structure|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function getLayoutStructure()
    {
        $layout = $this->getLayout();

        if (!$layout instanceof \Farior\LayoutStructure\View\Layout) {
            return null;
        }

        return $layout->getStructure();
    }
}
