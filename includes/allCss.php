  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  
  <!--  Bootstrap -->
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
 
 
  <!--  FontAwesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="/includes/font-awesome.min.css">
 
 <style> 
body {
  padding-top: 70px;
  padding-bottom: 30px;
}

h4, h1.error, h2.error, h3.error, span.error {
  color: indianred;
  font-weight: bold;
}

.theme-dropdown .dropdown-menu {
  position: static;
  display: block;
  margin-bottom: 20px;
}

.theme-showcase > p > .btn {
  margin: 5px 0;
}

.theme-showcase .navbar .container {
  width: auto;
}

/*  ------ New generic styles for 2017------  */

.conditional-info {
  display: none;
}
.subsection {    
  font-size: 1.1em;
  font-weight: bold;
  color: steelblue;
}
table.counting th {
    text-align: center;
}
table .expanded {
  display: none;
}
.action {
  color: blue;
  text-decoration: underline;
}
th.subdued, td.subdued {
  color: lightgray;
}
.multi-report td:first-child::before {
 font-size: 10pt;
 font-family: 'FontAwesome';
 text-decoration: none;
 content: '\f0c0';
}
.multi-report td.mismatch {
  background-color: orange;
}
/*  ------ Steamworks styles -------  */

.sw {
  /* font-size: 10pt;  */
  /* font-family: 'FontAwesome';  */
  /* text-decoration: none;  */
  background-image: url('/includes/steamworks_sprite.png');
  background-repeat: no-repeat;
  display: block;
  width: 20px;
  height: 20px;
}
.sw-mobility {
  /* content: '\f050'; -- use :before in selector if using fontawesome */
  background-position: -183px 0px;
}
.sw-gear {
  /* content: '\f013';  */
  /* color: #dd3;  */
  width: 18px;
  background-position: -121px 0px;
}
.sw-hopper {
  /* content: '\f2d0';  */
  background-position: -161px 0px;
}
.sw-highshot {
  width: 18px;
  background-position: -140px 0px;
}
.sw-lowshot {
  background-position: -143px -21px;
}
.sw-fuel {
  /* content: '\f1e3';  */
  background-position: -122px -21px;
}
.sw-arena {
  width: 126px;
  height: 47px;
  background-position: -115px -41px;
}
.sw-rope {
  width: 15px;
  height: 34px;
  background-position: -100px -41px;
}
.sw-touchpad {
  /* content: '\f011';  */
  /* color: red;  */
  background-position: -200px -21px;
}
.sw-defense {
  background-position: -180px -21px;
}
.sw-scout {
  background-position: -162px -21px;
}

/*  ------ New styles for 2016------  */

label {
  vertical-align: middle;
}

table td {
  padding: 4px;
}

input[type=number]{
    width: 60px;
} 

/*  ------ New redone for Steamworks ------  */
.minus, .plus {
  background-image: url('/includes/steamworks_sprite.png');
  background-repeat: no-repeat;
  display: inline-block;
  height: 20px;
  width: 20px;
  vertical-align: middle;
  margin-left: 4px;
  margin-right: 4px;
  cursor: pointer;
}
.minus {
  background-position: -101px -21px;
}
.plus {
  background-position: -101px 0px;
}

/*  ------ Stronghold styles ------  */

.defense {
  background-image: url('/includes/strongholdSprites.png');
  background-repeat: no-repeat;
  display: block;
  height: 106px;
}
.portcullis {
  width: 80px;
  background-position: 0px -59px;
}
.chevaldefrise {
  width: 115px;
  height: 87px;
  background-position: -84px -85px;
}
.moat {
  height: 60px;
  width: 105px;
  background-position: 0px -167px;
}
.ramparts {
  width: 90px;
  height: 64px;
  background-position: -105px -167px;
}
.drawbridge {
  width: 98px;
  background-position: 0px -223px;
}
.sallyport {
  width: 98px;
  height: 67px;
  background-position: -94px -266px;
}
.rockwall {
  width: 112px;
  height: 58px;
  background-position: 0px -326px;
}
.roughterrain {
  width: 89px;
  height: 60px;
  background-position: -110px -329px;
}
.lowbar {
  width: 105px;
  height: 55px;
  background-position: 0px -379px;
}


.defense-sm {
  background-image: url('/includes/strongholdSprites.png');
  background-repeat: no-repeat;
  display: block;
  height: 40px;
  width: 25px;
}
.portcullis-sm {
  background-position: 0px -697px;
}
.chevaldefrise-sm {
  background-position: -25px -697px;
}
.moat-sm {
  background-position: -50px -697px;
}
.ramparts-sm {
  background-position: -75px -697px;
}
.drawbridge-sm {
  background-position: -100px -697px;
}
.sallyport-sm {
  background-position: -125px -697px;
}
.rockwall-sm {
  background-position: -150px -697px;
}
.roughterrain-sm {
  background-position: -175px -697px;
}
.lowbar-sm {
  height: 16px;
  background-position: 0px -736px;
}
</style>