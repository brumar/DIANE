<?php
class BinaryTree
{
	public $root; // the root node of our tree

	public function __construct() {
		$this->root = null;
	}

	public function isEmpty() {
		return $this->root === null;
	}

	public function traverse() {
		// dump the tree rooted at "root"
		$this->root->dump();
	}
}

?>
