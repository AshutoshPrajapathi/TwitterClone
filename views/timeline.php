<div class="container mainContainer">
<div class="row">
  <div class="col-md-8">
    <h2>Tweets For You</h2>
   <?php if(array_key_exists('id',$_SESSION)){
    displayTweets('yourtweets'); 
   }else{
    displayTweets('notLoggedIn');
   }?>
  </div>
  <div class="col-md-4">
    <?php displaySearch(); ?>
    <hr>
    <?php displayTweetBox(); ?>
  </div>
</div>

</div>