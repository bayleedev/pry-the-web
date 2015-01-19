<?php

class WordProblem {

  public $phrase = null;

  public function __construct($phrase) {
    $this->phrase = $phrase;
  }

  public function answer() {
    $tree = $this->tree($this->_question());
    eval(\Psy\sh());
    $transformer = new Transformer($tree);
    return $transformer->compute();
  }

  protected function _question() {
    preg_match('/what is (.*)\?/i', $this->phrase, $matches);
    if (empty($matches[1])) {
      throw new InvalidArgumentException('No question found...');
    }
    return $matches[1];
  }

  protected function tree() {
    $question = new Parser($this->_question());
    return $question->tree();
  }

}

class Parser {

  public $question = null;

  public function __construct($question) {
    $this->question = $question;
  }

  public function tree() {
    return $this->_tree($this->question);
  }

  protected function _tree($phrase) {
    if (preg_match('/^(\-|\+)?\d+$/', $phrase)) {
      return $phrase;
    }
    preg_match('/((?:\-|\+)?\d+) (multiplied by|minus|plus|divided by) (.*)/', $phrase, $matches);
    if (empty($matches)) {
      throw new InvalidArgumentException('Wat?');
    }
    $root = array_slice($matches, 1);
    $root[2] = $this->_tree($root[2]);
    return $root;
  }

}

class Transformer {

  public $tree = array();

  public function __construct(array $tree) {
    $this->tree = $tree;
  }

  public function compute() {
    return $this->answer($this->tree);
  }

  public function answer($branch) {
    if (is_array($branch[0])) {
      $branch[0] = $this->answer($branch[0]);
    }
    $operator = str_replace(' ', '_', $branch[1]);
    return $this->$operator($branch[0], $branch[2]);
  }

  public function plus($left, $right) {
    return $left + $right;
  }

  public function minus($left, $right) {
    return $left - $right;
  }

  public function divided_by($left, $right) {
    return $left / $right;
  }

  public function multiplied_by($left, $right) {
    return $left / $right;
  }

}
