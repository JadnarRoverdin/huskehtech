$(document).ready(function()
{
  var current;                              //Stores the id of the triggered element

  $(".exit").click(function(){              //Manages the exit out of popups
      $(".overlay, div#"+current).fadeToggle();
  })

  $(".popupmaker").click(function(){        //Manages the entrance of popups
    current = $(this).attr('id');
    $(".overlay, div#"+ current).fadeToggle();
  })
});
