<footer class="footer">
   <div class="container">
      <p>&copy;Developed by Ashu</p>
   </div>


 </footer>

 
 
 
 
 <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="loginModalTittle">Login</h4>
      </div>
      <div class="modal-body">
         <div class="alert alert-danger" id="loginAlert">

         </div>
      <form>
         <input type="hidden" id="loginActive" name="loginActive" value="1">

         <div class="form-group">
               <label for="email">Email</label>
               <input type="email" class="form-control" id="email" placeholder="Email  address">
         </div>

         <div class="form-group">
               <label for="password">Password</label>
               <input type="text" class="form-control" id="password" placeholder="Password">
         </div>
  
   </form>

      <div class="modal-footer">
         <a id="togglelogin" >Signup</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="loginSignupButton">Login</button>
      </div>
    </div>
  </div>
</div>

<script>
   $("#togglelogin").click(function(){
      if($("#loginActive").val() == "1"){
         $("#loginActive").val("0");
         $("#loginModalTittle").html("Signup");
         $("#loginSignupButton").html("Signup");
         $("#togglelogin").html("Login");
      }else{
         $("#loginActive").val("1");
         $("#loginModalTittle").html("Login");
         $("#loginSignupButton").html("Login");
         $("#togglelogin").html("Signup");
      }

   });
   $("#loginSignupButton").click(function(){
      $.ajax({
         type:"POST",
         url:"actions.php?action=loginSignup",
         data:"email="+$("#email").val()+"&password="+$("#password").val()+"&loginActive="+$("#loginActive").val(),
         success:function(result) {
            if(result == "1"){
               window.location.assign("http://localhost/twitter/");
            }else{
               $("#loginAlert").html(result).show();

            }
         }
      })

   });

   $(".toggleFollow").click(function(){
      var id=$(this).attr('data-userId');
      $.ajax({
         type:"POST",
         url:"actions.php?action=toggleFollow",
         data:"userId="+id,
         success:function(result) {
          if(result == "1"){
            $("a[data-userId='"+id+"']").html("Follow");
          }else if(result == "2"){
            $("a[data-userId='"+id+"']").html("Unfollow");
            }
         }
      })
   });

   $("#postTweetButton").click(function(){
      $.ajax({
         type:"POST",
         url:"actions.php?action=postTweet",
         data:"tweetContent="+ $("#tweetContent").val(),
         success:function(result) {
          if(result=='1'){
            $("#tweetSuccess").show();
            $("#tweetFail").hide();
          }else if(result != ""){
            $("#tweetFail").html(result).show();
            $("#tweetSuccess").hide();
          }
         }
      })
   });
</script>



  </body>
</html>