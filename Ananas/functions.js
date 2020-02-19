// FUNCTIONS TO SEARCH TAGS
// connect to sql with javascript onclick 

$('#button_id').click(function(e) { 
  e.preventDefault();
  // button action
});

$.ajax({
  url: "tweet_aca_text.sql",
  context: document.body,
  data: 'title='+$('#title').val(),
  success: function(){
    alert('ajax file called');
  }
});
