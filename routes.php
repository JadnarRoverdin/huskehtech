<?php
  date_default_timezone_set('America/New_York');
  require_once("models/post.php");
  require_once("models/project.php");
  require_once("models/portfolio.php");
  require_once("models/content.php");
  require_once("models/tag.php");
  require_once("models/email.php");
  function call ($controller, $action)
  {
    require_once("controllers/".$controller."_controller.php");

    switch ($controller)
    {
      case 'pages':
        $controller = new PagesController();
        break;
      case 'user':
        $controller = new UserController();
        break;
      case 'news':
        $controller = new NewsController();
        break;
      case 'project':
        $controller = new ProjectController();
        break;
      case 'submission':
        $controller = new SubmissionController();
        break;


    }
    $controller->{$action}();
  }

  $controllers = array (  'pages'     => ['home', 'index', 'news', 'portfolio','admin','contact'],
                          'user'      => ['register', 'resetPassword', 'login', 'logout', 'viewProfile'],
                          'news'      => ['new', 'update', 'delete'],
                          'project' => ['insert', 'viewPortfolio', 'viewProject', 'update', 'delete', 'upload', 'getByTag'],
                          'submission'=> ['submit', 'delete'] );

  if(array_key_exists($controller, $controllers))
    if(in_array($action, $controllers[$controller]))
      call($controller, $action);
    else
      call('pages', 'error');
  else
    call('pages', 'error');
?>
