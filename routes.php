<?php

require_once('models/post.php');
require_once('models/tag.php');
require_once('models/catagory.php');
require_once('models/profile.php');
require_once('models/upload.php');
require_once('models/email.php');

  function call ($controller, $action)
  {
    require_once("controllers/".$controller."_controller.php");

    switch ($controller)
    {
      case 'pages':
        $controller = new PagesController();
        break;
      case 'post':
        $controller = new PagesController();
        break;
      case 'portfolio':
          $controller = new PortfolioController();
          break;
      case 'admin':
        require_once('models/admin.php');
        $controller = new AdminController();
        break;
      case 'evaluation':
        require_once('models/evaluation.php');
        $controller = new EvaluationController();
        break;
      case 'user':
        $controller = new UserController();
        break;
    }
    $controller->{$action}();
  }

  $controllers = array (  'pages'     => ['home', 'index', 'viewPost', 'about', 'portfolio', 'contact', 'sandbox','mobilelab','services','food'],
                          'post'      => ['index', 'about', 'error', 'viewPost', 'getByTag'],
                          'portfolio' => ['index', 'error', 'viewPost','getByTag'],
                          'admin'     => ['index', 'addPost','insertPost','insertCat','linkTag','linktagtocat','addCat', 'addTag','insertTag', 'editPost','updatePost','removePost','deletePost', 'error'],
                          'evaluation'=> ['index', 'addCriteria', 'insertCriteria', 'addCriteriaSet', 'insertCriteriaSet'],
                          'user'      => ['login','addUser','editUser', 'insertUser', 'logout', 'viewProfile']);

  if(array_key_exists($controller, $controllers))
    if(in_array($action, $controllers[$controller]))
      call($controller, $action);
    else
      call('pages', 'error');
  else
    call('pages', 'error');

?>
