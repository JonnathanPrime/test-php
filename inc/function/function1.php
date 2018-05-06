<?php

$pdo = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
$pdo->exec('SET NAMES UTF8');

function getListArticle(){
	global $pdo;

	$aTab = array();

	$query = $pdo->prepare(
	'SELECT titre, contenu, mydate, categorie, id_article FROM article ORDER BY mydate DESC');
	
	if ($query->execute()) {		
		$aTab = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($aTab as $iKey => $aData) {
      $aTab[$iKey]['nb_comments'] = getcountComment($aData['id_article']);
    }
	}

	return $aTab;
}


function addArticle(){
	global $pdo;
	//Si l'action de validation a été faite
  if(isset($_POST['envoyer']))
  {
  		// On récupère les valeurs du formulaire dans un tableau
  	$tab = array(
    'title' => $_POST['title'],
    'contenu' => $_POST['contenu'],
    'categorie' => $_POST['categorie']
    );

// J'indique a ma base de données que je souhaite écrire dedans
  	// Les deux points correspondent aux en-tete du tableau
    $var = $pdo->prepare('INSERT INTO article (titre, contenu, categorie, mydate) VALUES (:title, :contenu, :categorie, NOW())');
    // Ici est appelé le tableau 
    $var2 = $var->execute($tab);
	}
}

function suppArticle(){
	global $pdo;
//Si l'action de validation a été faite
  if(isset($_POST['supprimer']))
  {    


  		if(isset($_POST['id_article'])){
  				$delete = $pdo->prepare('DELETE FROM article WHERE id_article='.$_POST['id_article'].'');
  				 $var3 = $delete->execute();
  		}else{
  				echo('Echec de la suppression');
  		}
  }
}

// Fonction a tester après raccordement + appel
function updateArticle(){
    global $pdo;
//Si l'action de validation a été faite
  if(isset($_POST['enregistrer']))
  {    
     
  	$update = $pdo->prepare('UPDATE article SET titre = "'.$_POST['title'].'", contenu ="'.$_POST['contenu'].'", categorie ="'.$_POST['categorie'].'" WHERE id_article='.$_POST['idpost'].'');
  		$var4 = $update->execute();
  }
}

function fullArticle(){
  global $pdo;
  
    $idurl = $_GET["code"];

	$aTab2 = array();

	$query = $pdo->prepare(
	'SELECT titre, contenu, categorie, mydate, id_article FROM article WHERE id_article ="'.$idurl.'"');
	
	if ($query->execute()) {		
		$aTab2 = $query->fetchAll(PDO::FETCH_ASSOC);
	}

	return $aTab2;
}


function getcountComment($iIdArticle) {
  global $pdo;

  $query = $pdo->prepare('SELECT id_comment FROM commentaire WHERE id_article=?');
  
  if ($query->execute([$iIdArticle])) {    
    return $query->rowCount();
  }

  return 0;
}

function getListComment(){
  global $pdo;

   $idurl = $_GET["code"];

  $aTab3 = array();

  $query = $pdo->prepare(
  'SELECT pseudo, mydate, comment, id_article FROM commentaire WHERE id_article ="'.$idurl.'"');
  
  if ($query->execute()) {    
    $aTab3 = $query->fetchAll(PDO::FETCH_ASSOC);
  }
  return $aTab3;
}

function addComment(){
  global $pdo;
   $idurl = $_GET["code"];
  //Si l'action de validation a été faite
  if(isset($_POST['commenter']))
  {
      // On récupère les valeurs du formulaire dans un tableau
    $tab4 = array(
    'pseudo' => $_POST['pseudo'],
    'comment' => $_POST['comment'],
    'id_article' => $idurl
    );

// J'indique a ma base de données que je souhaite écrire dedans
    // Les deux points correspondent aux en-tete du tableau
    $var6 = $pdo->prepare('INSERT INTO commentaire (pseudo, comment, id_article, mydate) VALUES (:pseudo, :comment, :id_article, NOW())');
    // Ici est appelé le tableau 
    $var7 = $var6->execute($tab4);
  }
}