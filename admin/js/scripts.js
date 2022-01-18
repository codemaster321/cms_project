
    tinymce.init({
      selector: 'textarea',
      plugins: 'a11ychecker advcode casechange export formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
      toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter pageembed permanentpen table',
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
    });




$(document).ready(function()
{


  $('.selectAllBoxes').click(function(event)
{

  if(this.checked)
  {
     $('.checkBoxes').each(function()
   {
     this.checked=true;
   });
  }
  else
  {
    $('.checkBoxes').each(function()
  {
    this.checked=false;
  });
  }


});


var div_box= "<div id='load-screen'><div id='loading'></div></div>";

$("body").prepend(div_box);

$("#load-screen").delay(700).fadeOut(600,function()
{
  $(this).remove();
});

});



function loadUsersOnline()
{
  $.get("functions.php?usersonline=result",function(data)
{
  $(".usersonline").text(data);
});
}


setInterval(function()
{
  loadUsersOnline();
},500);
