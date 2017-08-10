<?php
require_once('models/post.php');
  function call ($controller, $action)
  {
    require_once("controllers/".$controller."_controller.php");

    switch ($controller)
    {
      case 'pages':
        require_once('models/database.php');
        $controller = new PagesController();
        break;
      case 'post':
        require_once('models/database.php');
        $controller = new PagesController();
        break;
      case 'portfolio':
          require_once('models/database.php');
          $controller = new PortfolioController();
          break;
      case 'admin':
        require_once('models/admin.php');
        require_once('models/database.php');
        $controller = new AdminController();
        break;
      case 'evaluation':
        require_once('models/evaluation.php');
        $controller = new EvaluationController();
        break;
      case 'user':
        require_once('models/user.php');
        require_once('models/database.php');
        $controller = new UserController();
        break;
    }
    $controller->{$action}();
  }

  $controllers = array (  'pages'     => ['home', 'index', 'viewPost', 'about', 'portfolio', 'sandbox','mobilelab','services','food'],
                          'post'      => ['index', 'about', 'error', 'viewPost', 'getByTag'],
                          'portfolio' => ['index', 'error', 'viewPost','getByTag'],
                          'admin'     => ['index', 'addPost','insertPost', 'addTag','insertTag', 'editPost','updatePost','removePost','deletePost', 'error'],
                          'evaluation'=> ['index', 'addCriteria', 'insertCriteria', 'addCriteriaSet', 'insertCriteriaSet'],
                          'user'      => ['login','addUser','insertUser', 'logout']);

  if(array_key_exists($controller, $controllers))
    if(in_array($action, $controllers[$controller]))
      call($controller, $action);
    else
      call('pages', 'error');
  else
    call('pages', 'error');

?>
