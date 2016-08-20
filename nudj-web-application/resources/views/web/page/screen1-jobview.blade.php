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
<div class="container main">
  <div class="row">
  <div class="ten columns offset-by-one">

<div class="eight columns bubble">
  <div class="alt-logo-wrapper">
    <img class="alt-logo" src="/assets/web-dc8ab01d/images/alt-logo2.png" alt="logo"/>
  </div>
  <div class="rectangle">
    <p>Hey! We’re using nudj to help us hire but need some help. <br> Do you know anyone who might be interested in this job? </p>
    <div class="triangle">
    </div>
  </div>
</div>

<div class="whiteframe listing center">
  <h5 class="brand">{{$job->title}}</h5>
  <h6 class="brand"><i class="fa fa-home"></i>{{$job->company}}</h6>
  <h6 class="brand"><i class="fa fa-map-marker" aria-hidden="true"></i>{{$job->location}}</h6>
  <div class="listing-spec">
    <label>Posted:</label> <p>{{$posted_at}}</p> <br>
    <label>Salary:</label> <p>{{$job->salary}}</p> <br>
    @if($job->bonus>0)
    <label>Referral bonus:</label><p>{{$job->bonus_currency}} {{$job->bonus}}</p> <br>
    @endif
  </div>
  <span class="more ten columns offset-by-one">{{$job->description}}</span>
  <section class="tag-wrapper">
    @foreach ($skills as $skill)
        <button id="send-link" class="tag">{{$skill->name}}</button>
    @endforeach
  </section>
  <hr>
  <img src="/assets/web-dc8ab01d/images/banner.png" alt="nudj"/>
</div>

<section class="listing-buttons">
  <a href="/applying/{{$job->id}}" class="button custom-button alt-button left">I'll apply</a>
  <a href="/nudj-a-friend/{{$job->id}}" class="button custom-button right">Nudj a friend</a>
</section>

  </div>
  </div>
</div>

<!-- End of page-specific content
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
<script type="text/javascript" src="/assets/web-dc8ab01d/js/jquery-3.1.0.min.js"></script>
<script src="/assets/web-dc8ab01d/js/remodal.min.js"></script>
<script src="/assets/web-dc8ab01d/js/app.js"></script>
</body>
</html>
