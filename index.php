<?php
require('inc/function/function1.php');

addArticle();
suppArticle();
updateArticle();
$articles = getListArticle();

$sPage = (isset($_GET['page']) ? $_GET['page'] : 'home');



include('tpl/header.phtml');

switch ($sPage)
{
	case 'home' :
	include('tpl/main.phtml');
	break;

	case "new":
	include('tpl/formulaire.phtml');
	break;

	case "post":
	include('tpl/article.phtml');
	//Je peux envoyer plusieurs valeurs via la méthode GET pour rentrer dans post et ensuite proposer un ID pour l'article. 
	break;
	
	default :
		// soit accueil
	include('tpl/error_404.phtml');
}



include('tpl/footer.phtml');

