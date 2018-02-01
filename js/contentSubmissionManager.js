$(document).ready(function(){
    $(".clone").click(function(){
        var cloneditem = $(".postimage").clone();
        cloneditem.addClass('postimageafter');
        cloneditem.removeClass("postimage");
        cloneditem.appendTo(".clonehere");
    });

    $("#numtoup").on("change", function(){
      var val = $(this).val();
      var string = ''
      var out ="";
      for(var i=0;i<val;i++)
      {
        out = out+
        "<div class='filesubmissioncard'><div class='contentSubmissionContainer'>"+
            " <input class ='typeselect' onclick='changeType(event)' target='"+i+"' type='radio' name='type"+i+"' value='link' checked> Link <br> "+
            " <input class ='typeselect' onclick='changeType(event)' target='"+i+"' type='radio' name='type"+i+"' value='file'> File <br>  "+
            " <input class ='typeselect' onclick='changeType(event)' target='"+i+"' type='radio' name='type"+i+"' value='image'> Image <br>  "+
            " <input class ='typeselect' onclick='changeType(event)' target='"+i+"' type='radio' name='type"+i+"' value='text'> Text"+
          "</div>"+
          "<div id='submissionForm'>"+
                "<input id='contentTitle"+i+"' type='text' name='contentTitle[]' placeholder='Title' required><br>"+
                "<textarea  id='contentCaption"+i+"' name='contentCaption[]' placeholder='Caption' rows='3' cols='15' ></textarea>"+
                "<input  id='format"+i+"' type='hidden' name='format[]' value='link'></div>"+
                "<div id='dataentry"+i+"'>"+
                "<input class='standard' id='data"+i+"' type='text' name='data' placeholder='http://' required></div></div>";
      }
      $("#fileUpload").html(out);
    });

    $('.typeselect').on('click',function()
    {
      alert('onready triggered');
    });

    $('.delete').on('click', function()
    {
      if(confirm("Are you sure you wish to delete this submission?"))
      {
        var deletelink = $(this).attr('goto');
        var projectID = $('#projectID').val();
        $('#ProjectView').load(deletelink);
        $('#ProjectView').load("?controller=project&action=viewAssignmentProject&quick=1&projectID="+projectID+"&type=submission");
      }
    });
});

function changeType(event)
{
  var thisClicked = event.target;
  var targetID = thisClicked.getAttribute('target');
  switch(thisClicked.value)
  {
    case 'file':
      $('#dataentry'+targetID).html("<input class='fileupload' id='data"+targetID+"' type='file' name='data[]' style='margin: 0 auto' required>");
      $('#format'+targetID).val('file');
      break;
    case'link':
      $('#dataentry'+targetID).html("<input class='fileupload' id='data"+targetID+"' type='text' name='data[]' placeholder='http://' required>");
      $('#format'+targetID).val('text');
      break;
    case 'image':
      $('#dataentry'+targetID).html("<input class='fileupload' id='data"+targetID+"' type='file' name='data[]' style='margin: 0 auto' required>");
      $('#format'+targetID).val('image');
      break;
    case 'text':
      $('#dataentry'+targetID).html("<textarea class='fileupload' id='data"+targetID+"' name='data[]' cols='75' rows='15' required></textarea>");
      $('#format'+targetID).val('text');
      break;
    }
}

function submission()
{
  var dataOUT = new Array();
  var numtoup = document.getElementById('numtoup').value;
  var tags = document.getElementById('tags');
  var formdata = new FormData();
  formdata.append("numtoup", numtoup);

  for(var i = 0; i < tags.options.length; i++)
  {
    if(tags.options[i].selected )
      formdata.append('tags[]', tags.options[i].value )
  }

  if(numtoup > 0)
  {
    for(var i = 0; i < numtoup; i++)
    {
      var format = document.getElementById('format'+i).value;
      var contentTitle = document.getElementById('contentTitle'+i).value;
      var contentCaption = document.getElementById('contentCaption'+i).value;
      formdata.append("format"+i, format);
      formdata.append("contentTitle"+i, contentTitle);
      formdata.append("contentCaption"+i, contentCaption);


      switch(format)
      {
        case 'link':

          formdata.append("data"+i, document.getElementById('data'+i).value);
          break;
        case 'text':
          formdata.append("data"+i, document.getElementById('data'+i).value);
          break;
        case 'image':
          formdata.append("data"+i, document.getElementById('data'+i).files[0]);
          break;
        case 'file':
          formdata.append("data"+i, document.getElementById('data'+i).files[0]);
          break;
        }
      }
    }

    var response;
    formdata.append("title", document.getElementById('title').value);
    formdata.append("description", document.getElementById('description').value);
    formdata.append("date", document.getElementById('date').value);
    formdata.append("time", document.getElementById('time').value);
    formdata.append("projectID", document.getElementById('projectID').value);
    formdata.append("author", document.getElementById('author').value);
    formdata.append("update", document.getElementById('update').value);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open('POST', '?controller=project&action=upload&quick=1',false);
    // xmlhttp.upload.onprogress = function(e) {
    //   if (e.lengthComputable) {
    //     var percentComplete = (e.loaded / e.total) * 100;
    //     console.log(percentComplete + '% uploaded');
    //   }
    // };
    xmlhttp.onload = function() {
      if (this.status == 200) {
        response = this.responseText.replace(/^\s+|\s+$/g, '');
      };
    };
    xmlhttp.send(formdata);
    //for (var pair of formdata.entries()) {
    //console.log(pair[0]+ ', ' + pair[1]);}
    $('#ProjectView').html(response);
  }
