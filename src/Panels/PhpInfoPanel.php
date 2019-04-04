<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use DOMDocument;
use DOMElement;
use Jwebas\Debugger\Panels\Abstracts\AbstractPanel;

class PhpInfoPanel extends AbstractPanel
{
    /**
     * @var string
     */
    protected $title = 'Php Info';

    /**
     * @var string
     */
    protected $template = __DIR__ . '/templates/php_info/';

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
