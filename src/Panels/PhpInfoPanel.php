<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use DOMDocument;
use DOMElement;
use Jwebas\Debugger\Support\Panel;

class PhpInfoPanel extends Panel
{
    /**
     * Panel id
     *
     * @var string|null
     */
    public $id = 'phpInfo';

    /**
     * Bar title
     *
     * @var string
     */
    public $barTitle;

    /**
     * Panel title
     *
     * @var string
     */
    public $panelTitle = 'Php Info';

    /**
     * @var string|null
     */
    public $iconTemplate = __DIR__ . '/templates/php_info/icon.svg';

    /**
     * @var string|null
     */
    public $panelTemplate = __DIR__ . '/templates/php_info/panel.phtml';

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        ob_start();
        phpinfo();
        $phpInfo = ob_get_clean();

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        if (function_exists('mb_convert_encoding')) {
            $dom->loadHTML(mb_convert_encoding($phpInfo, 'HTML-ENTITIES', 'UTF-8'));
        } else {
            $dom->loadHTML(htmlspecialchars_decode(utf8_decode(htmlentities($phpInfo, ENT_COMPAT, 'UTF-8', false))));
        }
        libxml_use_internal_errors();

        /** @var DOMElement $body */
        $body = $dom->getElementsByTagName('body')->item(0);
        $this->removeElementsByTagName('img', $body);

        return [
            'dom' => $dom->saveHTML($body),
        ];
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return true;
    }

    /**
     * @param string     $tagName
     * @param DOMElement $document
     */
    protected function removeElementsByTagName($tagName, DOMElement $document): void
    {
        $nodeList = $document->getElementsByTagName($tagName);
        for ($nodeIdx = $nodeList->length; --$nodeIdx >= 0;) {
            $node = $nodeList->item($nodeIdx);
            $node->parentNode->removeChild($node);
        }
    }
}
