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
<div class="container main">
  <div class="row ">

  <div class="eight columns connect-form offset-by-two">
    <div class="center">
      <h5>Know someone great for this job?</h5>
      <div class="whiteframe">
        <h5>{{$job->title}} ({{$job->location}})</h5>
        <div class="plane-wrapper">
          <img src="/assets/web-dc8ab01d/images/plane.png" alt="plane" />
        </div>
      </div>
      <p>If you have an iPhone, you can get our free app to Nudj them.</p>
      <p>You get rewarded if they get hired.</p>
      <br>
      <p class="space">Don’t have an iPhone? You can still share a link with them.</p>

      <section class="options">
        <button data-remodal-target="share-modal" class="custom-button left">Share</button>
        <button data-remodal-target="appstore-modal" class="custom-button right">Download Nudj</button>
      </section>
      <br>
  </div>
  </div>
</div>
</div>

<div class="remodal" data-remodal-id="share-modal" data-remodal-options="hashTracking: false">
  <button data-remodal-action="close" class="remodal-close right"></button>
  <h5>Share via</h5>
  <button id="link" class="custom-button share">Copy Link</button>
  <button id="email" class="custom-button share">E-mail</button>
  <button id="messenger" class="custom-button share">Facebook Messenger</button>
  <button id="facebook" class="custom-button share">Facebook</button>
  <button id="twitter" class="custom-button share">Twitter</button>
</div>

<div class="remodal" data-remodal-id="appstore-modal" data-remodal-options="hashTracking: false">
  <button data-remodal-action="close" class="remodal-close right"></button>
  <p class="space">You will be redirected to the app store.</p>
  <button id="download" class="custom-button">Download now</button>
  <p class="line-around"> <span><strong>Not on a mac?</strong></span></p>
  <p>Enter your email and we'll send you a link</p>
  <input type="email" placeholder="enter your email here" id="contact-email">
  <button id="send-link" class="custom-button alt-button">Send me a link</button>
</div>

<!-- End of page-specific content
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
<script type="text/javascript" src="/assets/web-dc8ab01d/js/jquery-3.1.0.min.js"></script>
<script src="/assets/web-dc8ab01d/js/remodal.min.js"></script>
<script src="/assets/web-dc8ab01d/js/app.js"></script>
</body>
</html>
