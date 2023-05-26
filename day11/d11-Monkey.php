<?php

class Monkey
{
    private $id;
    private $items;
    private $operator;
    private $operand;
    private $divBy;
    private $ifTrue;
    private $ifFalse;
    private $inspections;

    function __construct($id, $items, $operator, $operand, $divBy, $ifTrue, $ifFalse)
    {
        $this->id = (int)$id;
        $this->items = $items;
        $this->operator = $operator;
        $this->operand = $operand;
        $this->divBy = (int)$divBy;
        $this->ifTrue = (int)$ifTrue;
        $this->ifFalse = (int)$ifFalse;
        $this->inspections = 0;
    }

    //Methods
    function getId() {
        return $this->id;
    }
    function getItems() {
        return $this->items;
    }
    function getDivBy() {
        return $this->divBy;
    }
    function getInspections() {
        return $this->inspections;
    }
    function setInspections($newInspections)
    {
        $this->inspections += $newInspections;
    }


    public function monkeyAction($monkies, $part)
    {
        $item = (int)array_shift($this->items);
        if ($this->operand == "old") {
            if ($this->operator == '*') {
                $item = $item * $item;
            } else {
                $item = $item + $item;
            }
        } else
            if ($this->operator == '*') {
                $item = $item * (int)$this->operand;
            } else {
                $item = $item + (int)$this->operand;
            }
        
        if ($part == 1) {
            $item = (int)floor($item /3);
        } else {
            foreach ($monkies as $monkey) {
                $divBys[] = $monkey->getDivBy();
            }
            $supermod = array_product($divBys); //9 699 690 (11*5*19*13*7*17*2*3)
            $item = (int)($item % $supermod);
        }

        if ($item % $this->divBy == 0) {
            $monkies[$this->ifTrue]->items[] = $item;

        } else {
            $monkies[$this->ifFalse]->items[] = $item;
        }
    }
}
