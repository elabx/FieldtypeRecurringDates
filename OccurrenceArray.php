<?php namespace ProcessWire;

class OccurrenceArray extends PaginatedArray
{

    public function makeBlankItem()
    {
        return $this->wire(new Occurrence());
    }

    public function isValidItem($item): bool
    {
        return $item instanceof Occurrence;
    }

    /**
     * @return false|string
     * @throws WireException
     */
    public function __toString()
    {
        $pager = $this->modules->get("MarkupPagerNav");
        $pager =  $pager->render($this, [
          'listClass' => 'uk-pagination MarkupPagerNav',
          'linkMarkup' => "<a @click='setPage' data-item='{index}' href=''><span>{out}</span></a>",
        ]);
        $a = [
          'dates' => [],
          'pagination' => [
            'start' => $this->getStart(),
            'limit' => $this->getLimit(),
            'total' => $this->getTotal(),
            'pagination_string' => $this->getPaginationString(),
            'markup_pager' => $pager
          ]
        ];
        foreach ($this->data as $item) $a['dates'][] = (string)$item;
        return json_encode($a, true);

    }
}
