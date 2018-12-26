<!DOCTYPE html>
<html lang="en">
<head>
<title>Medica-vaccination schedule</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!--custom css-->
<style>

.login-block{
    background: #DE6262;  /* fallback for old browsers */
background: -webkit-linear-gradient(to bottom, #FFB88C, #DE6262);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to bottom, #FFB88C, #DE6262); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
float:left;
width:100%;
padding : 50px 0;
height:100%;
}
.banner-sec{background:url(../../../assets/images/pexels-photo.jpg)  no-repeat left bottom; background-size:cover; min-height:500px; border-radius: 0 10px 10px 0; padding:0;}
.container{background:#fff; border-radius: 10px; box-shadow:15px 20px 0px rgba(0,0,0,0.1);}
.carousel-inner{border-radius:0 10px 10px 0;}
.carousel-caption{text-align:left; left:5%;}
.login-sec{padding: 50px 30px; position:relative;}
.login-sec .copy-text{position:absolute; width:80%; bottom:20px; font-size:13px; text-align:center;}
.login-sec .copy-text i{color:#FEB58A;}
.login-sec .copy-text a{color:#E36262;}
.login-sec h2{margin-bottom:30px; font-weight:800; font-size:30px; color: #DE6262;}
.login-sec h2:after{content:" "; width:100px; height:5px; background:#FEB58A; display:block; margin-top:20px; border-radius:3px; margin-left:auto;margin-right:auto}
.btn-login{background: #DE6262; color:#fff; font-weight:600;}
.banner-text{width:70%; position:absolute; bottom:40px; padding-left:20px;}
.banner-text h2{color:#002166; font-weight:600;}
.banner-text h2:after{content:" "; width:100px; height:5px; background:#FFF; display:block; margin-top:20px; border-radius:3px;}
.banner-text p{color:#002166;}    
    
.error-login{
    width: 100%;
    margin-top: .25rem;
    font-size: 80%;
    color: #dc3545;
}    
    
</style>
<!-- https://bootsnipp.com/snippets/featured/login-screen-with-form -->
</head>
<body>
    <section class="login-block" style="height:700px;">
    <div class="container">
	<div class="row">
		<div class="col-md-4 login-sec">
		    <h2 class="text-center">Login Now</h2>
                    
                    <?php echo $this->session->flashdata('msg'); ?>
                  
                    <form class="login-form" name="loginfrm" method="post" action="<?php echo(base_url());?>Login/check_login">
                      <div class="form-group">
                        
                        <label for="hospital" class="text-uppercase">HOSPITAL</label>
                        <select class="form-control" name="hospital_id" id="hospital_id">
                          <option value="">Select..</option>
                          <?php
                         foreach ($hospital_details as $hospital) {
                            echo "<option value=".$hospital->hospital_id.">".$hospital->hospital_name."</option>";
                             
                         }
                        ?>                                                     
                        </select>
                        <?php echo form_error('hospital_id'); ?>

                      </div>
                        <div class="form-group">
                            <label for="username" class="text-uppercase">Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="User name">
                            <?php echo form_error('username'); ?>

                        </div>
                        <div class="form-group">
                            <label for="userpassword" class="text-uppercase">Password</label>
                            <input type="password" id="userpassword" name="userpassword" class="form-control" placeholder="Password">
                        <?php echo form_error('userpassword'); ?>
                        </div>


                        <div class="form-check">
                            <!--    <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input">
                                  <small>Remember Me</small>
                                </label>-->
                            <button type="submit" class="btn btn-login float-right">Submit</button>
                        </div>

                    </form>

		</div>
		<div class="col-md-8 banner-sec">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
<!--                 <ol class="carousel-indicators">-->
<!--                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>-->
<!--                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>-->
<!--                  </ol>-->
            <div class="carousel-inner" role="listbox">
<!--    <div class="carousel-item ">-->
      <img class="d-block img-fluid" src="../../../assets/images/pexels-photo.jpg" alt="First slide">
      <div class="carousel-caption d-none d-md-block">
        <div class="banner-text">
            <h2>This is Heaven</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
        </div>	
  </div>
<!--    </div>-->
<!--    <div class="carousel-item">
      <img class="d-block img-fluid" src="https://images.pexels.com/photos/7097/people-coffee-tea-meeting.jpg" alt="First slide">
      <div class="carousel-caption d-none d-md-block">
        <div class="banner-text">
            <h2>This is Heaven</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
        </div>	
    </div>
    </div>-->
<!--    <div class="carousel-item">
      <img class="d-block img-fluid" src="https://images.pexels.com/photos/872957/pexels-photo-872957.jpeg" alt="First slide">
      <div class="carousel-caption d-none d-md-block">
        <div class="banner-text">
            <h2>This is Heaven</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
        </div>	
    </div>
  </div>
            </div>	   -->
		    
		</div>
	</div>
</div>
    </div>
</section>

</body>
</html>

