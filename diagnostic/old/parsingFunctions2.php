<?php
require_once('class.binarytree.php');
require_once('class.binarynode.php');

function	get_tree($str)
{
	preg_match_all("[\d+]", $str, $nbs, PREG_SET_ORDER);
	preg_match_all("[[+*-/]]", $str, $ops, PREG_SET_ORDER);
	$tree = new BinaryTree();
	$tree->root = new BinaryNode($ops[0]);
	$tree->root->left = new BinaryNode($nbs[0]);
	$tree->root->right = new BinaryNode($nbs[1]);
	return $tree;
}

?>
