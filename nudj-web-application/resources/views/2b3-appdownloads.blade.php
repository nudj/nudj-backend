<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>NudJ</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href='https://fonts.googleapis.com/css?family=Raleway:500,700' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto:400' rel='stylesheet' type='text/css'>

  <!-- MODAL
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="/assets/web-dc8ab01d/stylesheets/remodal.css">
  <link rel="stylesheet" href="/assets/web-dc8ab01d/stylesheets/remodal-default-theme.css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="/assets/web-dc8ab01d/stylesheets/reset.css">
  <link rel="stylesheet" href="/assets/web-dc8ab01d/stylesheets/normalize.css">
  <link rel="stylesheet" href="/assets/web-dc8ab01d/stylesheets/skeleton.css">
  <link rel="stylesheet" href="/assets/web-dc8ab01d/stylesheets/style.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="shortcut icon" href="/assets/web-dc8ab01d/images/favicon.ico" type="image/x-icon">
  <link rel="icon" href="/assets/web-dc8ab01d/images/favicon.ico" type="image/x-icon">

</head>
<body>

  <!-- Shared header
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
<header>
  <div class="container">

      <div class="logo">
        <a href="/"><img src="/assets/web-dc8ab01d/images/main-logo.jpg" alt="nudj"/></a>
        <p>The Talent Referral App</p>
      </div>

      <div class="intro">
        <p>Find your dream job or help your friends find theirs. </p>
        <p>Download the app to see who's hiring.</p>
      </div>

  </div>
</header>

<!-- Page-specific content
–––––––––––––––––––––––––––––––––––––––––––––––––– -->
<div class="container main">
  <div class="row ">
    <div class="ten columns offset-by-one">
      <div class="center">
      <h6>Got an iphone? Download our free app to see who else is hiring</h6>
    </div>
    <div class="eight columns offset-by-two">
    <img class="iphone" src="/assets/web-dc8ab01d/images/iphone.png" alt="phone" />

    <section class="listing-buttons">
        <button id="1f71033c-9370" class="link">Send me a link</button>
        <img id="app-store-download-8cbab945" src="/assets/web-dc8ab01d/images/appstore.svg" alt="appstore" />
    </section>
  <br>
  </div>
</div>
</div>
</div>

<div class="remodal" data-remodal-id="email-has-been-sent-a1456508" data-remodal-options="hashTracking: false">
    <h5 class="brand">Email sent</h5>
    <br>
    <p>An email has been sent to you.</p>
    <br>
    <button id="final-button-0a1f8e2b" class="custom-button"  data-remodal-action="close">Ok, thank you</button>
</div>

<!-- End of page-specific content
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
<script type="text/javascript" src="/assets/web-dc8ab01d/js/jquery-3.1.0.min.js"></script>

<!-- https://github.com/VodkaBears/Remodal -->
<script src="/assets/web-dc8ab01d/js/remodal.min.js"></script>
<script src="/assets/web-dc8ab01d/js/app.js"></script>

<!-- Page-specific Code
–––––––––––––––––––––––––––––––––––––––––––––––––– -->

<style>
#app-store-download-8cbab945 {
    cursor: pointer; 
    cursor: hand;
}
</style>

<script>
$(document).delegate( "#1f71033c-9370", "click", function() {
    $.ajax({
        url: '/send-link-to-candidate-1a345374/{{$applicationuuid}}',
        type: 'post',
        dataType: 'json',
        data: null,
        success: function(data) {
            console.log("An email have been sent to you")
            var inst = $('[data-remodal-id=email-has-been-sent-a1456508]').remodal();
            inst.open();
        }
    });    
}); 
$(document).delegate( "#app-store-download-8cbab945", "click", function() {
    location.href = 'https://geo.itunes.apple.com/gb/app/nudj-the-talent-referral-app/id1081609782?mt=8'
});    
</script>

</body>
</html>
