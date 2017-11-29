//This java script handles 'pop ups' within a webpage.
//Elements that you want to trigger a pop up should have a class identifier: 'popupmaker'
//Elements that you want to have triggered should have class identifier: 'popup'
//Both the triggering elements and triggered elements should have the same Id
//if the element has an exit functionality, should have the triggering element with a class
//      identifier of: 'exit'.

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
