<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom-login.css'); ?>">
<body>
    <div class="container">
        <div class="row">
            <div class="col s12 m4 l4 offset-m4 offset-l4 custom-form">
                <h2 class="center-align">Login</h2>
                <div class="row">
                    <form class="col s12" action="<?php echo site_url('home/login'); ?>" method="post">
                        <div class="row">
                            <div class="input-field col s12">
                                <input name="username" id="username" type="text" class="validate">
                                <label for="username">Username</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input name="pwd" id="pass" type="password" class="validate">
                                <label for="pass">Password</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <p>
                                    <input type="checkbox" id="remember">
                                    <label for="remember">Remember me</label>
                                </p>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="row">
                            <div class="col m12">
                                <p class="right-align">
                                    <button class="btn btn-large waves-effect waves-light" type="submit" name="action">Login</button>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col s12 m4 l6 offset-m4 offset-l3">
                <p class="center">
                    lorem ipsum dollor sit amet basalsflaskdlajfllorem ipsum dollor sit amet basalsflaskdlajfllorem ipsum dollor sit amet basalsflaskdlajfllorem ipsum dollor sit amet basalsflaskdlajfl
                </p>
            </div>
        </div>
    </div>
</body>