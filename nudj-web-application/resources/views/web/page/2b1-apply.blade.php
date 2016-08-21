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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

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
        <a href="screen1.html"><img src="/assets/web-dc8ab01d/images/main-logo.jpg" alt="nudj"/></a>
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
<div class="container main remodal-bg">
    <div class="row ">
        <form id="form-f6799cbb" class="eight columns connect-form offset-by-two">
            <div class="center">
                <h6>Please enter your details so we can connect you to the hirer:</h6>
                <br>
            </div>
            <div class="ten columns offset-by-one">
                <label for="exampleEmailInput">Your name</label>
                <input class="input-field" type="text" placeholder="Enter your name" id="nameInput" name="nameInput">
                <label for="exampleEmailInput">Your email</label>
                <input class="input-field" type="email" placeholder="Enter your email" id="emailInput" name="emailInput">
                <label for="linkInput">Link to portfolio or Linkedin</label>
                <input class="input-field" type="text" placeholder="Enter link" id="linkInput" name="linkInput">
                <label for="referrerInput">Name of referrer</label>
                <input class="input-field" type="text" placeholder="Enter referrer" id="referrerInput" name="referrerInput">
                <div class="center">
                    <br>
                    <!-- 
                    <input id="submit-button-1ac6056d" data-remodal-target="confirmation-modal" class="button custom-button" type="submit" value="Confirm">
                    -->
                    <input id="submit-button-1ac6056d" class="button custom-button" type="button" value="Confirm">
                </div>
            </div>
        </form>
    </div>
    <div class="remodal" data-remodal-id="confirmation-modal" data-remodal-options="hashTracking: false">
        <h5 class="brand">Application successful</h5>
        <br>
        <p>We have sent your details to the hirer.</p>
        <p>Good luck!</p>
        <br>
        <button id="send-link" class="custom-button"  data-remodal-action="close">Ok, thank you</button>
    </div>
</div>

<!-- End of page-specific content
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
<script type="text/javascript" src="/assets/web-dc8ab01d/js/jquery-3.1.0.min.js"></script>
<script src="/assets/web-dc8ab01d/js/remodal.min.js"></script>
<script src="/assets/web-dc8ab01d/js/app.js"></script>

<!-- Page-specific Javascript
–––––––––––––––––––––––––––––––––––––––––––––––––– -->

<script>
$(document).delegate( "#send-link", "click", function() {
    location.href = '/appdownloads'
});    
$(document).delegate( "#submit-button-1ac6056d", "click", function() {
    $.ajax({
        url: '/applicationdetails',
        type: 'post',
        dataType: 'json',
        data: $('#form-f6799cbb').serialize(),
        success: function(data) {
            console.log(data);
        }
    });
});    
</script>

</body>
</html>
