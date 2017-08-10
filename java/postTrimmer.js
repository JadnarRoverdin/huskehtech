$(document).ready(function(){
  $(function(){
    var maxL = 500;
    $('div.content').each(function(i,div){
      var text = $(div).text();
      if(text.length>maxL)
      {
        var begin = text.substr(0,maxL),
            end = text.substr(maxL);
        $(div).html(begin)
          .append($('<a class="readmore"/>').attr('href', '#').html('read more...'))
          .append($('<div class="hidden" />').html(end));
      }
    });

    $document.on('click','.readmore',function()
    {
      $(this).next('.hidden').slideDown(750);
    })

  });
});
